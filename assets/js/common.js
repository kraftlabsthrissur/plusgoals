/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(
        function () {
            $('.sidebar-menu li').on('click', function () {
                $('.sidebar-menu li').removeClass('active');
                $(this).addClass('active').closest('li').addClass('active');
            });
            $('#right-content').on('submit', '.ajax-submit', ajax_submit);
            $('#right-content').on('submit', '.ajax-form', ajax_form);
            $('#right-content').on('click', '#edit-password', function () {
                $('#password').removeAttr('disabled');
            });
            $('#right-content').on(
                    'click',
                    '.hierarchy .add',
                    function () {
                        var hierarchy_id = $(this).parent('.actions').children(
                                '.hierarchy_id').val();
                        var parent_hierarchy = $(this).closest('.hierarchy').parent(
                                '.hierarchy');
                        var parent_hierarchy_id = $(parent_hierarchy).find(
                                '.hierarchy_id').val();
                        $.ajax({
                            url: base_url + 'privilege/get_staffs',
                            data: {
                                'hierarchy_id': hierarchy_id,
                                'mode': 'add-staff',
                                'parent_hierarchy_id': parent_hierarchy_id,
                            },
                            method: 'POST'
                        }).success(function (response) {
                            $('#right-content').append(response);
                        });
                    });
            $('#right-content').on(
                    'click',
                    '.hierarchy .remove',
                    function () {
                        var hierarchy_id = $(this).parent('.actions').children(
                                '.hierarchy_id').val();
                        var parent_hierarchy = $(this).closest('.hierarchy').parent(
                                '.hierarchy');
                        var parent_hierarchy_id = $(parent_hierarchy).find(
                                '.hierarchy_id').val();
                        $.ajax({
                            url: base_url + 'privilege/remove_staff',
                            data: {
                                'hierarchy_id': hierarchy_id,
                                'parent_hierarchy_id': parent_hierarchy_id,
                            },
                            method: 'POST'
                        }).success(function (response) {
                           $('#right-content').html(response);
                           draw_hierarchy();
                        });
                    });
            $('#right-content').on(
                    'click',
                    '.hierarchy .change',
                    function () {
                        var hierarchy_id = $(this).parent('.actions').children(
                                '.hierarchy_id').val();
                        var parent_hierarchy = $(this).closest('.hierarchy').parent(
                                '.hierarchy');
                        var parent_hierarchy_id = $(parent_hierarchy).find(
                                '.hierarchy_id').val() || 0;
                        $.ajax({
                            url: base_url + 'privilege/get_staffs',
                            data: {
                                'hierarchy_id': hierarchy_id,
                                'mode': 'change-staff',
                                'parent_hierarchy_id': parent_hierarchy_id,
                            },
                            method: 'POST'
                        }).success(function (response) {
                            $('#right-content').append(response);
                        });
                    });
            $('#right-content').on('click', '.circle.visible',
                    function (e) {
                        $(this).removeClass('visible').addClass('not-visible');
                        $(this).text($(this).closest('.hierarchy').children('.hierarchy').length);
                        $(this).closest('.hierarchy').find('.hierarchy').removeClass('visible').addClass('not-visible');
                    });
            $('#right-content').on('click', '.circle.not-visible',
                    function (e) {
                        $(this).removeClass('not-visible').addClass('visible');
                        $(this).text('-');
                        
                        $(this).closest('.hierarchy').find('.hierarchy').removeClass('not-visible').addClass('visible');
                    });
        });
var return_url = get_return_url();
$(function () {
    $(window)
            .on(
                    'hashchange',
                    function () {
                        if (typeof window.location.hash !== "undefined"
                                && window.location.hash !== "#"
                                && window.location.hash !== "") {
                            loadPage(window.location.hash);
                        }
                    });
    if (typeof window.location.hash !== "undefined"
            && window.location.hash !== "#" && window.location.hash !== "") {
        loadPage(window.location.hash);
    }
    if (window.location.hash === '' || window.location.hash === '#') {
        window.location.hash = return_url;
    }
});
function get_return_url() {
    var return_url = '#common/dashboard';
    if (typeof window.localStorage['return_url'] !== 'undefined') {
        return_url = window.localStorage['return_url'];
        window.localStorage.removeItem('return_url');
        return return_url;
    }
    return return_url;
}
function ajax_form() {
    $(this).ajaxSubmit({
        target: '#none',
        dataType: "json",
        success: function (response, status, xhr) {
            if (response.status === 'success') {
                show_success_message(response.message);
                loadPage(window.location.hash);
            } else {
                show_success_message(response.message);
            }
        },
        error: function (response) {
            console.log(response);
        }
    });
    return false;
}
function ajax_submit() {
    var data = $(this).serialize();
    var action = $(this).attr('action');
    $('#loader').show();
    $.ajax({
        type: "POST",
        url: base_url + action,
        data: data
    }).success(function (response, status, xhr) {
        var content_type = xhr.getResponseHeader('Content-Type');
        if (content_type.indexOf('text/html') != -1) {
            $('#right-content').html(response);
        } else if (content_type.indexOf('application/json') != -1) {
            if (response.status === 'success') {
                window.location.hash = response.hash;
                show_success_message(response.message);
            }
        }
        $('#loader').hide();
    }).error(function () {
        console.log('error');
    });
    return false;
}
function loadPage(url) {
    if (typeof url !== 'undefined' && url !== "#") {
        url = url.replace("#", "");
    } else {
        url = 'common/dashboard';
    }
    var split = url.split('/');
    var title;
    if (split[0] == 'login') {
        window.location = base_url + url;
    }
    if (typeof split[1] === 'undefined' || split[1] === '') {
        url = 'common/bad_request';
        title = app_title + ' | Bad Request';
    } else {
        title = app_title + ' | '
                + capitalizeEachWord(split[1].replace(/_/g, ' '));
    }
    $.ajax({
        url: base_url + url,
    }).success(function (response, status, xhr) {
        var content_type = xhr.getResponseHeader('Content-Type');
        if (content_type.indexOf('text/html') != -1) {
            $('#right-content').html(response);
            $('title').text(title);
            $('a[href*="' + url + '"]').parent('li').addClass('active');
        } else if (content_type.indexOf('application/json') != -1) {
            window.localStorage.removeItem('return_url');
            window.localStorage['return_url'] = '#' + url;
            if (response.status === 'error') {
                window.location.hash = response.hash;
            } else if (response.status === 'success') {
                if (typeof response.message !== 'undefined') {
                    show_success_message(response.message);
                }
            }
            if (typeof response.hash !== 'undefined') {
                window.location.hash = response.hash;
            } else if (typeof response.redirect !== 'undefined') {
                window.location = base_url + response.redirect;
            }
        }
    }).error(function () {
        console.log('error');
    });
}
function capitalizeEachWord(str) {
    return str.replace(/\w\S*/g, function (txt) {
        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    });
}
function show_success_message(message) {
    alert(message);
}
function log(text) {
    var log = $('#log');
    var items = $("<div>" + decodeURIComponent(text) + "</div>");
    log.append(items);
}
function show_hide_log() {
    $('#log').toggle();
}