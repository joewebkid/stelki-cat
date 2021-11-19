$('#loginform-phone').mask('+0 (000) 000-00-00', {placeholder: "+_ (___) ___-__-__"});

// $('[name="recovery-step-1-button"]').click(function () {
//
//     var phone = $('[name="LoginForm[phone]"]').val();
//     $.post('/site/password-recovery-send-sms', {
//             'phone': phone
//         },
//         function (data) {
//             if(data.error === false){
//                 $('.recovery-step-1').fadeOut(300, function () {
//                     $('.recovery-step-2').fadeIn(300)
//                 });
//             }
//         });
// });
//
// $('[name="recovery-step-2-button"]').click(function () {
//     $('.recovery-step-2').fadeOut(300, function () {
//         $('.recovery-step-1').fadeIn(300)
//     });
// });
