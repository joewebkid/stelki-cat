<div class="">
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="content">
	<div class="filterMap" id="filterMap"></div>
<!-- 
				
		    -->
</div>
<?php
$script = <<< JS
    var clusterer
    coords = $coords
    console.log(coords)
    getCard = (properties) => {
        console.log(properties)
        return '<div class="last-apartments__card last-apartments__card__map">'+
		    '<a href="/catalog/view/'+(properties.id)+'" target="_blank">'+
		       '<div class="last-apartments__card-photo" style="background: url('+properties.img+');background-size: cover;background-position: center;">'+
		        '</div>'+
		        '<div class="last-apartments__card-info">'+
		            '<div class="last-apartments__card-top-info">'+
		                '<span class="rooms">'+properties.type+'</span>'+
		                '<span class="area">'+properties.district+' </span>'+
		                '<span class="floor">'+                    
		                    '<span class="area">'+properties.area+' м<sup>2</sup></span>'+
		                '</span>'+
		            '</div>'+
		            '<div class="last-apartments__card-name">'+
		                properties.name+
		            '</div>'+
		            '<div class="last-apartments__card-price">'+
		                '<span class="price">'+properties.price+' <span class="rub">&#8381;</span></span>'+
		                '<span class="price-for-m"> <span class="rub"></span> <sup></sup></span>'+
		            '</div>'+
		            '<div class="last-apartments__card-address">'+
		                properties.address+
		            '</div>'+
		        '</div>'+ 
		        
		    '</a>'+
		'</div>'
    }
    function init() {
    	coordLat=false
    	coordLng=false
        var objectsMap = new ymaps.Map('filterMap', {
            center: [coordLat||59.939032, coordLng||30.315827],
            zoom: 9,
            controls: ['zoomControl']
        }, {
            searchControlProvider: 'yandex#search',
            suppressMapOpenBlock: true
        });

        version = ymaps.meta.version.replace(".", "-").replace(".", "-")
        var styleNode = document.createElement('style');
        styleNode.type = "text/css";
        css = '.ymaps-'+version+'-balloon__layout {background: transparent!important; }'

        css += '.ymaps-'+version+'-balloon__close-button {'+
        'background: url(/images/icons/cards.svg) #ffffffad no-repeat 50%!important;'+
        'height: 30px!important;padding: 5px;'+
        'border-radius: 50%;'+
        'opacity:1!important;'+
        'box-sizing: border-box!important;'+
        'width: 34px!important;'+
        'height: 34px!important; }'

        css += '.ymaps-'+version+'-default-cluster {'+
        'width: 48px!important;'+
        'height: 48px!important;'+
        'border-radius: 50%!important;'+
        'box-shadow: 0px 5px 20px 0 rgba(0, 0, 0, 0.1);'+
        'background-color: #ffffff!important;'+
        'border: solid 4px #ffffff!important;'+
        'box-sizing: border-box!important;'+
        'background: white!important;'+
        'line-height: 0!important;}'

        css += '.ymaps-'+version+'-default-cluster > ymaps {'+
        'border: solid 4px #0b9373!important;'+
        'width: 100%;'+
        'height: 100%;'+
        'line-height: 34px!important;'+
        'display: block;'+
        'border-radius: 50%;'+
        'box-sizing: border-box!important;}'

        css += '.ymaps-'+version+'-balloon__tail {'+
        'left: 50%!important;'+
        'top: -7px!important;'+
        'margin-left: 0px!important; }'

        css += '.last-apartments__card {'+
        'background: #fff; }'

        css += '.ymaps-'+version+'-balloon {'+
        'box-shadow: none!important; }'

        css += '.ymaps-'+version+'-balloon__close {'+
        'top: 14px!important;'+
        'left: -4px!important;}'

        css += '.ymaps-'+version+'-balloon__close+.ymaps-'+version+'-balloon__content {'+
        'margin-left: 0px!important;'+
        'margin-right: 0!important;'+
        'margin-top: 0px!important;'+
        'border: 0!important;'+
        'background: transparent!important;'+
        '}'

        if(!!(window.attachEvent && !window.opera)) {
        styleNode.styleSheet.cssText = css;
        } else {
        var styleText = document.createTextNode(css);
        styleNode.appendChild(styleText);
        }
        document.getElementsByTagName('head')[0].appendChild(styleNode);

        var clusterIconContent = ymaps.templateLayoutFactory.createClass(
            '<span class="cluster-count">$[properties.iconContent]</span>'
        );

        var objectIcon = ymaps.templateLayoutFactory.createClass(
            '<div class="placemark-icon">' +
                '<div class="icon__object-price">' +
                    '<div class="icon__rooms-quantity"><div class="icon__rooms-quantity-inner">$[properties.type]</div></div>' +
                    '<span class="price">$[properties.price]</span></div>' +
                '</div>' +
            '</div>'
        );

        ymaps.option.presetStorage.remove('default#image')
        ymaps.option.presetStorage.add('objects#group', {
            iconLayout: 'default#imageWithContent',
            iconImageHref: 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7',
            iconImageSize: [133, 23],
            iconImageOffset: [-20, 0],

            iconContentLayout: objectIcon,
            hideIconOnBalloonOpen: true,
            clusterIcons: [{
                href: "images/cluster-icon.png",
                size: [50, 50],
                offset: [-20, -20],
                shape: {
                    type: 'Circle',
                    coordinates: [0, 0],
                    radius: 20
                }
            }],
            clusterIconContentLayout: clusterIconContent
        });


        clusterer = new ymaps.Clusterer({
            preset: 'objects#group',
            gridSize: 128,
            hasBalloon: false,
            hasHint: false,
            groupByCoordinates: false,
            clusterDisableClickZoom: false,
            clusterHideIconOnBalloonOpen: false,
            geoObjectHideIconOnBalloonOpen: false,
            maxZoom: 13
        });

        var objectIcon = ymaps.templateLayoutFactory.createClass(
        '<div class="placemark-icon placemark-icon-address">$[properties.iconContent]</div>'
        );

         var ZoomLayout = ymaps.templateLayoutFactory.createClass(
            '<button class="btn_plus" id="zoom-in">'+
                '<i class="icon icon-plus"></i>'+
            '</button>'+
            '<button class="btn_minus" id="zoom-out">'+
                '<i class="icon icon-minus"></i>'+
            '</button>'
            , {

            build: function () {
                ZoomLayout.superclass.build.call(this);

                $('#zoom-in').bind('click', ymaps.util.bind(this.zoomIn, this));
                $('#zoom-out').bind('click', ymaps.util.bind(this.zoomOut, this));
            },

            clear: function () {
                $('#zoom-in').unbind('click');
                $('#zoom-out').unbind('click');

                ZoomLayout.superclass.clear.call(this);
            },

            zoomIn: function () {
                var map = this.getData().control.getMap();
                this.events.fire('zoomchange', {
                    oldZoom: map.getZoom(),
                    newZoom: map.getZoom() + 1
                });
            },

            zoomOut: function () {
                var map = this.getData().control.getMap();
                this.events.fire('zoomchange', {
                    oldZoom: map.getZoom(),
                    newZoom: map.getZoom() - 1
                });
            }
        });

        object = {}
        coords.map(function(dataObjects) {
            var lat = parseFloat(dataObjects.lat), lng = parseFloat(dataObjects.len);

            if(lat==1) return null;
            if ( lat !== '' && lng !== '' ) {
                placemark = new ymaps.Placemark([lat, lng], {
                    balloonContent: '<div class="last-apartments__loading">' +
                                        '<div class="lds-rolling">' +
                                            '<div></div>' +
                                        '</div>' +
                                    '</div>'
                }, {
                    preset: 'objects#group'
                });

                objectsArray = $objects

                object = objectsArray[dataObjects.id]
                object_price = object.price
                price = object_price!=null?(object_price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1 ") + ' ₽'):object_price;

                placemark.icon = '';
                placemark.properties.set('id', dataObjects.id);
                placemark.properties.set('type', object.type[0]);
                placemark.properties.set('price', price);

                placemark.events.add('click', function (e) {
                    var thisPlacemark = e.get('target');
                    prop = objectsArray[thisPlacemark.properties.get('id')]
                    $('.last-apartments__loading').css('display', 'none');
                    thisPlacemark.properties.set('balloonContent', getCard(prop));                           

                });

                clusterer.add(placemark);
            }
        });

        objectsMap.geoObjects.add(clusterer)

        geoObjectsQuery = ymaps.geoQuery(clusterer.getGeoObjects());


        // zoomControl = new ymaps.control.ZoomControl({options: {layout: ZoomLayout}});
        // objectsMap.controls.add(zoomControl, {left: 10, top: 10});
    }

	$(function() {
    	ymaps.ready(init)
    })

JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>
