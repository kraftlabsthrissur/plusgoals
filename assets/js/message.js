$(document).ready(function () {
    $('body').on('change','#select_all_users',select_all_user);
    $('body').on('change','.select_checkbox',select_checkbox);
    $('body').on('click','#select_user_message',message_form);
    $('body').on('click','#send_message',send_message);
    $('body').on('click','#filter',filter_table);
    
});
function select_all_user(){
     $(".select_checkbox").prop('checked', $(this).prop('checked'));
 }
function select_checkbox(){
     if ($('.select_checkbox:checked').length == $('.select_checkbox').length ){ 
        $("#select_all_users").prop('checked',true); //change "select all" checked status to true
    }else{
        $("#select_all_users").prop('checked', false);
    }
 }
 function message_form() {
    var v = [];
    $('.select_checkbox:checked').each(function (i) {
        v[i] = $(this).val();
       // console.log(v);
    })
    $('.message_form').find('.select_user_id').val(v);
    $('.message_form').modal();
}
function send_message(){
    
   var user_id=$('.message_form').find('.select_user_id').val();
   var message_head=$('.message_form').find('.message_head').val();
   var message_content=$('.message_form').find('.message_content').val();
   console.log(user_id,message_head,message_content);
    $.ajax({
            url: base_url + 'messages/save_message',
            method: 'POST',
            dataType: 'html',
            data: {user_id: user_id,message_head:message_head,message_content:message_content}
        }).success(function (response) {
            console.log(response);
            $('.message_form').modal('toggle');
        });
}
function filter_table(){
    alert('sdf');
   
//      var role_name=$('.filtered_role').val();
//      $.ajax({
//            url: base_url + 'messages/filter_user',
//            method: 'POST',
//            dataType: 'html',
//            data: {role_name: role_name}
//        }).success(function (response) {
//           
//        });
     

}