jQuery(document).ready(function($) {

    var url = '/vision6_Subscription/register-account.php';

    jQuery('.woocommerce-form-register').submit(ajaxSubmit);

    var subscribeToVision6 = document.getElementById("vision6_subscribe_on_register").checked;

    function ajaxSubmit() {
        jQuery.ajax({
            url:     url,
            type:    "POST",
            dataType: 'json',
            data:    {
            fname: jQuery("#reg_billing_first_name").val(),
            lname: jQuery("#reg_billing_last_name").val(),
            email: jQuery("#reg_email").val(),
            fsubscribe: jQuery("#vision6_subscribe_on_register:checked").length,
            },
            success: function(data) {
                if(data.exist ===1){
                 $('.woocommerce-privacy-policy-text').html('<p style="color:red;">Oops! Looks like you already have an account with us.</p>');
                 console.log('already exist');
                 console.log(data.contacts);
                 console.log(data.fsubscribe_val);
                }else{
                  $('.woocommerce-privacy-policy-text').html('');
                  console.log('success');
                  console.log(data.contacts);
                  console.log(data.fsubscribe_val);
                }
            }
        });

        return true;
    }
});
