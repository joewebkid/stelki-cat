<?php

namespace app\modules\staff\commands;

use app\models\Metro;
use app\models\ImportUrls;
use yii\console\Controller;
// use yii\console\widgets\Table;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;
// use yii\helpers\VarDumper;

use app\models\AdminResidentialObject;
use app\models\ResidentialObject;
use app\models\User;

class ApiController extends Controller
{
	public function actionUpdateMetro()
	{
		$opts = array(
			'http'=>array(
				'method'=>"GET",
				'header'=>"Accept-language: ru\r\n" .
				"Cookie: foo=bar\r\n"
			)
		);

		$context = stream_context_create($opts);
		$url = 'https://api.hh.ru/metro/1';

		$lines = file_get_contents($url, false, $context);

		$lines = json_decode($lines);
		// $lines = current($lines);
		// print_r($lines);
		$i=0;
		foreach ($lines->lines as $key => $metros) {
			$lineId = $metros->id;
			$color = $metros->hex_color;

			foreach ($metros->stations as $key => $metro) {
//				print_r($metro);
				$i++;
				if(!Metro::find()->where(['name'=>$metro->name,'line_id'=>$lineId])->one()){
					if(!( $model=(new Metro(['name'=>$metro->name,'line_id'=>$lineId,'color'=>$color,'metro_lat'=>$metro->lat,'metro_lng'=>$metro->lng])) )->save()) {
						print_r($model->firstErrors);
					}
				}
			}
		}

		$this->stdout("*** create metro ".$i."\n", Console::FG_YELLOW, Console::BOLD);
		return 0;
	}
	public function actionImportObjects($flag=0)
	{
		$model = ImportUrls::find()->all();
		// $this->import(next($model)->path,$flag);exit;
		foreach ($model as $key => $value) {
			echo $value->path."\n---------\n";
			sleep(0.5);
			$this->import($value->path,$flag);
			sleep(5);
		}
	}
	public function import($value='',$flag)
	{

		$xmlObject = simplexml_load_file($value);
		unset($xmlObject->feed_version);

		$i=0;
		foreach ($xmlObject as $key => $value) {
			$i++;
			$year = current($value->Building->BuildYear);
			if(isset($year)) {
				if( $year==2018 || $year ==2019 ) {
					continue;
				}
			}

			$type = AdminResidentialObject::getTypeFromXml(current($value->Category));

			if($type===false) continue;

			$subagent = $value->SubAgent;
			$phone = $value->Phones->PhoneSchema->CountryCode.$value->Phones->PhoneSchema->Number;
			$login = $subagent->Email??$phone;

			if(!($user = User::find()->where(['login'=>$login])->one()) ) {
				if($login) {
					$tmp = explode('.', $login);
					$password = current($tmp);
					if( (($user = new User())->load([
						'User' => [
							'login'=>(string)$login,
							'pwhash'=>\Yii::$app->security->generatePasswordHash($password),
							'name'=>$subagent->LastName.' '.$subagent->FirstName,
							'phone'=>str_replace('.','',$subagent->Phone),
						]
					])) ) {
						if( !$user->save() ) {
							$this->stdout(\Yii::t('app',"Ошибка сохранения нового пользователя $login: {e}\n",
								['e' => current($user->firstErrors) ]), Console::FG_RED, Console::BOLD);
							continue;
						}
					}
				}else {
					if($value->Phones->PhoneSchema) {
						$tmp = explode('.', $phone);
						$password = current($tmp);
						if( (($user = new User())->load([
							'User' => [
								'login'=>(string)$phone,
								'pwhash'=>\Yii::$app->security->generatePasswordHash($password),
								'phone'=>$phone,
							]
						])) ) {
							if( !$user->save() ) {
								$this->stdout(\Yii::t('app',"Ошибка сохранения нового пользователя $login: {e}\n",
									['e' => current($user->firstErrors) ]), Console::FG_RED, Console::BOLD);
								continue;
							}
						}
					}
				}
			}

			if(!$kadastr = (string)$value->CadastralNumber)
				$kadastr = (string)current($value->ExternalId);


			if($newObject = ResidentialObject::find()->where(['kadastr'=>$kadastr])->one()) {
				if($flag) continue;
				$newObject = AdminResidentialObject::findOne($newObject->id);
			}else{
				$newObject = new AdminResidentialObject(['kadastr'=>$kadastr]);
			}

			if(!$newObject->address->parseAddressFromXml($value->Address)) {
				$this->ansiFormat("Ошибка в адресе нет квартиры в выгрузке или иного порядка\n", Console::FG_RED, Console::BOLD);
			}

			if($newObject->address->city!='Москва')
				continue;

			$currenciesEur = $newObject->getUsdCurr();

			$newObject->name = "Квартира ".$value->FlatRoomsCount."к. ";
			$newObject->is_penthouse = (int)$value->IsPenthouse ?? 0;
			$newObject->is_apartment = (int)$value->IsApartments ?? 0;
			$newObject->sale_price = 0;

			if($value->BargainTerms->Currency=='usd'){
				$currenciesUsd = $newObject->getUsdCurr();
				$newObject->regular_price = round((int)current($value->BargainTerms->Price)*$currenciesUsd,-3);
			}elseif($value->BargainTerms->Currency=='eur'){
				$currenciesEur = $newObject->getEurCurr();
				$newObject->regular_price = round((int)current($value->BargainTerms->Price)*$currenciesEur,-3);
			}else{
				$newObject->regular_price = (int)current($value->BargainTerms->Price);
			}
			$newObject->desc_common = explode("#",current($value->Description))[0];
			$newObject->rooms_quantity = (int)current($value->FlatRoomsCount);
			$newObject->floors_quantity = (string)current($value->Building->FloorsCount);
			$newObject->current_floor = (string)current($value->FloorNumber);
			$newObject->common_area = (string)current($value->TotalArea);
			$newObject->kitchen_area = (string)current($value->KitchenArea);

			// $this->stdout("Основная информация об объекте получена\n", Console::FG_GREEN, Console::BOLD);

			$newObject->user_id = (string)$user->id;
			$newObject->properties->repair = (string)current($value->RepairType);
			$newObject->properties->balcony = (string)current($value->BalconiesCount);
			$newObject->properties->loggia = (string)current($value->LoggiasCount);

			$newObject->properties->separate_bathroom = (string)current($value->SeparateWcsCount);
			$newObject->properties->mixed_bathroom = (string)current($value->CombinedWcsCount);

			$newObject->properties->passenger_elevator = (string)current($value->Building->PassengerLiftsCount);
			$newObject->properties->freight_elevator = (string)current($value->Building->CargoLiftsCount);

			$newObject->properties->construction_year = (string)current($value->Building->BuildYear);
			$newObject->properties->ceiling_height = (string)current($value->Building->CeilingHeight);
			$newObject->properties->ceiling_height = (string)current($value->Building->CeilingHeight);
			$newObject->properties->chute = (string)current($value->Building->HasGarbageChute);

			if($value->Building->Parking->Type)
				$newObject->properties->parking = (int)current($value->Building->Parking->Type)?0:3;
			else
				$newObject->properties->parking = 3;
			$newObject->properties->parking = (string)$newObject->properties->parking ;

			$newObject->properties->ramp = (string)current($value->HasRamp);

			$newObject->properties->setHouseTypeNameFromXml(current($value->Building->MaterialType));

			$this->stdout("    > object properties obtained\n", Console::FG_GREEN, Console::BOLD);

			if(!$value->Coordinates){
				$newObject->setCoordsFromXml($value->Address);
			}
			else{
				$newObject->coord_lat = (string)$value->Coordinates->Lat;
				$newObject->coord_lng = (string)$value->Coordinates->Lng;
			}					
			$newObject->address->alternative_name = $value->JKSchema->Name;

			if(!isset($newObject->metro[0])&&$newObject->metro[0]){
				$newObject->setMetroFromXml($value->Address);
			}else{				
				$newObject->setMetroFromXml($value->Address);
				$newObject->metro[0]->metro_time = (string)$newObject->metro[0]->metro_time; 
				if(isset($newObject->metro[1])){
					$newObject->metro[1]->metro_time = (string)$newObject->metro[1]->metro_time;
				}
			}

			$this->stdout("    > object address obtained\n", Console::FG_GREEN, Console::BOLD);

			if(!$newObject->photosPaths&&$value->Photos->PhotoSchema!=NULL)
				$newObject->setPhotoFromXml($value->Photos->PhotoSchema);

			if( !$newObject->consoleSave() ) {              
				$this->stdout(\Yii::t('app',"*** error saving object: $newObject->name: {e}\n",
					['e' => current($newObject->firstErrors) ]), Console::FG_RED, Console::BOLD);
			}else{				
				$this->stdout(" id:".$newObject->id."\n", Console::FG_YELLOW, Console::BOLD);
				$this->stdout($newObject->address->addressWithoutCity."\n", Console::FG_GREEN, Console::BOLD);
				$this->stdout("\n");
			}		
			
			if( !$newObject->address->street || is_numeric(trim($newObject->address->street)) || $newObject->address->house_num==0 )	{
				// print_r($value->address->Coordinates);
				$street = $newObject->address->getAddressFromCoords($newObject->coord_lng,$newObject->coord_lat);
				if(strpos($street, ',') !== false) {
					$tempArray = explode(',',$street);
					$street = $tempArray[0];
					if(isset($tempArray[1])) {
						$house = $tempArray[1];
						$newObject->address->house_num = $house;
					}
				}
				$newObject->address->street = $street;

				// 
			}
		}
		$this->stdout("*** all objects from the load ".$i."\n", Console::FG_YELLOW, Console::BOLD);
	}
}