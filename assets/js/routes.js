$(document).ready(function () {
    $('body').on('click', '.assign_route', function () {
        var route_id = $(this).parents('td').find('.route_id').val();
        $.ajax({
            url: base_url + 'routes/select_user',
            method: 'POST',
            dataType: 'html',
            data: {id: route_id}
        }).success(function (response) {
            $('#assignroutes .modal-content').html(response);
            $('#assignroutes').modal();
            $("#assigned_date").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });
        });
    });
    $('body').on('click', '.remove-assigned-route', remove_assigned_route);
    $('body').on('click', '#assign', function () {
        var user_id = $('select[name=selected_user] option:selected').val();
        var date = $('input[name=date]').val();
        var route_id = $('input[name=route_id]').val();
        console.log(user_id, date, route_id);
        $.ajax({
            url: base_url + 'routes/assign_route',
            method: 'POST',
            dataType: 'html',
            data: {route_id: route_id, user_id: user_id, date: date}
        }).success(function (response) {

            $('#assignroutes').modal('toggle');
        });

    });
    $('body').on('click', '#cal_assign', function () {
        var user_id = $('select[name=selected_user] option:selected').val();
        var user_name = $('select[name=selected_user] option:selected').text();
        var date = $('input[name=date]').val();
        var route_id = $('select[name=selected_route] option:selected').val();
        var route_name = $('select[name=selected_route] option:selected').text();

        $.ajax({
            url: base_url + 'routes/assign_route',
            method: 'POST',
            dataType: 'json',
            data: {route_id: route_id, user_id: user_id, date: date}
        }).success(function (response) {
            if (response.status == "success") {
                var div = "<div class='event'><div data-assigned-route-id='" + response.assigned_route_id + "'>Route :" + route_name + "<br> Assigned to :" + user_name + "<a  class='remove-assigned-route pull-right'>X</a></div></div>";
                $('time[datetime="' + date + '"]').parent('td').children('div').append(div);
                alert(response.message);
            }
            $('#assignroutes').modal('toggle');
        });

    });

});

function remove_assigned_route() {
    var assigned_route_id = $(this).closest('div').data('assigned-route-id');
    var self = $(this);
    $.ajax({
        url: base_url + 'routes/remove_assigned_route',
        method: 'POST',
        dataType: 'html',
        data: {assigned_route_id: assigned_route_id}
    }).success(function (response) {
        $(self).closest('div.event').remove();
    });
}