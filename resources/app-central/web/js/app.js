/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Version: 3.3.0.
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Main Js File
*/

var system_variables = {
    requests_in_process: {},
};

(function ($) {

    'use strict';

    function initMetisMenu() {
        //metis menu
        $("#side-menu").metisMenu();
    }

    function initLeftMenuCollapse() {
        $('#vertical-menu-btn').on('click', function (event) {
            event.preventDefault();
            toggleLeftMenu();
        });

        if (localStorage.getItem(storage_const.LEFT_SIDEBAR_STATUS) == 'collapsed') {
            toggleLeftMenu();
        }
    }

    function toggleLeftMenu() {
        $('body').toggleClass('sidebar-enable');

        if ($('body').hasClass('sidebar-enable')) {
            localStorage.setItem(storage_const.LEFT_SIDEBAR_STATUS, 'collapsed');
        } else {
            localStorage.setItem(storage_const.LEFT_SIDEBAR_STATUS, 'expanded');
        }

        if ($(window).width() >= 992) {
            $('body').toggleClass('vertical-collpsed');
        } else {
            $('body').removeClass('vertical-collpsed');
        }
    }

    function initMenuItemScroll() {
        // focus active menu in left sidebar
        $(document).ready(function () {
            if ($("#sidebar-menu").length > 0 && $("#sidebar-menu .mm-active .active").length > 0) {
                var activeMenu = $("#sidebar-menu .mm-active .active").offset().top;
                if (activeMenu > 300) {
                    activeMenu = activeMenu - 300;
                    $(".vertical-menu .simplebar-content-wrapper").animate({ scrollTop: activeMenu }, "slow");
                }
            }
        });
    }

    function initFullScreen() {
        $('[data-bs-toggle="fullscreen"]').on("click", function (e) {
            e.preventDefault();
            $('body').toggleClass('fullscreen-enable');
            if (!document.fullscreenElement && /* alternative standard method */ !document.mozFullScreenElement && !document.webkitFullscreenElement) {  // current working methods
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) {
                    document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
                }
            } else {
                if (document.cancelFullScreen) {
                    document.cancelFullScreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitCancelFullScreen) {
                    document.webkitCancelFullScreen();
                }
            }
        });
        document.addEventListener('fullscreenchange', exitHandler);
        document.addEventListener("webkitfullscreenchange", exitHandler);
        document.addEventListener("mozfullscreenchange", exitHandler);
        function exitHandler() {
            if (!document.webkitIsFullScreen && !document.mozFullScreen && !document.msFullscreenElement) {
                $('body').removeClass('fullscreen-enable');
            }
        }
    }

    function initDropdownMenu() {
        if (document.getElementById("topnav-menu-content")) {
            var elements = document.getElementById("topnav-menu-content").getElementsByTagName("a");
            for (var i = 0, len = elements.length; i < len; i++) {
                elements[i].onclick = function (elem) {
                    if (elem.target.getAttribute("href") === "#") {
                        elem.target.parentElement.classList.toggle("active");
                        elem.target.nextElementSibling.classList.toggle("show");
                    }
                }
            }
            window.addEventListener("resize", updateMenu);
        }
    }

    function updateMenu() {
        var elements = document.getElementById("topnav-menu-content").getElementsByTagName("a");
        for (var i = 0, len = elements.length; i < len; i++) {
            if (elements[i].parentElement.getAttribute("class") === "nav-item dropdown active") {
                elements[i].parentElement.classList.remove("active");
                if (elements[i].nextElementSibling !== null) {
                    elements[i].nextElementSibling.classList.remove("show");
                }
            }
        }
    }

    function initComponents() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        });

        var offcanvasElementList = [].slice.call(document.querySelectorAll('.offcanvas'))
        var offcanvasList = offcanvasElementList.map(function (offcanvasEl) {
            return new bootstrap.Offcanvas(offcanvasEl)
        })
    }

    function initPreloader() {
        $(window).on('load', function () {
            $('#status').fadeOut();
            $('#preloader').delay(350).fadeOut('slow');
        });
    }

    function initSettings() {
        if (window.sessionStorage) {
            var alreadyVisited = sessionStorage.getItem("is_visited");
            if (!alreadyVisited) {
                sessionStorage.setItem("is_visited", "light-mode-switch");
            } else {
                $(".right-bar input:checkbox").prop('checked', false);
                $("#" + alreadyVisited).prop('checked', true);
                updateThemeSetting(alreadyVisited);
            }
        }
        $("#light-mode-switch, #dark-mode-switch, #rtl-mode-switch, #dark-rtl-mode-switch").on("change", function (e) {
            updateThemeSetting(e.target.id);
        });

        // show password input value
        $("#password-addon, .password-addon").on('click', function () {
            let input = $(this).siblings('input').length > 0 ? $(this).siblings('input') : $(this).parent().siblings('input');

            if (input.length > 0) {
                input.attr('type') == "password" ? input.attr('type', 'input') : input.attr('type', 'password');
            }
        })
    }

    function updateThemeSetting(id) {
        if ($("#light-mode-switch").prop("checked") == true && id === "light-mode-switch") {
            $("html").removeAttr("dir");
            $("#dark-mode-switch").prop("checked", false);
            $("#rtl-mode-switch").prop("checked", false);
            $("#dark-rtl-mode-switch").prop("checked", false);
            $("#bootstrap-style").attr('href', 'assets/css/bootstrap.min.css');
            $("#app-style").attr('href', 'assets/css/app.min.css');
            sessionStorage.setItem("is_visited", "light-mode-switch");
        } else if ($("#dark-mode-switch").prop("checked") == true && id === "dark-mode-switch") {
            $("html").removeAttr("dir");
            $("#light-mode-switch").prop("checked", false);
            $("#rtl-mode-switch").prop("checked", false);
            $("#dark-rtl-mode-switch").prop("checked", false);
            $("#bootstrap-style").attr('href', 'assets/css/bootstrap-dark.min.css');
            $("#app-style").attr('href', 'assets/css/app-dark.min.css');
            sessionStorage.setItem("is_visited", "dark-mode-switch");
        } else if ($("#rtl-mode-switch").prop("checked") == true && id === "rtl-mode-switch") {
            $("#light-mode-switch").prop("checked", false);
            $("#dark-mode-switch").prop("checked", false);
            $("#dark-rtl-mode-switch").prop("checked", false);
            $("#bootstrap-style").attr('href', 'assets/css/bootstrap.rtl.css');
            $("#app-style").attr('href', 'assets/css/app.rtl.css');
            $("html").attr("dir", 'rtl');
            sessionStorage.setItem("is_visited", "rtl-mode-switch");
        } else if ($("#dark-rtl-mode-switch").prop("checked") == true && id === "dark-rtl-mode-switch") {
            $("#light-mode-switch").prop("checked", false);
            $("#rtl-mode-switch").prop("checked", false);
            $("#dark-mode-switch").prop("checked", false);
            $("#bootstrap-style").attr('href', 'assets/css/bootstrap-dark.rtl.css');
            $("#app-style").attr('href', 'assets/css/app-dark.rtl.css');
            $("html").attr("dir", 'rtl');
            sessionStorage.setItem("is_visited", "dark-rtl-mode-switch");
        }

    }

    function initCheckAll() {
        $('#checkAll').on('change', function () {
            $('.table-check .form-check-input').prop('checked', $(this).prop("checked"));
        });
        $('.table-check .form-check-input').change(function () {
            if ($('.table-check .form-check-input:checked').length == $('.table-check .form-check-input').length) {
                $('#checkAll').prop('checked', true);
            } else {
                $('#checkAll').prop('checked', false);
            }
        });
    }

    function initEventListeners() {

    }

    function ajaxSetup() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });
    }

    function init() {
        initMetisMenu();
        initLeftMenuCollapse();
        // initActiveMenu(); // only works for current route but not sub-routes (create, show, etc pages)
        initMenuItemScroll();
        initFullScreen();
        RightSidebar.init()
        initDropdownMenu();
        initComponents();
        initSettings();
        initPreloader();
        Waves.init();
        initCheckAll();
        initEventListeners();
        ajaxSetup();
        select2Functional();
    }

    init();

    function select2Functional() {
        let select_options = {
            minimumResultsForSearch: 10,
            templateSelection: formatText,
            templateResult: formatText
        };
        $(".select2").select2(select_options);

        $(window).on('resize', () => {
            $(".select2").select2(select_options);
        });

        $(document).on('change', 'select', function () {
            hideShowAppropriateOptions(this);
        });

        $.each($('select'), (i, el) => hideShowAppropriateOptions(el));

        function hideShowAppropriateOptions(select) {
            let name = $(select).attr('name');
            let value = $(select).val();
            let selected_option = $(select).find(`option[value="${select.value}"]`);

            // in case was selected invisible option - select appropriate option in parent select
            if (value && !selected_option.is(':visible')) {
                $(`select[name='${selected_option.data('visible-for')}']`)
                    .val(selected_option.data('visible-for-value'))
                    .trigger('change');
            }

            let dependent_options = $(`select option[data-visible-for="${name}"]`);

            if (dependent_options.length) {
                let changes = false;

                $.each(dependent_options, (i, option) => {
                    if ($(option).data('visible-for-value') == value) {
                        if ($(option).css('display') == 'none') {
                            $(option).show();
                            changes = true;
                        }
                    } else {
                        if ($(option).css('display') != 'none') {
                            $(option).hide();
                            changes = true;
                        }

                        // empty select value in case this option was selected
                        if ($(option).is(':selected')) {
                            $(option).attr('selected', false)
                            $(option).closest('select').val('');
                            changes = true;
                        }
                    }
                });

                // if had any changes - trigger select2 re-rendering
                if (changes) {
                    $(window).trigger('resize');
                    $(dependent_options.first()).closest('select').trigger('change');
                }
            }
        }

        function formatText(opt, container) {
            if (opt.element) {
                $(container).css('display', $(opt.element).css('display')); // if option hidden - select2 option container will be hidden either
            }
            return $('<span>' + opt.text + '</span>'); // this allows html to be shown
        };
    }

})(jQuery);


/**
 * Standart request for forms
 * 
 * @param {string} url
 * @return {Promise}
 */
function myAjax(params_or_url, maybe_data = [], params_if_url = {}) {
    return new Promise((resolve, reject) => {
        if (typeof params_or_url === 'string') {
            var params = {
                url     : params_or_url,
                data    : maybe_data,
                ...params_if_url
            };

        } else {
            var params = params_or_url;
        }

        let url = params.url;

        if (system_variables.requests_in_process[url]) {
            reject('request_in_process');
            return ;
        }

        params = {
            method: 'POST',
            ...params
        };
        system_variables.requests_in_process[url] = true;
        
        $.ajax({
            url: params.url,
            method: params.method,
            data: params.data,
            contentType: params.contentType,
            processData: params.processData,
            dataType: params.dataType,
            success: (res) => {
                system_variables.requests_in_process[url] = false;

                if (!res.success) {
                    errorMsg(res.message);
                    resolve(res);
                    return;
                } else {
                    if (res.message.length && typeof params.show_success_message !== 'undefined' && params.show_success_message) {
                        successMsg(res.message);
                    }
                }

                resolve(res);
            },
            error: (res) => {
                system_variables.requests_in_process[url] = false;
                showValidationErrors(res);
                reject(res);
            }
        });
    });
}

/**
 * Standart request for forms
 * 
 * @param {string} url
 * @param {object} form
 * @return {Promise}
 */
function form_ajax(url, form, params = {}) {
    params = Object.assign({
        refresh: true
    }, params);
    form = form instanceof jQuery ? form[0] : form;
    let form_data = new FormData(form);

    for (var pair of form_data.entries()) {
        if (!pair[1].length) {
            form_data.delete(pair[0]);
        }
    }

    // append files if any
    let file_jq = $(form).find('input[type=file]');
    if (file_jq.length) {
        $.each(file_jq, function (i, el) {
            let name = $(el).attr('name');

            for (let file of el.files) {
                form_data.append(name, file);
            }
        });
    }

    // append dropzone files if any
    let dropzones_jq = $(form).find('.dropzone');
    if (dropzones_jq.length) {
        $.each(dropzones_jq, function (i, el) {
            let file_name = $(el).attr('id');
            let file = el.dropzone.files;

            for (let i = 0; i < file.length; i++) {
                form_data.append(file_name, file[i]);
            }
        });
    }

    let method = $(form).attr('method') ? $(form).attr('method') : 'POST';
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            method: method,
            data: form_data,
            contentType: false,
            processData: false,
            success: (res) => {
                removeFormErrors(form);

                if (!res.success) {
                    errorMsg(res.message);
                    return;
                } else {
                    if (res.message.length) {
                        successMsg(res.message);
                    }
                    
                    setTimeout(function () {
                        if (typeof params.redirect !== 'undefined') {
                            window.location.href = params.redirect;

                        } else if (typeof params.callback !== 'undefined') {
                            params.callback(res);
                            
                        } else if (params.refresh) {
                            window.location.reload();

                        }
                    }, 600);
                }

                resolve(res);
            },
            error: (res) => {
                $(form).find('[name=is_draft]').val(0);
                addFormErrors(form, res);
                showValidationErrors(res);
                reject(res);
            }
        });
    });
}

/**
 * Show swal confirmation box
 * @param {string} title 
 * @param {string} text 
 * @returns Promise
 */
function swalConfirm(title = 'Are you sure?', text = '', callback = () => {})
{
    return new Promise((resolve) => {
        Swal.fire({
            title: title,
            text: text,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#556ee6",
            cancelButtonColor: "#74788d",
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel",
        }).then((res) => {
            callback(res.isConfirmed);
            resolve(res.confirmed);
        });
    });
}

/**
 * Add new param to url or update existing without refreshing page
 * @param {string} name 
 * @param {string} value 
 */
function addOrUpdateUrlParam(name, value) {
    let params = new URLSearchParams(window.location.search);
    params.set(name, value);
    let params_str = params.toString();
    let url_str = window.location.origin + window.location.pathname;

    window.history.replaceState(null, null, url_str + '?' + params_str);
}

/**
 * Return decoded url param
 * @param {string} name 
 */
function getUrlParam(name) {
    let params = new URLSearchParams(window.location.search);
    return params.get(name);
}

/**
 * Displays loader on page
 * @param {string} selector 
 */
function showLoader(selector = '#overlay-loader')
{
    $(selector).addClass('active');
}

/**
 * Hide loader from page
 * @param {string} selector 
 */
function hideLoader(selector = '#overlay-loader')
{
    $(selector).removeClass('active');
}

// Animated Widgets
$(document).ready(function () {
    $(".animated-slow").each(function (i) {
        $(this).delay(400 * i).animate({ opacity: "1" }, "slow");
    });
});
$(document).ready(function () {
    $(".animated-fast").each(function (i) {
        $(this).delay(150 * i).animate({ opacity: "1" }, "fast");
    });
});
$(document).ready(function () {
    $(".animated-activity").each(function (i) {
        $(this).delay(350 * i).animate({ opacity: "1" }, "fast");
    });
});
$(document).ready(function () {
    $(".animated-menu").each(function (i) {
        $(this).delay(150 * i).animate({ opacity: "1" }, "fast");
    });
});