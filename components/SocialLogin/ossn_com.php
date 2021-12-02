<?php
/**
 * Open Source Social Network
 *
 * @package Open Source Social Network
 * @author    OSSN Core Team <info@openteknik.com>
 * @copyright (C) OPENTEKNIK  LLC, COMMERCIAL LICENSE
 * @license   OPENTEKNIK  LLC, COMMERCIAL LICENSE, COMMERCIAL LICENSE https://www.openteknik.com/license/commercial-license-v1
 * @link      http://www.opensource-socialnetwork.org/licence
 */
define('SOCIAL_LOGIN', ossn_route()->com . 'SocialLogin/');

require_once SOCIAL_LOGIN . 'classes/Login.php';
/**
 * Social Login Init
 *
 * @return void
 */
function social_login_init() {
		ossn_register_page('social_login', 'social_login_handler');
		ossn_register_com_panel('SocialLogin', 'settings');

		ossn_extend_view('css/ossn.default', 'css/social/login');
		ossn_extend_view('css/ossn.admin.default', 'css/social/adminform');
		ossn_extend_view('forms/login2/before/submit', 'social/login');

		if(ossn_isAdminLoggedin()) {
				ossn_register_action('social_login/settings', SOCIAL_LOGIN . 'actions/settings.php');
		}
		if(!ossn_isLoggedin()) {
				ossn_register_action('social/login/facebook', SOCIAL_LOGIN . 'actions/login/facebook.php');
				ossn_register_action('social/login/twitter', SOCIAL_LOGIN . 'actions/login/twitter.php');
				ossn_register_action('social/login/google', SOCIAL_LOGIN . 'actions/login/google.php');
				ossn_register_action('social/login/apple', SOCIAL_LOGIN . 'actions/login/apple.php');
		}

		#ossn_add_hook('page', 'load', 'social_login_user_details_check');
}
/**
 * Social Login user details check
 *
 * @return void
 */
function social_login_user_details_check($hook, $type, $return, $params) {
		if(ossn_isLoggedin()) {
				$user    = ossn_loggedin_user();
				$context = ossn_get_context();
				$allowed = array(
						'css',
						'js',
						'u',
				);
				if((!isset($user->gender) || !isset($user->birthdate)) && !in_array($params['handler'], $allowed)) {
						ossn_trigger_message(ossn_print('social:login:fill:profile'), 'error');
						redirect("u/{$user->username}/edit");
				}
		}
}
/**
 * Social Login Details
 *
 * @return object
 */
function social_login_cred() {
		$component = new OssnComponents();
		$settings  = $component->getSettings('SocialLogin');

		$oauth           = new stdClass();
		$oauth->facebook = new stdClass();
		$oauth->twitter  = new stdClass();
		$oauth->google   = new stdClass();
		$oauth->apple    = new stdClass();

		$oauth->facebook->consumer_key    = !isset($settings->fb_consumer_key) ? '' : $settings->fb_consumer_key;
		$oauth->facebook->consumer_secret = !isset($settings->fb_consumer_secret) ? '' : $settings->fb_consumer_secret;
		$oauth->facebook->button          = !isset($settings->fb_enable) ? '' : $settings->fb_enable;

		$oauth->twitter->consumer_key    = !isset($settings->tw_consumer_key) ? '' : $settings->tw_consumer_key;
		$oauth->twitter->consumer_secret = !isset($settings->tw_consumer_secret) ? '' : $settings->tw_consumer_secret;
		$oauth->twitter->button          = !isset($settings->tw_enable) ? '' : $settings->tw_enable;

		$oauth->google->client_id     = !isset($settings->google_client_id) ? '' : $settings->google_client_id;
		$oauth->google->client_secret = !isset($settings->google_client_secret) ? '' : $settings->google_client_secret;
		$oauth->google->button        = !isset($settings->google_enable) ? '' : $settings->google_enable;

		$oauth->apple->client_id  = !isset($settings->apple_client_id) ? '' : $settings->apple_client_id;
		$oauth->apple->team_id    = !isset($settings->apple_team_id) ? '' : $settings->apple_team_id;
		$oauth->apple->keyfile_id = !isset($settings->apple_keyfile_id) ? '' : $settings->apple_keyfile_id;
		$oauth->apple->button     = !isset($settings->apple_enable) ? '' : $settings->apple_enable;

		return $oauth;
}
/**
 * Apple Keyfile
 *
 * @return boolean|string
 */
function social_login_apple_keyfile() {
		$file = ossn_get_userdata('social_login/apple_key_file.p8');
		if(is_file($file)) {
				return $file;
		}
		return false;
}
/**
 * Social login pages
 *
 * @param array $pages A list of handlers
 *
 * @return void
 */
function social_login_handler($pages) {
		$page = $pages[0];
		switch($page) {
			case 'facebook':
				$login       = new Login();
				$helper      = $login->initFb()->getRedirectLoginHelper();
				$accessToken = $helper->getAccessToken(ossn_site_url('social_login/facebook')); //facebook api issues
				$user        = $login
						->initFb()
						->get('/me?fields=id,first_name,last_name,email', (string) $accessToken)
						->getGraphUser();
				//$image       = $login->initFb()->get('/me/picture?redirect=false&type=large', (string) $accessToken)->getGraphUser();
				$ossnuser = ossn_user_by_email($user['email']);
				if(!$ossnuser) {
						$username = preg_replace('/\s+/', '', $user['first_name']);
						if(strlen($username) <= 4) {
								$username = $username . substr(uniqid(), 5);
						}
						$i = 1;
						while(ossn_user_by_username($username)) {
								$username = $username . '' . $i;
								$i++;
						}
						$password_minimum = ossn_call_hook('user', 'password:minimum:length', false, 6);
						$password         = substr(md5(time()), 0, $password_minimum);

						$add             = new OssnUser();
						$add->username   = $username;
						$add->first_name = $user['first_name'];
						$add->last_name  = $user['last_name'];
						$add->email      = $user['email'];
						$add->password   = $password;
						$add->validated  = true;
						if($add->addUser()) {
								if($add->Login()) {
										redirect('home');
								}
						} else {
								ossn_trigger_message(ossn_print('social:login:account:create:error'), 'error');
								redirect(REF);
						}
				} else {
						OssnSession::assign('OSSN_USER', $ossnuser);
						redirect('home');
				}
				break;
			case 'apple':
			case 'google':
				$config = social_login_cred();
				require_once SOCIAL_LOGIN . 'vendors/Google/vendor/autoload.php';
				if($page == 'google') {
						$provider = new League\OAuth2\Client\Provider\Google(array(
								'clientId'     => $config->google->client_id,
								'clientSecret' => $config->google->client_secret,
								'redirectUri'  => ossn_site_url('social_login/google'),
								'accessType'   => 'offline',
						));
				}
				if($page == 'apple') {
						Firebase\JWT\JWT::$leeway = 60;
						$provider                 = new League\OAuth2\Client\Provider\Apple(array(
								'clientId'    => $config->apple->client_id,
								'teamId'      => $config->apple->team_id,
								'keyFileId'   => $config->apple->keyfile_id,
								'keyFilePath' => social_login_apple_keyfile(),
								'redirectUri' => ossn_site_url('social_login/apple'),
						));
				}
				$error = input('error');
				$code  = input('code');
				if($error) {
						ossn_trigger_message($error, 'error');
						redirect();
				}
				try {
						$token = $provider->getAccessToken('authorization_code', array(
								'code' => $code,
						));

						$ownerDetails = $provider->getResourceOwner($token);
						$firstname    = $ownerDetails->getFirstName();
						$lastname     = $ownerDetails->getLastName();
						$email        = $ownerDetails->getEmail();

						$ossnuser = ossn_user_by_email($email);
						if(empty($email) || !$ossnuser) {
								$username = preg_replace('/\s+/', '', $firstname . $lastname);
								if(strlen($username) <= 4) {
										$username = $username . substr(uniqid(), 5);
								}
								$i = 1;
								while(ossn_user_by_username($username)) {
										$username = $username . '' . $i;
										$i++;
								}
								$password_minimum = ossn_call_hook('user', 'password:minimum:length', false, 6);
								$password         = substr(md5(time()), 0, $password_minimum);

								$add             = new OssnUser();
								$add->username   = $username;
								$add->first_name = $firstname;
								$add->last_name  = $lastname;
								$add->email      = $email;
								$add->password   = $password;
								$add->validated  = true;
								if($add->addUser()) {
										if($add->Login()) {
												redirect('home');
										}
								} else {
										ossn_trigger_message(ossn_print('social:login:account:create:error'), 'error');
										redirect(REF);
								}
						} else {
								OssnSession::assign('OSSN_USER', $ossnuser);
								redirect('home');
						}
				} catch (Exception $e) {
						ossn_trigger_message("{$page} 403", 'error');
						redirect('login');
				}

				break;
			case 'twitter':
				$oauth_verifier = input('oauth_verifier');
				if($oauth_verifier) {
						$request_token                       = array();
						$request_token['oauth_token']        = $_SESSION['social:login:twitter:oauth_token'];
						$request_token['oauth_token_secret'] = $_SESSION['social:login:twitter:oauth_token_secret'];

						$config = social_login_cred();
						require_once SOCIAL_LOGIN . 'vendors/Twitter/autoload.php';
						$connection = new \Abraham\TwitterOAuth\TwitterOAuth(
								$config->twitter->consumer_key,
								$config->twitter->consumer_secret,
								$request_token['oauth_token'],
								$request_token['oauth_token_secret']
						);
						$access_token = $connection->oauth('oauth/access_token', array(
								'oauth_verifier' => $oauth_verifier,
						));

						//new connection on beahlf of user
						if(isset($access_token['oauth_token']) && !empty($access_token['oauth_token'])) {
								$connection = new \Abraham\TwitterOAuth\TwitterOAuth(
										$config->twitter->consumer_key,
										$config->twitter->consumer_secret,
										$access_token['oauth_token'],
										$access_token['oauth_token_secret']
								);

								$user = $connection->get('account/verify_credentials', array(
										'include_email' => 'true',
								));
								if(isset($user->email) && !empty($user->email) && isset($user->name)) {
										$ossnuser = ossn_user_by_email($user->email);
										if(!$ossnuser) {
												//username
												$username = preg_replace('/\s+/', '', $user->name);
												if(strlen($username) <= 4) {
														$username = $username . substr(uniqid(), 5);
												}
												$i = 1;
												while(ossn_user_by_username($username)) {
														$username = $username . '' . $i;
														$i++;
												}
												$password_minimum = ossn_call_hook('user', 'password:minimum:length', false, 6);
												$password         = substr(md5(time()), 0, $password_minimum);

												//first last name
												$name       = explode(' ', $user->name);
												$first_name = $name[0];
												if(isset($name[1]) && !empty($name[1])) {
														$last_name = $name[1];
												} else {
														$last_name = $name[0];
												}
												$add             = new OssnUser();
												$add->username   = $username;
												$add->first_name = $first_name;
												$add->last_name  = $last_name;
												$add->email      = $user->email;
												$add->password   = $password;
												$add->validated  = true;
												if($add->addUser()) {
														if($add->Login()) {
																unset($_SESSION['social:login:twitter:oauth_token']);
																unset($_SESSION['social:login:twitter:oauth_token_secret']);
																redirect('home');
														}
												} else {
														ossn_trigger_message(ossn_print('social:login:account:create:error'), 'error');
														redirect(REF);
												}
										} else {
												OssnSession::assign('OSSN_USER', $ossnuser);
												redirect('home');
										}
								}
						}
				}

				break;
		}
}
ossn_register_callback('ossn', 'init', 'social_login_init');