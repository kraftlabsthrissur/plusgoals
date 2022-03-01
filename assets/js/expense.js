$(document).ready(function () {
    $('body').on('change', '.da', calculate_total);
   // $('body').on('change', '.ta', calculate_total);
    $('body').on('change', '#ta_bus_amount', calculate_total);
    $('body').on('change', '.ta_bike_km', calculate_total);
    $('body').on('change', '.ta_bike_amount', calculate_total);
    $('body').on('change', '.lodge', calculate_total);
    $('body').on('change', '.courier', calculate_total);
    $('body').on('change', '.sundries', calculate_total);
    $('body').on('change', '.total', calculate_total);
    $('body').on('click', '#expenseView', view_expenses);
    $('body').on('click', '#reject_expense', reject_expense);
    $('body').on('click', '#accept_expense', accept_expense);
    $('body').on('click', '#expense_report_table', expense_report_table);
    $('body').on('change', '.ta_type', select_ta_type);
    
     
   
});

function calculate_total() {

    var total = parseFloat($('.expenses .da').val()) + parseFloat($('.expenses .ta_bike_amount').val()) + parseFloat($('.expenses #ta_bus_amount').val())
            + parseFloat($('.expenses .lodge').val()) + parseFloat($('.expenses .courier').val())
            + parseFloat($('.expenses .sundries').val());

    if (isNaN(total)) {
        $('.expenses .total').val(0);
    } else {
        $('.expenses .total').val(total);
    }
}
function view_expenses() {
    var id = $(this).parents('td').find('#expense_id').val();

    $.ajax({
        url: base_url + 'expense/view_expense',
        method: 'POST',
        dataType: 'html',
        data: {id: id}
    }).success(function (response) {

        $('#view_expenses .modal-content').html(response);
        $('#view_expenses').modal();
    });
}
function reject_expense() {
    var id = $(this).parents('.clearfix').find('.expense_id').val();
    var role = $(this).parents('.clearfix').find('.role_id').val();
    console.log(id)
    $.ajax({
        url: base_url + 'expense/reject_expenses',
        method: 'POST',
        dataType: 'html',
        data: {id: id,role:role}
    }).success(function (response) {

    });
}
function accept_expense() {
    var id = $(this).parents('.clearfix').find('.expense_id').val();
    var role = $(this).parents('.clearfix').find('.role_id').val();
    $.ajax({
        url: base_url + 'expense/accept_expenses',
        method: 'POST',
        dataType: 'html',
        data: {id: id,role:role}
    }).success(function (response) {


    });
}
function expense_report_table() {

    var user_id = $('.expense_report_from').find('select[name="user_id"] :selected').val();
    var from_date = $('.expense_report_from').find('input[name="from_date"]').val();
    var to_date = $('.expense_report_from').find('input[name="to_date"]').val();
    var status = $('.expense_report_from').find('select[name="expense_status"]').val();
    $.ajax({
        url: base_url + 'expensereport/expense_report_table',
        method: 'POST',
        dataType: 'html',
        data: {user_id: user_id, from_date: from_date, to_date: to_date, status: status}
    }).success(function (response) {
        $('.expense_report_table').removeClass('hidden');
        $('.expense_report_table').html(response);
    });
}

function select_ta_type(){
   var ta_type=$('select[name="ta_type"] :selected').val();
   if(ta_type=='by_bike'){
    $('.ta_bike').removeClass('hidden');
    $('.ta_bus').addClass('hidden');
    $('.ta_bus input').val(0);
    }else{
        $('.ta_bus').removeClass('hidden');
        $('.ta_bike').addClass('hidden');
        $('.ta_bike .ta_bike_km').val(0);
        $('.ta_bike .ta_bike_amount').val(0);
    }
}