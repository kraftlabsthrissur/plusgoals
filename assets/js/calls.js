$(document).ready(function () {
    $('body').on('change','.customer',customer_type); 
    $('body').on('change','.route',select_customer); 
    $('body').on('click','.add_prescribing',add_prescribing_products); 
    $('body').on('click','.closeList_pdct',remove_prescribing_products); 
    $('body').on('click','.add_sample_product',add_sample_product); 
    $('body').on('click','.closeList_sampl',remove_sample_product); 
    $('body').on('click','.view_call',callview); 
});

function customer_type(){
    var id=$(this).val();
    
      $('.customer_type').addClass('hidden');  
    
    $.ajax({
            url: base_url + 'calls/customer_type',
            method: 'POST',
            dataType: 'html',
            data: {id: id}
        }).success(function (response) {
            $('.customer_type').removeClass('hidden');
            $('.customer_type').html('<h4 style="color:blue;text-align:center;position: absolute;bottom:0px;">'+response+' </h4>');
           
        });
   
}
function add_prescribing_products(){
   var product_name=$(this).parents('.row').find('.prescribing_product').val(); 
  
   
                $('.prescribed_products').removeClass('hidden');
                $('.prescribed_products').append('<li class="col-xs-12" style="text-align:left;color:#00c0ef;" >\n\
                                                  <input type="hidden" class="product_name"name="product_name[]" value="' + product_name+ '">' 
                                                    + product_name + '<span a href="#" class="closeList_pdct pull-right">X</span></li>');
               
}
function remove_prescribing_products(){
    $(this).parents('li').remove();
}
function add_sample_product(){
   var sample_name=$(this).parents('.row').find('.sample_given').val(); 
   
   
                $('.sample_products').removeClass('hidden');
                $('.sample_products').append('<li class="col-xs-12" style="text-align:left;color:#00c0ef;" >\n\
                                                  <input type="hidden" class="sample_name"name="sample_name[]" value="' + sample_name+ '">' 
                                                    + sample_name + '<span a href="#" class="closeList_sampl pull-right">X</span></li>');
     
}
function remove_sample_product(){
    $(this).parents('li').remove(); 
}
function callview(){
   var id=$(this).data('call-id');
    
    $.ajax({
            url: base_url + 'calls/view_calls',
            method: 'POST',
            dataType: 'html',
            data: {id: id}
        }).success(function (response) {
            
            $('#view_calls .modal-content').html(response);
            $('#view_calls').modal();
        }); 
}
function select_customer(){
    var id=$(this).val();
    var t = new Date();
    
    $.ajax({
            url: base_url + 'calls/select_customer?t='+t.getTime(),
            method: 'POST',
            dataType: 'html',
            data: {id: id}
        }).success(function (response) {
            console.log(response);
            $('#select_customer').empty();
            $('#select_customer').append('<option >Select Customer</option>'+response);
           
        });
}