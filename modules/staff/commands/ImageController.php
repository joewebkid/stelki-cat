<?php

namespace app\modules\staff\commands;

use Yii;
use yii\console\Controller;

use yii\helpers\ArrayHelper;
use yii\helpers\Console;

use app\models\Photos;

class ImageController extends Controller
{	
	public function actionF()
	{
        $dest = Yii::getAlias('@app').'/../html/upload/';
        $filelist = array();

	    if($handle = opendir($dest)){
	        while($entry = readdir($handle)){
	        	if($entry=='.'||$entry==''||$entry=='..'||$entry=='small') continue;
	        	$filelist[] = $entry;
			// $this->stdout("$entry\n", Console::FG_YELLOW, Console::BOLD);
	        }
	       
	        closedir($handle);
	    }
	    $lena = count($filelist)-1;
	    $i=0;
		$photos = Photos::find()->all();
		foreach ($photos as $key => $p) {
			$p->path=$filelist[$i];
			$p->save();
			$this->stdout("$filelist[$i]\t$key\t$p->path\n", Console::FG_YELLOW, Console::BOLD);
			$i++;	
			if($i>=$lena) {
				$i=0;
			}
		}
		return 0;
	}
	public function actionUpdateSize($newWidth = 270, $path = 'small/')
	{
        $dest = Yii::getAlias('@app').'/../html/upload/';
		$photos = Photos::find()->all();
		foreach ($photos as $key => $value) {	
			if(file_exists( $dest . $value->path))	{	
				// $this->stdout("    > $value->path\n", Console::FG_GREEN, Console::BOLD);continue;
				$this->stdout("$dest . $value->path\n", Console::FG_YELLOW, Console::BOLD);
				list($sourceWidth, $sourceHeight, $sourceType) = getimagesize( $dest . $value->path);

	            $newHeight = $sourceHeight * ($newWidth / ($sourceWidth/100)) / 100;

	            $tinyImage = imagecreatetruecolor($newWidth, $newHeight);

	            switch ($sourceType) {
	                case 2:
	                    $sourceImage = imagecreatefromjpeg($dest .$value->path);
	                    break;
	                case 3:
	                    $sourceImage = imagecreatefrompng($dest .$value->path);
	                    break;
	                default:
	                    $sourceImage = imagecreatefrompng($dest .$value->path);
	            }

	            imagecopyresampled($tinyImage, $sourceImage, 0, 0, 0, 0,  $newWidth, $newHeight, $sourceWidth, $sourceHeight);
	            imagejpeg($tinyImage, $dest . $path . $value->path);
	        }
		}
	}
}