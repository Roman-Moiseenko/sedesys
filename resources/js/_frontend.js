import jQuery from "jquery";

window.$ = jQuery;

(function () {
    "use strict";
    //Устанавливаем в сессию таймзону клиента
    sessionStorage.setItem("time", -(new Date().getTimezoneOffset()));


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let main = $('main');


    /** LOGIN POPUP **/
    let loginPopup = $('#login-popup');
    if (loginPopup.length) {
        let route = loginPopup.data('route');
        let form = $('form#login-form');
        let buttonLogin = $('#button-login');
        let inputPhone = loginPopup.find('input[name="phone"]');
        let inputEmail = loginPopup.find('input[name="email"]');
        let inputPassword = loginPopup.find('input[name="password"]');
        let inputVerify = loginPopup.find('input[name="verify_token"]');
        inputVerify.parent().hide();
        buttonLogin.on('click', function () {
            if (inputEmail.length !== 0)
                if (inputEmail.val().length === 0 || inputPassword.val().length === 0 || !isEmail(inputEmail.val())) {
                    form.addClass('was-validated');
                    return true;
                }
            if (inputPhone.length !== 0)
                if (inputPhone.val().length !== 11 || inputPassword.val().length === 0) {
                    form.addClass('was-validated');
                    return true;
                }
            if (inputVerify.parent().is(':visible') && inputVerify.val().length === 0) {
                form.addClass('was-validated');
                return true;
            }
            $.post(
                route,
                {
                    phone: (inputPhone.length === 0) ? null : inputPhone.val(),
                    email: (inputEmail.length === 0) ? null : inputEmail.val(),
                    password: inputPassword.val(),
                    verify_token: inputVerify.val()
                }, function (data) {
                    _error(data);
                    let tokenError = $('#token-error');
                    let passwordError = $('#password-error');
                    tokenError.hide();
                    passwordError.hide();
                    console.log(data);
                    if (data.token === true) tokenError.show(); //неверный токен
                    if (data.verification === true || data.register === true) { //требуется верификация
                        inputEmail.prop('disabled', true);
                        inputPassword.prop('disabled', true);
                        inputVerify.prop('required', true);
                        inputVerify.parent().show();
                    }
                    if (data.password === true) passwordError.show(); //Неверный пароль
                    if (data.login === true) location.reload(); //Аутентификация прошла
                }
            );

        });

        //Новый пароль на телефон
        let newPassword = $('#new-password');
        let routePhone = newPassword.data('route');
        let newPasswordSend = $('#new-password-send');
        let newPasswordInfo = $('#new-password-info');
        newPassword.on('click', function () {
            newPasswordSend.show();
            newPasswordSend.on('click', function () {
                if (inputPhone.val().length !== 11) {
                    alert('Неверный номер телефона!');
                    return;
                }
                $.post(
                    routePhone,
                    {phone: inputPhone.val(),},
                    function (data) {
                        _error(data);
                        if (data === true) newPasswordInfo.show()

                        newPasswordSend.hide();
                        newPassword.hide();
                    }
                );
            });
        });

    }

    //Доп.элементы
    let upButton = $('#upbutton');
    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 100) {
            if (!upButton.hasClass('is-active')) {
                upButton.addClass('is-active');
            }
        } else {
            upButton.removeClass('is-active');
        }
        if ($(this).scrollTop() > 200) {
            $('nav.navbar').addClass('sticky-menu');
        } else {
            $('nav.navbar').removeClass('sticky-menu');
        }
    });
    upButton.on('click', function () {
        $('html, body').stop().animate({scrollTop: 0}, 300, 'swing');
    });

    //Показать скрыть пароль
    let showHidePassword = $('#show-hide-password');
    if (showHidePassword !== undefined) {
        let inputPassword = $(showHidePassword.data('target-input'));
        showHidePassword.on('click', function () {
            if (inputPassword.attr('type') === 'password') {
                inputPassword.attr('type', 'text');
            } else {
                inputPassword.attr('type', 'password');
            }
        });
    }

    //Валидация email
    function isEmail(email) {
        let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    //Валидация input/number
    function inn_format(_num) {
        let regex = /^([0-9]{10,12})+$/;
        return regex.test(_num);
    }

    //Приведение числа в цену формата 1 000 000 ₽
    function price_format(_str) {
        if (_str === null || _str === '') return '';
        return _str.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") + '  ₽';
    }

    //Отображение ошибок
    function _error(data) {
        if (data.error !== undefined) {
            if (Array.isArray(data.error)) {
                console.log(data.error);
            } else {
                let notification = $('#notification');
                notification.find('.toast-body').html(data.error);
                notification.remove('hide');
                notification.addClass('show');
                notification.find('button[data-bs-dismiss=toast]').on('click', function () {
                    notification.addClass('hide');
                    notification.remove('show');
                });
            }
            return true;
        }
        return false;
    }
    //Карусели
    /*
    let optionsSliderBase = {
        rtl: false,
        startPosition: 0,
        items: 1,
        autoplay: false, //
        smartSpeed: 1500, //Время движения слайда
        autoplayTimeout: 1000, //Время смены слайда
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        margin: 10,
        loop: false,
        dots: false,
        nav: true,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        singleItem: true,
        transitionStyle: "fade",
        touchDrag: true,
        mouseDrag: false,
        responsive: {
            0: {
                items: 1,
                smartSpeed: 500
            },
            576: {
                items: 2,
                smartSpeed: 500
            },
            991: {
                items: 6,
                smartSpeed: 500
            },
        }
    };
    if (document.getElementById('slider-payment') !== null) {
        let sliderPayment = $('#slider-payment');
        sliderPayment.owlCarousel(optionsSliderBase);
        sliderPayment.on('mousewheel', '.owl-stage', function (e) {
            if (e.originalEvent.deltaY > 0) {
                sliderPayment.trigger('next.owl');
            } else {
                sliderPayment.trigger('prev.owl');
            }
            e.preventDefault();
        });
    }
    if (document.getElementById('slider-delivery-company') !== null) {
        let sliderDeliveryCompany = $('#slider-delivery-company');
        sliderDeliveryCompany.owlCarousel(optionsSliderBase);
        sliderDeliveryCompany.on('mousewheel', '.owl-stage', function (e) {
            if (e.originalEvent.deltaY > 0) {
                sliderPayment.trigger('next.owl');
            } else {
                sliderPayment.trigger('prev.owl');
            }
            e.preventDefault();
        });
    }
*/
})();

