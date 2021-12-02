<?php

define('__OSSN_WALLET__', ossn_route()->com . 'OssnWallet/');
require_once(__OSSN_WALLET__ . 'classes/OssnWallet.php');

/**
 * Ossn wallets
 * Get object into function
 *
 * @return object
 */
function OssnWallet() {
		$OssnWallet = new OssnWallet;
		return $OssnWallet;
}
/**
 * Initilize the the component
 *
 * @return void
 */
function ossn_wallet() {
        //ossn_register_callback('login', 'created', 'create_wallet');
		ossn_extend_view('css/ossn.default', 'css/wallet');
		ossn_register_page('wallet', 'ossn_wallet_page');
        ossn_register_page('listen-transaction', 'listen_transaction_page');
		ossn_extend_view('js/ossn.site', 'js/OssnWallet');
		if(ossn_isLoggedin()) {
				ossn_register_action('wallet/create', __OSSN_WALLET__ . 'actions/wallet/create.php');
                ossn_register_action('wallet/withdraw', __OSSN_WALLET__ . 'actions/wallet/withdraw.php');
                ossn_register_action('wallet/swap', __OSSN_WALLET__ . 'actions/wallet/swap.php');
            ossn_register_action('wallet/send', __OSSN_WALLET__ . 'actions/wallet/send.php');
				$user_loggedin = ossn_loggedin_user();
				ossn_register_sections_menu('newsfeed', array(
						'name' => 'wallet',
                        'text' => ossn_print('wallet'),
						'url' => ossn_site_url('wallet/all'),
						'parent' => 'links',
						'icon' => false
				));
                ossn_register_menu_link('wallet', 'wallet', ossn_site_url('wallet/all'), 'user_timeline');

		}
        ossn_extend_view('css/ossn.default', 'css/wallet');

}


function create_wallet($callback, $type, $params){
    if(isset($params['guid'])){
        $wallet = new OssnWallet();
        $password = $wallet->generateRandomString(6);
        $dak = $wallet->createWallet('dak', $password);
        $usdt = $wallet->createWallet('usdt', $password);
    }
}

function listen_transaction_page() {
    $txs = json_decode(file_get_contents('php://input'), true);
    if(isset($txs['address']) && count($txs['transactions']) > 0){
        $wallet = new OssnWallet;
        $get = $wallet->getWalletByAddress($txs['address']);
        if(isset($get)){
            foreach ($txs['transactions'] as $tx){
                $wallet->addDeposit($tx);
            }
        }
        exit();
    }
}

/**
 * Ossn wallet page handler
 *
 * @param array $pages Pages
 *
 * @return mixed data
 */
function ossn_wallet_page($pages) {
    if(!ossn_isLoggedin()) {
            ossn_error_page();
    }
    $OssnWallet = new OssnWallet;
    $page         = $pages[0];
    if(empty($page)) {
        $page = 'wallet';
    }

    switch($page) {
        case 'all':
            $user = ossn_loggedin_user();
            $loggedin_guid          = $user->guid;
            $dak_password = $OssnWallet->generateRandomString(6);
            $OssnWallet->createWallet($OssnWallet::DAK, $dak_password);
            $dak = $OssnWallet->getWalletBySymbol($OssnWallet::DAK, $loggedin_guid);
            if($dak->balance == NULL && $user->balance > 0){
                $OssnWallet->updateDak($user->balance);
                $dak = $OssnWallet->getWalletBySymbol($OssnWallet::DAK, $loggedin_guid);
            }
            $dak_id = ($dak) ? $dak->id : 0;
            $params['dak'] = array(
                'wallet' =>$dak,
                'deposit' => $OssnWallet->getWalletLog($dak_id, $loggedin_guid, 'deposit'),
                'withdraw' => $OssnWallet->getWalletLog($dak_id, $loggedin_guid, 'withdraw'),
            );
            $usdt_password = $OssnWallet->generateRandomString(6);
            $OssnWallet->createWallet($OssnWallet::USDT, $usdt_password);
            $usdt = $OssnWallet->getWalletBySymbol($OssnWallet::USDT, $loggedin_guid);
            $usdt_id = ($usdt) ? $usdt->id : 0;
            $params['usdt'] = array(
                'wallet' =>$usdt,
                'deposit' => $OssnWallet->getWalletLog($usdt_id, $loggedin_guid, 'deposit'),
                'withdraw' => $OssnWallet->getWalletLog($usdt_id, $loggedin_guid, 'withdraw'),
            );
            $params['user'] = ossn_user_by_guid($loggedin_guid);
            $contents = array(
                'content' => ossn_plugin_view('wallet/pages/all', $params)
            );
            $title   = ossn_print('wallet');
            $content = ossn_set_page_layout('media', $contents);
            echo ossn_view_page($title, $content);
            break;
        case 'deposit':
            $loggedin_guid          = ossn_loggedin_user()->guid;
            $symbol = end($pages);
            checkSymbol($symbol);
            $wallet = $OssnWallet->getWalletBySymbol($symbol, $loggedin_guid);
            if($wallet == false || $wallet->address == null){
                redirect(REF);
            } else {
                $contents = array(
                    'content' => ossn_plugin_view('wallet/pages/deposit', array(
                        'info' => $wallet
                    ))
                );
            }
            $title   = ossn_print('deposit');
            $content = ossn_set_page_layout('media', $contents);
            echo ossn_view_page($title, $content);
            break;
        case 'withdraw':
            $loggedin_guid          = ossn_loggedin_user()->guid;
            $symbol = end($pages);
            checkSymbol($symbol);
            $wallet = $OssnWallet->getWalletBySymbol($symbol, $loggedin_guid);
            if(!$wallet || $wallet->address == null){
                redirect(REF);
            } else {
                $contents = array(
                    'content' => ossn_plugin_view('wallet/pages/form/withdraw', array(
                        'wallet' => $wallet,
                    ))
                );
            }
            $title   = ossn_print('withdraw');
            $content = ossn_set_page_layout('media', $contents);
            echo ossn_view_page($title, $content);
            break;
        case 'swap':
            $loggedin_guid          = ossn_loggedin_user()->guid;
            $symbol = end($pages);
            checkSymbol($symbol);
            $wallet = $OssnWallet->getWalletBySymbol($symbol, $loggedin_guid);
            if($wallet == false || $wallet->address == null){
                redirect(REF);
            } else {
                $contents = array(
                    'content' => ossn_plugin_view('wallet/pages/form/swap', array(
                        'wallet' => $wallet
                    ))
                );
            }
            $title   = ossn_print('swap');
            $content = ossn_set_page_layout('media', $contents);
            echo ossn_view_page($title, $content);
            break;
        case 'create':
            $loggedin_guid          = ossn_loggedin_user()->guid;
            $symbol = $OssnWallet::DAK;
            $contents = array(
                'content' => ossn_plugin_view('wallet/pages/form/create', array(
                    'symbol' => $symbol,
                    'user_id' => $loggedin_guid
                ))
            );
            $title   = ossn_print('Create new wallet');
            $content = ossn_set_page_layout('media', $contents);
            echo ossn_view_page($title, $content);
            break;
        case 'send':
            $loggedin_guid          = ossn_loggedin_user()->guid;
            $symbol = 'dak';
            checkSymbol($symbol);
            $wallet = $OssnWallet->getWalletBySymbol($symbol, $loggedin_guid);
            if($wallet == false || $wallet->address == null){
                redirect(REF);
            } else {
                $contents = array(
                    'content' => ossn_plugin_view('wallet/pages/form/send', array(
                        'wallet' => $wallet
                    ))
                );
            }
            $title   = ossn_print('send');
            $content = ossn_set_page_layout('media', $contents);
            echo ossn_view_page($title, $content);
            break;
        default:
            ossn_error_page();
            break;

    }

}


function checkSymbol($symbol){
    $array = array(
        'dak',
        'usdt'
    );
    if(in_array($symbol, $array)){
        return true;
    } else {
        redirect(REF);
    }

}

ossn_register_callback('ossn', 'init', 'ossn_wallet');
