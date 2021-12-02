
//<script>

Ossn.register_callback('ossn', 'init', 'ossn_wallet_create');

Ossn.RandomNumber = function(){
    var number = Math.floor(100000 + Math.random() * 900000);
    if(number){
        $('#number').val(number);
    }
};

Ossn.BuyNumber = function($user) {
    var form = '#jackpot-create-' + $user;
    Ossn.ajaxRequest({
        url: Ossn.site_url + "action/jackpot/create",
        form: form,
        action:true,
        beforeSend: function(request) {
            //$(form).find('input[type=submit]').hide();
            $(form).find('.ossn-loading').removeClass('ossn-hidden');
        },
        callback: function(callback) {
            if(callback !== '0'){
                location.href = Ossn.site_url + "jackpot/home"
            }
            $(form).find('.ossn-loading').addClass('ossn-hidden');
        }
    });
};




function ossn_wallet_create(){
    $(document).ready(function(){
    });
}

