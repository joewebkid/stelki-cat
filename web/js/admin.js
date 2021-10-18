try {

ClassicEditor
    .create( document.querySelector( '#staticpages-text' ) )
    .then( editor => {
            // console.log( editor );
    } )
    .catch( error => {
            console.error( error );
    } );

} catch (err) {}

$(function() {
    // $("#objects-metro").select2({
    //     maximumInputLength: 20
    // })

    // metro = $(".metro").data('metro')
    // $("#objects-metro").val(metro)
    // $('#objects-metro').trigger('change')
    if($('body').has('#objects-city').length) {
        ymaps.ready(init)

        var city = $('#objects-city');
        var street = $('#objects-address');
        // var house = $('#addresses-home');
        var coordLat = $('#objects-coord_lat');
        var coordLng = $('#objects-coord_len');
        var multiRoute = {}

        setDistance = (placemarkCoords, metro, metroName)  => {
            //------------------------------ 
            var activeRoute = {}
            multiRoute[metroName] = (new ymaps.multiRouter.MultiRoute({
                referencePoints: [
                    placemarkCoords,
                    metro
                ],
                params: {
                    routingMode: 'pedestrian'
                }
            })) 

            multiRoute[metroName].model.events.add('requestsuccess', function() {
                activeRoute[metroName] = multiRoute[metroName].getActiveRoute();
                // console.log(metroName);
                // console.log(activeRoute[metroName].properties.getAll());
                if(!activeRoute[metroName]) return false
                var r = {
                    distance: activeRoute[metroName].properties.get("distance").text,
                    duration: activeRoute[metroName].properties.get("duration").text,
                }

                 $.post(
                    '/admin/metro/get-by-name',
                    { name: metroName },
                    function (response) {
                        if(response) {
                            val = $('#objects-metro').val()
                            if(val) val = JSON.parse(val)
                            else val = {}
                            
                            val[response.id] = {
                                name: response.name,
                                color: response.color,
                                distance: r.distance,
                                duration: r.duration,
                            }
                            // console.log(val);

                            val = JSON.stringify(val)
                            $('#objects-metro').val(val)
                        }

                        $('body').find('#objects-metro').change()
                    }
                );
            })

            
            //----------------------------- 
            return false
        }

        function init() {
            if($('body').has('#addresses__map').length) {
                var myMap = new ymaps.Map('addresses__map', {
                    center: [coordLat.val()||59.939032, coordLng.val()||30.315827],
                    zoom: 15,
                    controls: ['zoomControl']
                });

                var placemark = new ymaps.Placemark([coordLat.val()||59.939032, coordLng.val()||30.315827], [], {
                    draggable: true
                });

                placemark.events.add('dragend', function(evt) {
                    var placemarkCoords = placemark.geometry.getCoordinates();

                    coordLat.val(placemarkCoords[0]);
                    coordLng.val(placemarkCoords[1]);

                    ymaps.geocode(placemarkCoords, {
                        kind: 'house',
                        results: 1
                    }).then(function(res) {
                        var geoObjectComponents = res.geoObjects.get(0).properties.get('metaDataProperty.GeocoderMetaData.Address.Components');


            //             console.log(multiRoute.getActiveRoute());

                        ymaps.geocode(placemarkCoords, {
                            kind: 'metro',
                            results: 6
                        }).then(function (res) {
                            $('#objects-metro').val('')

                            if(res.geoObjects.get(0)) {
                                obj0 = res.geoObjects.get(0).properties.getAll()
                                address0 = obj0.metaDataProperty.GeocoderMetaData.text
                                setDistance(placemarkCoords, address0, obj0.name)
                            }

                            if(res.geoObjects.get(1)) {
                                obj1 = res.geoObjects.get(1).properties.getAll()
                                address1 = obj1.metaDataProperty.GeocoderMetaData.text
                                setDistance(placemarkCoords, address1, obj1.name)
                            }
                            // if(res.geoObjects.get(2)) {
                            //     obj2 = res.geoObjects.get(2).properties.getAll()
                            //     address2 = obj2.metaDataProperty.GeocoderMetaData.text
                            //     setDistance(placemarkCoords, address2, obj2.name)
                            // }

                            // if(res.geoObjects.get(3)) {
                            //     obj3 = res.geoObjects.get(3).properties.getAll()
                            //     address3 = obj3.metaDataProperty.GeocoderMetaData.text
                            //     setDistance(placemarkCoords, address3, obj3.name)
                            // }
                        })
                        city.val(geoObjectComponents.find(function(component) {
                            return component.kind === 'locality';
                        }).name);

                        street.val(geoObjectComponents.find(function(component) {
                            return component.kind === 'street';
                        }).name+", "+geoObjectComponents.find(function(component) {
                            return component.kind === 'house';
                        }).name);
                        
                        // $('body').find('#objects-metro').trigger('change')
                    });
                });

                myMap.geoObjects.add(placemark);

                $('#objects-address').on('change',(e)=>{
                    city = $('#objects-city').val()
                    address = city+','+$(e.target).val()
                    ymaps.geocode(address, {
                        results: 1
                    }).then(function (res) {

                        var firstGeoObject = res.geoObjects.get(0)
                        placemarkCoords = firstGeoObject.geometry.getCoordinates()
                        placemark.geometry.setCoordinates(placemarkCoords);

                        ymaps.geocode(placemarkCoords, {
                            kind: 'metro',
                            results: 6
                        }).then(function (res) {
                            $('#objects-metro').val('')

                            if(res.geoObjects.get(0)) {
                                obj0 = res.geoObjects.get(0).properties.getAll()
                                address0 = obj0.metaDataProperty.GeocoderMetaData.text
                                setDistance(placemarkCoords, address0, obj0.name)
                            }

                            if(res.geoObjects.get(1)) {
                                obj1 = res.geoObjects.get(1).properties.getAll()
                                address1 = obj1.metaDataProperty.GeocoderMetaData.text
                                setDistance(placemarkCoords, address1, obj1.name)
                            }

                            // if(res.geoObjects.get(2)) {
                            //     obj2 = res.geoObjects.get(2).properties.getAll()
                            //     address2 = obj2.metaDataProperty.GeocoderMetaData.text
                            //     setDistance(placemarkCoords, address2, obj2.name)
                            // }

                            // if(res.geoObjects.get(3)) {
                            //     obj3 = res.geoObjects.get(3).properties.getAll()
                            //     address3 = obj3.metaDataProperty.GeocoderMetaData.text
                            //     setDistance(placemarkCoords, address3, obj3.name)
                            // }
                        })
                        $('#objects-metro').trigger('change')
                    })

                })
            }
        }

        $('body').on('change','#objects-metro',(e)=>{
            metro = JSON.parse($(e.target).val())
            metroArray = []
            for (var key in metro) {
                metroArray.push(metro[key])
            }

            s = metroArray.map((item)=>{
                return '<div class="metro__container">'+
                    '<div class="metro__color-wrapper">'+
                        '<div class="metro__color" style="background-color: #'+item.color+';"></div>'+
                    '</div>'+
                    '<div class="metro__name">'+item.name+'</div>'+
                    '<div class="metro__additional__info">'+item.distance+' ~ '+item.duration+'</div>'+
                '</div>'
            })
            $('.metroVis').html(s)

            if(!$('.step_3').hasClass('active')) {
                // if(!$('.step_1').hasClass('rollup')) 
                //     $('.step_1').addClass('rollup')
                
                if(!$('.btn-success').hasClass('activeB')) {
                    $('.btn-success').prop("disabled", 0)
                    $('.btn-success').addClass('activeB')
                }
                if($('#objects-address').val()&&$('#objects-city').val())
                    $('.step_3').addClass('active')
            }
        })
        
        $('#objects-metro').trigger('change')
    }
});