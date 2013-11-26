<?php

/*
Plugin Name: IP2Location Country Blocker
Plugin URI: http://ip2location.com/tutorials/wordpress-ip2location-country-blocker
Description: Block visitors from accessing your website or admin area by their country.
Version: 1.0
Author: IP2Location
Author URI: http://www.ip2location.com
*/

define('DS', DIRECTORY_SEPARATOR);
define('_ROOT', dirname(__FILE__) . DS);

$parts = explode(DS, dirname(__FILE__));
array_pop($parts);
array_pop($parts);

define('IP2LOCATION_DB', implode(DS, $parts) . DS . 'ip2location' . DS);

class IP2LocationCountryBlocker {
	function admin_options() {
		if(is_admin()) {
			echo '
			<div class="wrap">
				<h2>IP2Location Country Blocker</h2>
				<p>
					IP2Location Country Blocker allows user to easily block visitors from accessing your frontend (the blog pages) or backend (the admin area) based on their country. This plugin uses IP2Location BIN file for location queries that free your hassle from setting up the relational database.<br/><br/>
					BIN file download: <a href="http://www.ip2location.com/?r=wordpress" target="_blank">IP2Location Commercial database</a> | <a href="http://lite.ip2location.com/?r=wordpress" targe="_blank">IP2Location LITE database (free edition)</a>.
				</p>

				<p>&nbsp;</p>';

			if(!file_exists(IP2LOCATION_DB . 'database.bin')){
				echo '
				<div style="border:1px solid #990000;background:#ffecff;padding:10px">
					Unable to find the IP2Location BIN file! Please follow the below instructions to install the BIN file:
					<ul style="list-style-type:circle;margin-left:20px">
						<li>Download the BIN file at the following links: <a href="http://www.ip2location.com/?r=wordpress" target="_blank">IP2Location commercial database</a> | <a href="http://lite.ip2location.com/?r=wordpress" target="_blank">IP2Location LITE database (free edition)</a>.</li>
						<li>Decompress the zip file and rename the BIN file (with .BIN extension) to <b>database.bin</b>.</li>
						<li>Upload <b>database.bin</b> to /wp-content/ip2location. Note: Please create <b>ip2location</b> folder if it doesn\'t exist.</li>
					</ul>
				</div>';
			}
			else{
				echo '
				<p>
					<b>Database Version: </b>
					' . date('F Y', filemtime(IP2LOCATION_DB . 'database.bin')) . '
				</p>';

				if(filemtime(IP2LOCATION_DB . 'database.bin') < strtotime('-2 months')){
					echo '
					<p style="border:1px solid #990000;background:#ffecff;padding:10px">
						<b>Reminder: </b>Your IP2Location database was outdated. Please download the latest version from <a href="http://www.ip2location.com/?r=wordpress" target="_blank">IP2Location commercial database</a> or <a href="http://lite.ip2location.com/?r=wordpress" target="_blank">IP2Location LITE database (free edition)</a>..
					</p>
					<p style="border:1px solid #990000;background:#ffecff;padding:10px">
						After downloaded the package, decompress it and rename the .BIN file inside the package to <strong>database.bin</strong>. Then, upload the BIN file,<strong>database.bin</strong>, to <em>/wp-content/ip2location/</em>.
					</p>';
				}
			}

			echo '
				<p>&nbsp;</p>
				<a name="ip-query"></a>
				<h3>Query IP</h3>
				<p>
					Enter a valid IP address for checking.
				</p>';

			$ipAddress = (isset($_POST['ipAddress'])) ? $_POST['ipAddress'] : '';

			if(isset($_POST['lookup'])){
				if(!filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)){
					echo '<p style="color:#cc0000">Invalid IP address.</p>';
				}
				else{
					$result = IP2LocationCountryBlocker::get_location($ipAddress);
					echo '<p style="color:#666600">IP address <b>' . $ipAddress . '</b> belongs to <b>' . $result['countryName'] . '</b>.</p>';

					$banlist = get_option('icb_frontend_banlist');
					if(is_array($banlist) && in_array($result['countryCode'], $banlist)){
						echo '<p style="color:#666600">Visitors from this country are being blocked from accessing your frontend website.</p>';
					}

					$banlist = get_option('icb_backend_banlist');
					if(is_array($banlist) && in_array($result['countryCode'], $banlist)){
						echo '<p style="color:#666600">Visitors from this country are being blocked from accessing your backend website (admin area).</p>';
					}
				}
			}

			$countries = IP2LocationCountryBlocker::list_countries();
			$frontendEnabled = (isset($_POST['saveFrontend']) && isset($_POST['frontendEnabled'])) ? 1 : (((isset($_POST['saveFrontend']) && !isset($_POST['frontendEnabled'])))? 0 : get_option('icb_frontend_enabled'));
			$backendEnabled = (isset($_POST['saveBackend']) && isset($_POST['backendEnabled'])) ? 1 : (((isset($_POST['saveBackend']) && !isset($_POST['backendEnabled'])))? 0 : get_option('icb_backend_enabled'));
			$frontendBanlist = (isset($_POST['frontendBanlist'])) ? $_POST['frontendBanlist'] : get_option('icb_frontend_banlist');
			$backendBanlist = (isset($_POST['backendBanlist'])) ? $_POST['backendBanlist'] : get_option('icb_backend_banlist');
			$frontendOption = (isset($_POST['frontendOption'])) ? $_POST['frontendOption'] : get_option('icb_frontend_option');
			$backendOption = (isset($_POST['backendOption'])) ? $_POST['backendOption'] : get_option('icb_backend_option');
			$frontendTarget = (isset($_POST['frontendTarget'])) ? $_POST['frontendTarget'] : get_option('icb_frontend_target');
			$backendTarget = (isset($_POST['backendTarget'])) ? $_POST['backendTarget'] : get_option('icb_backend_target');

			echo '
				<form action="#ip-query" method="post">
					<p>
						<label><b>IP Address: </b></label>
						<input type="text" name="ipAddress" value="' . $ipAddress . '" maxlength="15" />
						<input type="submit" name="lookup" value="Lookup" />
					</p>
				</form>

				<p>&nbsp;</p>

				<a name="frontend-block-list"></a>
				<h3>Frontend Block List</h3>';

				if(isset($_POST['saveFrontend'])){
					if(!empty($frontendTarget) && !filter_var($frontendTarget, FILTER_VALIDATE_URL)){
						echo '<p style="color:#cc0000">Invalid URL provided.</p>';
					}
					elseif($frontendOption == 2 && empty($frontendTarget)){
						echo '<p style="color:#cc0000">Please provide a valid URL for redirection.</p>';
					}
					else{
						update_option('icb_frontend_enabled', $frontendEnabled);
						update_option('icb_frontend_banlist', $frontendBanlist);
						update_option('icb_frontend_option', $frontendOption);
						update_option('icb_frontend_target', $frontendTarget);

						echo '<p style="color:#666600">Changes are successfully saved.</p>';
					}
				}

				echo '
				<form action="#frontend-block-list" method="post">
					<p>
						<input type="checkbox" name="frontendEnabled" id="frontendEnabled"' . (($frontendEnabled) ? ' checked' : '') . '>
						<label for="frontendEnabled"> Enable Frontend Blocking</label>
					</p>
					<p>
						Select countries that you wish to block the access from frontend (blog pages). Press "CTRL" for multiple selection.
					</p>
					<p>
						<select name="frontendBanlist[]" multiple="true" style="width:500px;height:200px">';

				foreach($countries as $countryCode=>$countryName){
					echo '
						<option value="' . $countryCode . '"' . ((in_array($countryCode, $frontendBanlist)) ? ' selected' : '') . '> ' . $countryName . '</option>';
				}

				echo '
						</select>
					</p>
					<p>
						Show the following page when visitor is blocked.
					</p>
					<p>
						<input type="radio" name="frontendOption" value="1" id="frontendOption-1"' . (($frontendOption == 1) ? ' checked' : '') . '>
						<label for="frontendOption-1"> Page Error 403: Access Denied</label>
						<br />
						<input type="radio" name="frontendOption" value="2" id="frontendOption-2"' . (($frontendOption == 2) ? ' checked' : '') . '>
						<label for="frontendOption-2"> URL: </label>
						<input type="text" name="frontendTarget" value="' . $frontendTarget . '" size="80" onfocus="document.getElementById(\'frontendOption-2\').checked=true;" />
					</p>
					<p>
						<input type="submit" name="saveFrontend" value="Save" />
					</p>
				</form>

				<p>&nbsp;</p>

				<a name="backend-block-list"></a>
				<h3>Backend (Admin Area) Block List</h3>';

				if(isset($_POST['saveBackend'])){
					if(!empty($backendTarget) && !filter_var($backendTarget, FILTER_VALIDATE_URL)){
						echo '<p style="color:#cc0000">Invalid URL provided.</p>';
					}
					elseif($backendOption == 2 && empty($backendTarget)){
						echo '<p style="color:#cc0000">Please provide a valid URL for redirection.</p>';
					}
					else{
						update_option('icb_backend_enabled', $backendEnabled);
						update_option('icb_backend_banlist', $backendBanlist);
						update_option('icb_backend_option', $backendOption);
						update_option('icb_backend_target', $backendTarget);

						echo '<p style="color:#666600">Changes are successfully saved.</p>';
					}
				}

				echo '
				<form action="#backend-block-list" method="post">
					<p>
						<input type="checkbox" name="backendEnabled" id="backendEnabled"' . (($backendEnabled) ? ' checked' : '') . '>
						<label for="backendEnabled"> Enable Backend Blocking</label>
					</p>
					<p>
						Select countries that you wish to block the access from backend (admin area). Press "CTRL" for multiple selection.
					</p>
					<p>
						<select name="backendBanlist[]" multiple="true" style="width:500px;height:200px">';

				foreach($countries as $countryCode=>$countryName){
					echo '
						<option value="' . $countryCode . '"' . ((in_array($countryCode, $backendBanlist)) ? ' selected' : '') . '> ' . $countryName . '</option>';
				}

				echo '
						</select>
					</p>
					<p>
						Show the following page when visitor is blocked.
					</p>
					<p>
						<input type="radio" name="backendOption" value="1" id="backendOption-1"' . (($backendOption == 1) ? ' checked' : '') . '>
						<label for="backendOption-1"> Page Error 403: Access Denied</label>
						<br />
						<input type="radio" name="backendOption" value="2" id="backendOption-2"' . (($backendOption == 2) ? ' checked' : '') . '>
						<label for="backendOption-2"> URL: </label>
						<input type="text" name="backendTarget" value="' . $backendTarget . '" size="80" onfocus="document.getElementById(\'backendOption-2\').checked=true;" />
					</p>
					<p>
						<input type="submit" name="saveBackend" value="Save" />
					</p>
				</form>

				<p style="height:200px">&nbsp;</p>';
		}
	}

	function check(){
		$_SERVER['REMOTE_ADDR'] = '8.8.8.8';
		$ipAddress = $_SERVER['REMOTE_ADDR'];

		if(isset($_SERVER["HTTP_X_FORWARDED_FOR"]) && filter_var($_SERVER["HTTP_X_FORWARDED_FOR"], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)){
			$ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}

		$result = IP2LocationCountryBlocker::get_location($ipAddress);

		// Backend
		if((preg_match('/\/wp-login.php/i', $_SERVER['REQUEST_URI']) || is_admin())){
			$banlist = get_option('icb_backend_banlist');

			if(is_array($banlist) && in_array($result['countryCode'], $banlist)){
				if(get_option('icb_backend_option') == 1) IP2LocationCountryBlocker::page_403();
				IP2LocationCountryBlocker::page_301(get_option('icb_backend_target'));
			}
		}
		else{
			$banlist = get_option('icb_frontend_banlist');

			if(is_array($banlist) && in_array($result['countryCode'], $banlist)){
				if(get_option('icb_frontend_option') == 1) IP2LocationCountryBlocker::page_403();
				IP2LocationCountryBlocker::page_301(get_option('icb_frontend_target'));
			}
		}
	}

	function page_301($url){
		header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');
		header('HTTP/1.1 301 Moved Permanently');
		header('Location: ' . $url);
		die;
	}

	function page_403(){
		header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');
		header('HTTP/1.1 403 Forbidden');

		die('<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<title>Error 404 Not Found</title>
<style>
<!--
	body {font-family: arial,sans-serif}
	img { border:none; }
//-->
</style>
</head>
<body>
	<h2>Error 403 Access Denied</h2>
	<p>
		You don\'t have permission to access pages on this server.
	</p>
</body>
</html>');
	}

	function admin_page(){
		add_management_page('IP2Location Country Blocker', 'IP2Location Country Blocker', 8, 'ip2location-country-blocker', array(&$this, 'admin_options'));
	}

	function start(){
		// Make this plugin as first priority
		$wp_path_to_this_file = preg_replace('/(.*)plugins\/(.*)$/', WP_PLUGIN_DIR . "/$2", __FILE__);
		$this_plugin = plugin_basename(trim($wp_path_to_this_file));
		$active_plugins = get_option('active_plugins');
		$this_plugin_key = array_search($this_plugin, $active_plugins);

		if($this_plugin_key){
			array_splice($active_plugins, $this_plugin_key, 1);
			array_unshift($active_plugins, $this_plugin);
			update_option('active_plugins', $active_plugins);
		}

		add_action('admin_menu', array(&$this, 'admin_page'));
	}

	function set_defaults(){
		// Initial default settings
		update_option('icb_frontend_enabled', 1);
		update_option('icb_backend_enabled', 1);
		update_option('icb_frontend_banlist', '');
		update_option('icb_backend_banlist', '');
		update_option('icb_frontend_option', 1);
		update_option('icb_backend_option', 1);
		update_option('icb_frontend_target', '');
		update_option('icb_backend_target', '');
	}

	function uninstall(){
		// Remove all settings
		delete_option('icb_frontend_enabled');
		delete_option('icb_backend_enabled');
		delete_option('icb_frontend_banlist');
		delete_option('icb_backend_banlist');
		delete_option('icb_frontend_option');
		delete_option('icb_backend_option');
		delete_option('icb_frontend_target');
		delete_option('icb_backend_target');
	}

	function get_location($ip){
		// Make sure IP2Location database is exist
		if(!file_exists(IP2LOCATION_DB . 'database.bin')) return false;

		require_once(_ROOT . 'ip2location.class.php');

		// Create IP2Location object
		$geo = new IP2Location(IP2LOCATION_DB . 'database.bin');

		// Get geolocation by IP address
		$result = $geo->lookup($ip);

		return array('countryCode'=>$result->countryCode, 'countryName'=>IP2LocationCountryBlocker::set_case($result->countryName));
	}

	function list_countries(){
		return array(
			'AF'=>'Afghanistan',
			'AL'=>'Albania',
			'DZ'=>'Algeria',
			'AS'=>'American Samoa',
			'AD'=>'Andorra',
			'AO'=>'Angola',
			'AI'=>'Anguilla',
			'AQ'=>'Antarctica',
			'AG'=>'Antigua and Barbuda',
			'AR'=>'Argentina',
			'AM'=>'Armenia',
			'AW'=>'Aruba',
			'AU'=>'Australia',
			'AT'=>'Austria',
			'AZ'=>'Azerbaijan',
			'BS'=>'Bahamas',
			'BH'=>'Bahrain',
			'BD'=>'Bangladesh',
			'BB'=>'Barbados',
			'BY'=>'Belarus',
			'BE'=>'Belgium',
			'BZ'=>'Belize',
			'BJ'=>'Benin',
			'BM'=>'Bermuda',
			'BT'=>'Bhutan',
			'BO'=>'Bolivia',
			'BA'=>'Bosnia and Herzegovina',
			'BW'=>'Botswana',
			'BV'=>'Bouvet Island',
			'BR'=>'Brazil',
			'IO'=>'British Indian Ocean Territory',
			'BN'=>'Brunei Darussalam',
			'BG'=>'Bulgaria',
			'BF'=>'Burkina Faso',
			'BI'=>'Burundi',
			'KH'=>'Cambodia',
			'CM'=>'Cameroon',
			'CA'=>'Canada',
			'CV'=>'Cape Verde',
			'KY'=>'Cayman Islands',
			'CF'=>'Central African Republic',
			'TD'=>'Chad',
			'CL'=>'Chile',
			'CN'=>'China',
			'CX'=>'Christmas Island',
			'CC'=>'Cocos (Keeling) Islands',
			'CO'=>'Colombia',
			'KM'=>'Comoros',
			'CG'=>'Congo',
			'CK'=>'Cook Islands',
			'CR'=>'Costa Rica',
			'CI'=>'Cote D\'Ivoire',
			'HR'=>'Croatia',
			'CU'=>'Cuba',
			'CY'=>'Cyprus',
			'CZ'=>'Czech Republic',
			'CD'=>'Democratic Republic of Congo',
			'DK'=>'Denmark',
			'DJ'=>'Djibouti',
			'DM'=>'Dominica',
			'DO'=>'Dominican Republic',
			'TP'=>'East Timor',
			'EC'=>'Ecuador',
			'EG'=>'Egypt',
			'SV'=>'El Salvador',
			'GQ'=>'Equatorial Guinea',
			'ER'=>'Eritrea',
			'EE'=>'Estonia',
			'ET'=>'Ethiopia',
			'FK'=>'Falkland Islands (Malvinas)',
			'FO'=>'Faroe Islands',
			'FJ'=>'Fiji',
			'FI'=>'Finland',
			'FR'=>'France',
			'FX'=>'France, Metropolitan',
			'GF'=>'French Guiana',
			'PF'=>'French Polynesia',
			'TF'=>'French Southern Territories',
			'GA'=>'Gabon',
			'GM'=>'Gambia',
			'GE'=>'Georgia',
			'DE'=>'Germany',
			'GH'=>'Ghana',
			'GI'=>'Gibraltar',
			'GR'=>'Greece',
			'GL'=>'Greenland',
			'GD'=>'Grenada',
			'GP'=>'Guadeloupe',
			'GU'=>'Guam',
			'GT'=>'Guatemala',
			'GN'=>'Guinea',
			'GW'=>'Guinea-bissau',
			'GY'=>'Guyana',
			'HT'=>'Haiti',
			'HM'=>'Heard and Mc Donald Islands',
			'HN'=>'Honduras',
			'HK'=>'Hong Kong',
			'HU'=>'Hungary',
			'IS'=>'Iceland',
			'IN'=>'India',
			'ID'=>'Indonesia',
			'IR'=>'Iran (Islamic Republic of)',
			'IQ'=>'Iraq',
			'IE'=>'Ireland',
			'IL'=>'Israel',
			'IT'=>'Italy',
			'JM'=>'Jamaica',
			'JP'=>'Japan',
			'JO'=>'Jordan',
			'KZ'=>'Kazakhstan',
			'KE'=>'Kenya',
			'KI'=>'Kiribati',
			'KR'=>'Korea, Republic of',
			'KW'=>'Kuwait',
			'KG'=>'Kyrgyzstan',
			'LA'=>'Lao People\'s Democratic Republic',
			'LV'=>'Latvia',
			'LB'=>'Lebanon',
			'LS'=>'Lesotho',
			'LR'=>'Liberia',
			'LY'=>'Libyan Arab Jamahiriya',
			'LI'=>'Liechtenstein',
			'LT'=>'Lithuania',
			'LU'=>'Luxembourg',
			'MO'=>'Macau',
			'MK'=>'Macedonia',
			'MG'=>'Madagascar',
			'MW'=>'Malawi',
			'MY'=>'Malaysia',
			'MV'=>'Maldives',
			'ML'=>'Mali',
			'MT'=>'Malta',
			'MH'=>'Marshall Islands',
			'MQ'=>'Martinique',
			'MR'=>'Mauritania',
			'MU'=>'Mauritius',
			'YT'=>'Mayotte',
			'MX'=>'Mexico',
			'FM'=>'Micronesia, Federated States of',
			'MD'=>'Moldova, Republic of',
			'MC'=>'Monaco',
			'MN'=>'Mongolia',
			'MS'=>'Montserrat',
			'MA'=>'Morocco',
			'MZ'=>'Mozambique',
			'MM'=>'Myanmar',
			'NA'=>'Namibia',
			'NR'=>'Nauru',
			'NP'=>'Nepal',
			'NL'=>'Netherlands',
			'AN'=>'Netherlands Antilles',
			'NC'=>'New Caledonia',
			'NZ'=>'New Zealand',
			'NI'=>'Nicaragua',
			'NE'=>'Niger',
			'NG'=>'Nigeria',
			'NU'=>'Niue',
			'NF'=>'Norfolk Island',
			'KP'=>'North Korea',
			'MP'=>'Northern Mariana Islands',
			'NO'=>'Norway',
			'OM'=>'Oman',
			'PK'=>'Pakistan',
			'PW'=>'Palau',
			'PA'=>'Panama',
			'PG'=>'Papua New Guinea',
			'PY'=>'Paraguay',
			'PE'=>'Peru',
			'PH'=>'Philippines',
			'PN'=>'Pitcairn',
			'PL'=>'Poland',
			'PT'=>'Portugal',
			'PR'=>'Puerto Rico',
			'QA'=>'Qatar',
			'RE'=>'Reunion',
			'RO'=>'Romania',
			'RU'=>'Russian Federation',
			'RW'=>'Rwanda',
			'KN'=>'Saint Kitts and Nevis',
			'LC'=>'Saint Lucia',
			'VC'=>'Saint Vincent and the Grenadines',
			'WS'=>'Samoa',
			'SM'=>'San Marino',
			'ST'=>'Sao Tome and Principe',
			'SA'=>'Saudi Arabia',
			'SN'=>'Senegal',
			'SC'=>'Seychelles',
			'SL'=>'Sierra Leone',
			'SG'=>'Singapore',
			'SK'=>'Slovak Republic',
			'SI'=>'Slovenia',
			'SB'=>'Solomon Islands',
			'SO'=>'Somalia',
			'ZA'=>'South Africa',
			'GS'=>'South Georgia &amp=> South Sandwich Islands',
			'ES'=>'Spain',
			'LK'=>'Sri Lanka',
			'SH'=>'St. Helena',
			'PM'=>'St. Pierre and Miquelon',
			'SD'=>'Sudan',
			'SR'=>'Suriname',
			'SJ'=>'Svalbard and Jan Mayen Islands',
			'SZ'=>'Swaziland',
			'SE'=>'Sweden',
			'CH'=>'Switzerland',
			'SY'=>'Syrian Arab Republic',
			'TW'=>'Taiwan',
			'TJ'=>'Tajikistan',
			'TZ'=>'Tanzania, United Republic of',
			'TH'=>'Thailand',
			'TG'=>'Togo',
			'TK'=>'Tokelau',
			'TO'=>'Tonga',
			'TT'=>'Trinidad and Tobago',
			'TN'=>'Tunisia',
			'TR'=>'Turkey',
			'TM'=>'Turkmenistan',
			'TC'=>'Turks and Caicos Islands',
			'TV'=>'Tuvalu',
			'UG'=>'Uganda',
			'UA'=>'Ukraine',
			'AE'=>'United Arab Emirates',
			'GB'=>'United Kingdom',
			'US'=>'United States',
			'UM'=>'United States Minor Outlying Islands',
			'UY'=>'Uruguay',
			'UZ'=>'Uzbekistan',
			'VU'=>'Vanuatu',
			'VA'=>'Vatican City State (Holy See)',
			'VE'=>'Venezuela',
			'VN'=>'Viet Nam',
			'VG'=>'Virgin Islands (British)',
			'VI'=>'Virgin Islands (U.S.)',
			'WF'=>'Wallis and Futuna Islands',
			'EH'=>'Western Sahara',
			'YE'=>'Yemen',
			'YU'=>'Yugoslavia',
			'ZM'=>'Zambia',
			'ZW'=>'Zimbabwe'
		);
	}

	function set_case($s){
		$s = ucwords(strtolower($s));
		$s = preg_replace_callback("/( [ a-zA-Z]{1}')([a-zA-Z0-9]{1})/s",create_function('$matches','return $matches[1].strtoupper($matches[2]);'),$s);
		return $s;
	}
}

// Initial class
$ip2loction_country_blocker = new IP2LocationCountryBlocker();
$ip2loction_country_blocker->start();

register_activation_hook(__FILE__, array('IP2LocationCountryBlocker', 'set_defaults'));
register_uninstall_hook(__FILE__, array('IP2LocationCountryBlocker', 'uninstall'));

if((preg_match('/\/wp-login.php/i', $_SERVER['REQUEST_URI']) || is_admin()) && get_option('icb_backend_enabled')){
    add_action('login_head', array('IP2LocationCountryBlocker', 'check'), 1);
}
if(get_option('icb_frontend_enabled')){
    add_action('wp_head', array('IP2LocationCountryBlocker', 'check'), 1);
}
?>