
if( $('body').has("#object-map") ) {
   let objectMap = ''
    var lat = $('#object-map').data('lat')
    var lng = $('#object-map').data('lng')
    ymaps.ready(initCatalogView);
    function initCatalogView() {
        objectMap = new ymaps.Map("object-map", {
            center: [lat, lng],
            zoom: 16,
            controls: []
        });
        var objectIcon = ymaps.templateLayoutFactory.createClass(
            '<div class="placemark-icon placemark-icon-address">$[properties.iconContent]</div>'
            );

        var address = $('.address').html();
        ymaps.option.presetStorage.add('objects#group', {
            iconContentLayout: objectIcon
        });
        var myPlacemark = new ymaps.Placemark([lat, lng], {
            iconContent: address,
            balloonContent: '<div class="last-apartments__loading">' +
            '<div class="lds-rolling">' +
            '<div></div>' +
            '</div>' +
            '</div>'
        }, {
            preset: 'objects#group',
            iconColor: '#fff'
        });
        objectMap.geoObjects.add(myPlacemark);
    }
    
    $(function() {
     var sync1 = $("#sync1");
        var sync2 = $("#sync2");
        var slidesPerPage = 1;
        var syncedSecondary = true;
        slide = false

        sync1.owlCarousel({
          items : 1,
          slideSpeed : 2000,
          // nav: true,
          autoplay: false,
          // dots: true,
          loop: true,
          nav: true,
          responsiveRefreshRate : 200,
          navText: [$('.leftNav').html(),$('.rightNav').html()]
          // navText: ['<svg width="100%" height="100%" viewBox="0 0 11 20"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/></svg>','<svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/></svg>'],
        }).on('changed.owl.carousel', syncPosition);

        sync2
        .on('initialized.owl.carousel', function () {
          sync2.find(".owl-item").eq(0).addClass("current");
        })
        .owlCarousel({
          items : 4,
          // dots: true,
          // nav: true,
          smartSpeed: 200,
          slideSpeed : 500,
          slideBy: 1, 
          responsiveRefreshRate : 100,
          navText: ['','']
          // navText: [$('.swiper-button-prev'),$('.swiper-button-next')]
        }).on('changed.owl.carousel', syncPosition2);

        function syncPosition(el) {
          var count = el.item.count-1;
          var current = Math.round(el.item.index - (el.item.count/2) - .5);

          if(current < 0) {
            current = count;
          }
          if(current > count) {
            current = 0;
          }

          sync2
          .find(".owl-item")
          .removeClass("current")
          .eq(current)
          .addClass("current");
          var onscreen = sync2.find('.owl-item.active').length - 1;

          var start = sync2.find('.owl-item.active').first().index();
          var end = sync2.find('.owl-item.active').last().index();

            console.log(end+' < '+current+' < '+start)
          if (current > end) {
            // console.log('--current('+current+') > end('+end+')--')
            sync2.data('owl.carousel').to(current, 100, true);
          }

          if(current==0)
            start=3
          if (current < start&&current!=4) {
            if(!slide) {
            console.log('--current('+current+') < start('+start+')--')
              slide = true
              sync2.data('owl.carousel').to(start-3, 100, true);
            }else{
              slide = false
            }
          }
        }

        function syncPosition2(el) {
          if(syncedSecondary) {
            var number = el.item.index;
            sync1.data('owl.carousel').to(number, 100, true);
          }
        }

        sync2.on("click", ".owl-item", function(e){
          e.preventDefault();
          var number = $(this).index();
          sync1.data('owl.carousel').to(number, 300, true);
        });
    }());


    $('.btn-show-map').on('click', function() {
        objectMap.destroy();
        $('#object-map').toggleClass('full-width');
        ymaps.ready(initCatalogView);
    });
}

