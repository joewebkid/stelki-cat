$('.search__inner > div > label').on('click', function (e) {

    if ($(e.target).is('.search__inner > div > label')) {
        $('.search__inner > div > label').not(this).removeClass('active');
        $(this).toggleClass('active');
        $('.fade__block').toggle()
        $('.catalog__filter').toggleClass('active');
    }
    //  else if ( $(e.target).is('.search__param-select-val') ) {
    //     $('.search__inner > div > label').not($(this).closest('.search__inner > div > label')).removeClass('active');
    //     $(this).closest('.search__inner > div > label').toggleClass('active');
    //     $('.fade__block').toggle()
    //     $('.catalog__filter').toggleClass('active');
    // }

});
$('.fade__block').on('click', function (e) {
    $('.search__inner > div > label').removeClass('active');
    $('.fade__block').toggle()
    $('.catalog__filter').removeClass('active');
});

//  $('.search__inner').on('change', '.sel__block input[type="checkbox"]', function () {
//     var len = 0;

//     $(this).parents('.search__inner').find('.sel__block input[type="checkbox"]:checked').map(function(item) {
//       len++
//     });

//     if(len!=0) {
//       $(this).parents('.search__inner').find('.search__num').html(len);
//       $(this).parents('.search__inner').find('.search__num').addClass('active');
//     }
//     // $(this).parents('.search__inner').find('label.control-label').html(result);
// });


if ($('body').has('.chat__container')) {
    $('.chat__container').scrollTop(100000);
}

if ($('body').has('.filter')) {
    $('.filter input').change(() => {
        at = $('a.btn').attr('href').split('?')[0]
        $('a.btn').attr('href', at + '?' + $('form').serialize())
    })
    $('.field-objectssearch-district .sel__block input[type="checkbox"]').change()
    $('.field-objectssearch-type .sel__block input[type="checkbox"]').change()
}
$('body').on('click', '.last-apartments__card-like', function (e) {
    parrent = $(this).parent(".last-apartments__card");
    if (parrent.length == 0)
        parrent = $(this).parents(".item__container");

    id = parrent.data("id");
    name = parrent.data("name");
    parrent.toggleClass("liked");
    typeClass = parrent.hasClass("liked") ? 'success' : 'error';
    textClass = parrent.hasClass("liked") ? 'Объект ' + name + ' добавлен в избранное' : 'Объект ' + name + ' удален из избранного'
    $.get(
        '/catalog/add-favorite',
        {id: id},
        function (response) {
            console.log(response)
        }
    );

    var noty = new Noty({
        type: typeClass,
        text: textClass,
        timeout: 1000
    }).show();
    console.log(noty);


});

$('.adminObject').on('click', (e) => {

    if (!$(e.target).parent('.adminObject').find('.typeChooser').index($(e.target)) && !$(e.target).parent('.adminObject').siblings('input[type="checkbox"]').prop('checked'))
        e.preventDefault()

    if (!$(e.target).parent('.adminObject').hasClass('active'))
        $(e.target).parent('.adminObject').addClass('active')

    if ($('.field-objects-owner .adminObject').hasClass('active') &&
        $('.field-objects-saletype .adminObject').hasClass('active') && !$('.step_2').hasClass('active')) {
        $('.step_2').addClass('active')
        $('#objects-city').val('Санкт-Петербург')
    }

})
let inputs = document.querySelectorAll('#objects-imagefiles');
Array.prototype.forEach.call(inputs, function (input) {
    let label = input.nextElementSibling,
        labelVal = label.querySelector('.input__file-button-text').innerText;

    input.addEventListener('change', function (e) {
        let countFiles = '';
        if (this.files && this.files.length >= 1)
            countFiles = this.files.length;

        if (countFiles)
            label.querySelector('.input__file-button-text').innerText = 'Выбрано файлов: ' + countFiles;
        else
            label.querySelector('.input__file-button-text').innerText = labelVal;
    });
});

var $area_input = $("#area_input");
var $price_input = $("#price_input");

var price_from = 1000000;
var area_from = 20;

if($area_input.val()){
    area_from = $area_input.val();
}

if($price_input.val()){
    price_from = $price_input.val();
}


$("#objects-area").ionRangeSlider({
    skin: "round",
    grid: true,
    min: 1,
    max: 100,
    step: 1,
    from: area_from,
    postfix: ' м²',
    onStart: function(data) {
        $area_input.prop("value", data.from);
    },
    onChange: function(data) {
        $area_input.prop("value", data.from);
    }
});
instance = $("#objects-area").data("ionRangeSlider");

$area_input.on("input", function() {
    var val = $(this).prop("value");

    if (val < 1) {
        val = 1;
    } else if (val > 100) {
        val = 100;
    }

    $(this).prop("value",val)
    instance.update({
        from: val
    });
});

$("#objects-price").ionRangeSlider({
    skin: "round",
    grid: true,
    min: 1000,
    max: 5000000,
    step: 100,
    from: price_from,
    postfix: ' ₽',
    onStart: function(data) {
        $price_input.prop("value", data.from);
    },
    onChange: function(data) {
        $price_input.prop("value", data.from);
    }
});
instance2 = $("#objects-price").data("ionRangeSlider");

$price_input.on("input", function() {
    var val = $(this).prop("value");

    if (val < 1) {
        val = 1;
    } else if (val > 5000000) {
        val = 5000000;
    }

    $(this).prop("value",val);
    instance2.update({
        from: val
    });
});

// $("#objects-price").ionRangeSlider();

$('#send_sms_again').click(function () {
    var block = $(this);
    if (block.hasClass('deactive')) {
        return false;
    } else {
        // block.html('SMS с новым кодом отправлено');
        block.remove();
        new Noty({
            text: 'SMS с новым кодом отправлено',
            type: 'success'
        }).show();
    }

    $.ajax({
        type: 'POST',
        url: '/cabinet/reset-sms-code',
        dataType: 'json',
        data: {
            type: $(this).data('sms-type'),
            phone: $(this).data('phone')
        },
        success: function (data) {
            if (data.error) {
                block.html(data.error)
            }
        }
    });
});

$('#send_email_again').click(function () {
    var block = $(this);
    if (block.hasClass('deactive')) {
        return false;
    } else {
        // block.html('Письмо с новым кодом отправлено');
        block.remove();
        new Noty({
            text: 'Письмо с новым кодом отправлено',
            type: 'success'
        }).show();
    }

    $.ajax({
        type: 'POST',
        url: '/cabinet/reset-email-code',
        dataType: 'json',
        data: {
            type: $(this).data('email-type'),
            email: $(this).data('email')
        },
        success: function (data) {
            if (data.error) {
                block.html(data.error)
            }
        }
    });
});

$('#send_email_active_again').click(function () {
    var block = $(this);
    if (block.hasClass('deactive')) {
        return false;
    } else {
        // block.html('Письмо с новым кодом отправлено');
        block.remove();
        new Noty({
            text: 'Письмо с новым кодом отправлено',
            type: 'success'
        }).show();
        block.remove();
    }

    $.ajax({
        type: 'POST',
        url: '/cabinet/resend-email-active-code',
        dataType: 'json',
        data: {
            type: $(this).data('email-type'),
            email: $(this).data('email')
        },
        success: function (data) {
            if (data.error) {
                block.html(data.error)
            }
        }
    });
});

$("#clear_change_email").click(function () {
    $.ajax({
        type: 'POST',
        url: '/cabinet/clear-change-email',
        dataType: 'json',
        success: function (data) {
            if (data.error) {
                block.html(data.error)
            }
        }
    });
});