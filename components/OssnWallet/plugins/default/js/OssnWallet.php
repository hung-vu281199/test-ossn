
//<script>

    Ossn.register_callback('ossn', 'init', 'ossn_wallet_swap');
    Ossn.register_callback('ossn', 'init', 'ossn_wallet_send');
Ossn.CreateWallet = function($user) {
    Ossn.ajaxRequest({
        url: Ossn.site_url + "action/wallet/create",
        form: '#wallet-create-' + $user,
        action:true,
        beforeSend: function(request) {
            $('#wallet-create-' + $user).find('label').hide();
            $('#wallet-create-' + $user).find('#password').hide();
            $('#wallet-create-' + $user).find('input[type=submit]').hide();
            $('#wallet-create-' + $user).find('.ossn-loading').removeClass('ossn-hidden');
        },
        callback: function(callback) {
            if(callback !== '0'){
                  $('.wallet-append').append(callback);
            }
            //$('#wallet-create-' + $user).find('input[type=submit]').show();
            $('#wallet-create-' + $user).find('.ossn-loading').addClass('ossn-hidden');
        }
    });
};




function ossn_wallet_swap(){
    $(document).ready(function(){
        $("#swapAmount").on("change paste keyup select", function() {
            var symbol = $('#swapSymbol').val();
            var balance = parseInt($('#swapBalance').val());
            var amount = parseInt($(this).val());
            if(symbol == 'DAK' && amount <= balance){
                var receive = amount/10;
                $('.receive').html(receive);
            } else if(symbol == 'USDT' && amount <= balance){
                var receive = amount*10;
                $('.receive').html(receive);
            } else {
                $('.receive').html(0);
            }

        });



    });
}

    function ossn_wallet_send(){
        $(document).ready(function(){
            var check_amount = false;
            $("#amount").on("change paste keyup select", function() {
                var amount = parseInt($(this).val());
                if(amount > 0){
                    check_amount = true;
                }
            });
            $("#username").on("change paste keyup select", function() {
                var username = $(this).val();
                if(username.length >= 5 && check_amount){
                    $('#send').removeAttr('disabled');
                } else {
                    $('#send').attr('disabled');
                }
            });
        });
    }

