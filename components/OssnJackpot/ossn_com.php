<?php

define('__OSSN_JACKPOT__', ossn_route()->com . 'OssnJackpot/');
require_once(__OSSN_JACKPOT__ . 'classes/OssnJackpot.php');
//require_once(__OSSN_JACKPOT__ . 'classes/Curl.php');

/**
 * Get object into function
 *
 * @return object
 */
function OssnJackpot() {
		$OssnJackot = new OssnJackpot;
		return $OssnJackot;
}
/**
 * Initilize the the component
 *
 * @return void
 */
function ossn_jackpot() {

        ossn_new_external_js('ossn.jackpot.bootstrap-datepicker', ossn_add_cache_to_url('components/OssnJackpot/vendors/bootstrap-datepicker-1.9.0-dist/js/bootstrap-datepicker.min.js'));
        ossn_load_external_js('ossn.jackpot.bootstrap-datepicker');
        ossn_new_external_css('ossn.jackpot.bootstrap-datepicker', ossn_add_cache_to_url('components/OssnJackpot/vendors/bootstrap-datepicker-1.9.0-dist/css/bootstrap-datepicker.standalone.css'));
        ossn_load_external_css('ossn.jackpot.bootstrap-datepicker');

        ossn_register_page('jackpot', 'ossn_jackpot_page');
		ossn_extend_view('js/ossn.site', 'js/OssnJackpot');
		if(ossn_isLoggedin()) {
				ossn_register_action('jackpot/create', __OSSN_JACKPOT__ . 'actions/jackpot/create.php');
				$user_loggedin = ossn_loggedin_user();
				ossn_register_sections_menu('newsfeed', array(
						'name' => 'jackpot',
                        'text' => ossn_print('jackpot'),
						'url' => ossn_site_url('jackpot/home'),
						'parent' => 'links',
						'icon' => false
				));
                ossn_register_menu_link('jackpot', ossn_print('jackpot'), ossn_site_url('jackpot/home'), 'user_timeline');

		}


    ossn_extend_view('css/ossn.default', 'css/jackpot');
}




/**
 * Ossn jackpot page handler
 *
 * @param array $pages Pages
 *
 * @return mixed data
 */
function ossn_jackpot_page($pages) {
    if(!ossn_isLoggedin()) {
            ossn_error_page();
    }
    $jackpot = new OssnJackpot();
    $page         = $pages[0];
    if(empty($page)) {
        $page = 'wallet';
    }

    switch($page) {
        case 'home':
            $user = ossn_loggedin_user();
            $loggedin_guid = $user->guid;
            $todayJackpot = $jackpot->getTopTenJackpot();
            $params['today_jackpot'] = $todayJackpot;
            $myJackpot = $jackpot->getMyNumber();
            $params['my_jackpot'] = $myJackpot;
            $contents = array(
                'content' => ossn_plugin_view('jackpot/pages/home', $params)
            );
            $title   = ossn_print('Jackpot');
            $content = ossn_set_page_layout('media', $contents);
            echo ossn_view_page($title, $content);
            break;
        case 'create':
            $loggedin_guid          = ossn_loggedin_user()->guid;
            $today = date('Y-m-d', time());
            $OssnWallet = new OssnWallet;
            $wallet = $OssnWallet->getWalletBySymbol(OssnWallet::DAK, $loggedin_guid);
            if(!$wallet || $wallet->address == null){
                redirect(REF);
            }
            $contents = array(
                'content' => ossn_plugin_view('jackpot/pages/form/create', array(
                    'user_id' => $loggedin_guid,
                    'today' => $today,
                    'wallet' => $wallet,
                ))
            );
            $title   = ossn_print('Buy New Number');
            $content = ossn_set_page_layout('media', $contents);
            echo ossn_view_page($title, $content);
            break;
        default:
            ossn_error_page();
            break;

    }

}



ossn_register_callback('ossn', 'init', 'ossn_jackpot');
