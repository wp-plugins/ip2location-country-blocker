<?php
/**
 * Plugin Name: IP2Location Country Blocker
 * Plugin URI: http://ip2location.com/tutorials/wordpress-ip2location-country-blocker
 * Description: Block visitors from accessing your website or admin area by their country.
 * Version: 2.3.6
 * Author: IP2Location
 * Author URI: http://www.ip2location.com
 */

defined( 'DS' ) or define( 'DS', DIRECTORY_SEPARATOR );
define( 'IP2LOCATION_COUNTRY_BLOCKER_ROOT', dirname( __FILE__ ) . DS );

class IP2LocationCountryBlocker {
	private $countries = array( 'AF' => 'Afghanistan','AL' => 'Albania','DZ' => 'Algeria','AS' => 'American Samoa','AD' => 'Andorra','AO' => 'Angola','AI' => 'Anguilla','AQ' => 'Antarctica','AG' => 'Antigua and Barbuda','AR' => 'Argentina','AM' => 'Armenia','AW' => 'Aruba','AU' => 'Australia','AT' => 'Austria','AZ' => 'Azerbaijan','BS' => 'Bahamas','BH' => 'Bahrain','BD' => 'Bangladesh','BB' => 'Barbados','BY' => 'Belarus','BE' => 'Belgium','BZ' => 'Belize','BJ' => 'Benin','BM' => 'Bermuda','BT' => 'Bhutan','BO' => 'Bolivia','BA' => 'Bosnia and Herzegovina','BW' => 'Botswana','BV' => 'Bouvet Island','BR' => 'Brazil','IO' => 'British Indian Ocean Territory','BN' => 'Brunei Darussalam','BG' => 'Bulgaria','BF' => 'Burkina Faso','BI' => 'Burundi','KH' => 'Cambodia','CM' => 'Cameroon','CA' => 'Canada','CV' => 'Cape Verde','KY' => 'Cayman Islands','CF' => 'Central African Republic','TD' => 'Chad','CL' => 'Chile','CN' => 'China','CX' => 'Christmas Island','CC' => 'Cocos (Keeling) Islands','CO' => 'Colombia','KM' => 'Comoros','CG' => 'Congo','CK' => 'Cook Islands','CR' => 'Costa Rica','CI' => 'Cote D\'Ivoire','HR' => 'Croatia','CU' => 'Cuba','CY' => 'Cyprus','CZ' => 'Czech Republic','CD' => 'Democratic Republic of Congo','DK' => 'Denmark','DJ' => 'Djibouti','DM' => 'Dominica','DO' => 'Dominican Republic','TP' => 'East Timor','EC' => 'Ecuador','EG' => 'Egypt','SV' => 'El Salvador','GQ' => 'Equatorial Guinea','ER' => 'Eritrea','EE' => 'Estonia','ET' => 'Ethiopia','FK' => 'Falkland Islands (Malvinas)','FO' => 'Faroe Islands','FJ' => 'Fiji','FI' => 'Finland','FR' => 'France','FX' => 'France, Metropolitan','GF' => 'French Guiana','PF' => 'French Polynesia','TF' => 'French Southern Territories','GA' => 'Gabon','GM' => 'Gambia','GE' => 'Georgia','DE' => 'Germany','GH' => 'Ghana','GI' => 'Gibraltar','GR' => 'Greece','GL' => 'Greenland','GD' => 'Grenada','GP' => 'Guadeloupe','GU' => 'Guam','GT' => 'Guatemala','GN' => 'Guinea','GW' => 'Guinea-bissau','GY' => 'Guyana','HT' => 'Haiti','HM' => 'Heard and Mc Donald Islands','HN' => 'Honduras','HK' => 'Hong Kong','HU' => 'Hungary','IS' => 'Iceland','IN' => 'India','ID' => 'Indonesia','IR' => 'Iran (Islamic Republic of)','IQ' => 'Iraq','IE' => 'Ireland','IL' => 'Israel','IT' => 'Italy','JM' => 'Jamaica','JP' => 'Japan','JO' => 'Jordan','KZ' => 'Kazakhstan','KE' => 'Kenya','KI' => 'Kiribati','KR' => 'Korea, Republic of','KW' => 'Kuwait','KG' => 'Kyrgyzstan','LA' => 'Lao People\'s Democratic Republic','LV' => 'Latvia','LB' => 'Lebanon','LS' => 'Lesotho','LR' => 'Liberia','LY' => 'Libyan Arab Jamahiriya','LI' => 'Liechtenstein','LT' => 'Lithuania','LU' => 'Luxembourg','MO' => 'Macau','MK' => 'Macedonia','MG' => 'Madagascar','MW' => 'Malawi','MY' => 'Malaysia','MV' => 'Maldives','ML' => 'Mali','MT' => 'Malta','MH' => 'Marshall Islands','MQ' => 'Martinique','MR' => 'Mauritania','MU' => 'Mauritius','YT' => 'Mayotte','MX' => 'Mexico','FM' => 'Micronesia, Federated States of','MD' => 'Moldova, Republic of','MC' => 'Monaco','MN' => 'Mongolia','MS' => 'Montserrat','MA' => 'Morocco','MZ' => 'Mozambique','MM' => 'Myanmar','NA' => 'Namibia','NR' => 'Nauru','NP' => 'Nepal','NL' => 'Netherlands','AN' => 'Netherlands Antilles','NC' => 'New Caledonia','NZ' => 'New Zealand','NI' => 'Nicaragua','NE' => 'Niger','NG' => 'Nigeria','NU' => 'Niue','NF' => 'Norfolk Island','KP' => 'North Korea','MP' => 'Northern Mariana Islands','NO' => 'Norway','OM' => 'Oman','PK' => 'Pakistan','PW' => 'Palau','PA' => 'Panama','PG' => 'Papua New Guinea','PY' => 'Paraguay','PE' => 'Peru','PH' => 'Philippines','PN' => 'Pitcairn','PL' => 'Poland','PT' => 'Portugal','PR' => 'Puerto Rico','QA' => 'Qatar','RE' => 'Reunion','RO' => 'Romania','RU' => 'Russian Federation','RW' => 'Rwanda','KN' => 'Saint Kitts and Nevis','LC' => 'Saint Lucia','VC' => 'Saint Vincent and the Grenadines','WS' => 'Samoa','SM' => 'San Marino','ST' => 'Sao Tome and Principe','SA' => 'Saudi Arabia','SN' => 'Senegal','SC' => 'Seychelles','SL' => 'Sierra Leone','SG' => 'Singapore','SK' => 'Slovak Republic','SI' => 'Slovenia','SB' => 'Solomon Islands','SO' => 'Somalia','ZA' => 'South Africa','GS' => 'South Georgia And The South Sandwich Islands','ES' => 'Spain','LK' => 'Sri Lanka','SH' => 'St. Helena','PM' => 'St. Pierre and Miquelon','SD' => 'Sudan','SR' => 'Suriname','SJ' => 'Svalbard and Jan Mayen Islands','SZ' => 'Swaziland','SE' => 'Sweden','CH' => 'Switzerland','SY' => 'Syrian Arab Republic','TW' => 'Taiwan','TJ' => 'Tajikistan','TZ' => 'Tanzania, United Republic of','TH' => 'Thailand','TG' => 'Togo','TK' => 'Tokelau','TO' => 'Tonga','TT' => 'Trinidad and Tobago','TN' => 'Tunisia','TR' => 'Turkey','TM' => 'Turkmenistan','TC' => 'Turks and Caicos Islands','TV' => 'Tuvalu','UG' => 'Uganda','UA' => 'Ukraine','AE' => 'United Arab Emirates','GB' => 'United Kingdom','US' => 'United States','UM' => 'United States Minor Outlying Islands','UY' => 'Uruguay','UZ' => 'Uzbekistan','VU' => 'Vanuatu','VA' => 'Vatican City State (Holy See)','VE' => 'Venezuela','VN' => 'Viet Nam','VG' => 'Virgin Islands (British)','VI' => 'Virgin Islands (U.S.)','WF' => 'Wallis and Futuna Islands','EH' => 'Western Sahara','YE' => 'Yemen','YU' => 'Yugoslavia','ZM' => 'Zambia','ZW' => 'Zimbabwe' );

	function admin_options() {
		if( !is_admin() ) {
			return;
		}

		add_action('wp_enqueue_script', 'load_jquery');

		// Find any .BIN files in current directory
		$files = scandir( IP2LOCATION_COUNTRY_BLOCKER_ROOT );

		foreach( $files as $file ){
			if ( strtoupper( substr( $file, -4 ) ) == '.BIN' ){
				update_option( 'ip2location_country_blocker_database', $file );
				break;
			}
		}

		$q = ( isset( $_GET['q'] ) ) ? $_GET['q'] : '';

		if ( $q == 'statistics' ) {
			global $wpdb;

			// Remove logs older than 30 days
			$wpdb->query( 'DELETE FROM ' . $wpdb->prefix . 'ip2location_country_blocker_log WHERE date_created <="' . date( 'Y-m-d H:i:s', strtotime( '-30 days' ) ) . '"' );

			// Prepare logs for last 30 days
			$results = $wpdb->get_results( 'SELECT DATE_FORMAT(date_created, "%Y-%m-%d") AS date, side, COUNT(*) AS total FROM ' . $wpdb->prefix . 'ip2location_country_blocker_log GROUP BY date,side ORDER BY date', OBJECT );

			$lines = array();
			for( $d=30; $d>0; $d-- ) {
				$lines[date( 'Y-m-d', strtotime( '-' . $d . ' days' ) )][1] = 0;
				$lines[date( 'Y-m-d', strtotime( '-' . $d . ' days' ) )][2] = 0;
			}

			foreach( $results as $result ) {
				$lines[$result->date][$result->side] = $result->total;
			}

			ksort( $lines );

			$rows1 = '';
			foreach( $lines as $line=>$value ) {
				$rows1 .= '[\'' . $line . '\', ' . ( ( $value[1]) ? $value[1] : 0 ) . ', ' . ( ( $value[2] ) ? $value[2] : 0 ) . '],';
			}

			// Prepare blocked countries
			$results = $wpdb->get_results( 'SELECT country_code,COUNT(*) AS total FROM ' . $wpdb->prefix . 'ip2location_country_blocker_log GROUP BY country_code ORDER BY total DESC;', OBJECT );
			$rows2 = '';
			foreach($results as $result){
				$rows2 .= '[\'' . addslashes( $this->countries[$result->country_code] ) . '\', ' . $result->total . '],';
			}

			echo '
			<script type="text/javascript" src="https://www.google.com/jsapi"></script>
			<script type="text/javascript">
			  google.load("visualization", "1", {packages:["corechart"]});
			  google.setOnLoadCallback(drawChart);
			  function drawChart() {
				var data1 = google.visualization.arrayToDataTable([
				  [\'Date\', \'Frontend\', \'Backend\'],
				  ' . rtrim( $rows1, ',' ) . '
				]);

				var data2 = google.visualization.arrayToDataTable([
				  [\'Country\', \'Traffic Blocked\'],
				  ' . rtrim( $rows2, ',' ) . '
				]);


				var chart1 = new google.visualization.LineChart(document.getElementById("chart_div"));
				chart1.draw(data1, { title: "Blocked Page By Day" });

				var chart2 = new google.visualization.PieChart(document.getElementById("piechart"));
				chart2.draw(data2, { title: "Blocked Countries" });

			  }
			</script>

			<div class="wrap">
				<h2>IP2Location Country Blocker</h2>

				<h2 class="nav-tab-wrapper">
					<a href="' . admin_url( 'options-general.php?page=ip2location-country-blocker' ) . '" class="nav-tab">General</a>
					<a href="#" class="nav-tab nav-tab-active">Statistic</a>
				</h2>

				<h3>Logs for Last 30 Days</h3>
				<div id="chart_div" style="width: 900px; height: 400px;"></div>
				<div id="piechart" style="width: 900px; height: 400px;"></div>
			</div>';
		}
		else {
			$mode_status = '';
			$frontend_status = '';
			$backend_status = '';

			$lookup_mode = ( isset( $_POST['lookupMode'] ) ) ? $_POST['lookupMode'] : get_option( 'ip2location_country_blocker_lookup_mode' );
			$api_key = ( isset( $_POST['apiKey'] ) ) ? $_POST['apiKey'] : get_option( 'ip2location_country_blocker_api_key' );

			$enable_frontend = ( isset( $_POST['saveFrontend'] ) && isset( $_POST['frontendEnabled'] ) ) ? 1 : ( ( ( isset( $_POST['saveFrontend'] ) && !isset( $_POST['frontendEnabled'] ) ) )? 0 : get_option( 'ip2location_country_blocker_frontend_enabled' ) );
			$enable_backend = ( isset( $_POST['saveBackend'] ) && isset( $_POST['backendEnabled'] ) ) ? 1 : ( ( ( isset( $_POST['saveBackend'] ) && !isset( $_POST['backendEnabled'] ) ) ) ? 0 : get_option( 'ip2location_country_blocker_backend_enabled' ) );
			$frontend_banlist = ( isset( $_POST['frontendBanlist'] ) ) ? $_POST['frontendBanlist'] : get_option( 'ip2location_country_blocker_frontend_banlist' );
			$frontend_banlist = ( !is_array( $frontend_banlist ) ) ? array( $frontend_banlist ) : $frontend_banlist;
			$backend_banlist = ( isset( $_POST['backendBanlist'] ) ) ? $_POST['backendBanlist'] : get_option( 'ip2location_country_blocker_backend_banlist' );
			$backend_banlist = ( !is_array($backend_banlist ) ) ? array( $backend_banlist ) : $backend_banlist;
			$frontend_option = ( isset( $_POST['frontendOption'] ) ) ? $_POST['frontendOption'] : get_option( 'ip2location_country_blocker_frontend_option' );
			$backend_option = ( isset( $_POST['backendOption'] ) ) ? $_POST['backendOption'] : get_option( 'ip2location_country_blocker_backend_option' );
			$frontend_target = ( isset( $_POST['frontendTarget'] ) ) ? $_POST['frontendTarget'] : get_option( 'ip2location_country_blocker_frontend_target' );
			$backend_target = ( isset( $_POST['backendTarget'] ) ) ? $_POST['backendTarget'] : get_option( 'ip2location_country_blocker_backend_target' );
			$frontend_redirected_url = ( isset( $_POST['frontendRedirectedUrl'] ) ) ? $_POST['frontendRedirectedUrl'] : get_option( 'ip2location_country_blocker_frontend_reditected_url' );
			$backend_redirected_url = ( isset( $_POST['backendRedirectedUrl'] ) ) ? $_POST['backendRedirectedUrl'] : get_option( 'ip2location_country_blocker_backend_reditected_url' );
			$email_notification = ( isset( $_POST['email_notification'] ) ) ? $_POST['email_notification'] : get_option( 'ip2location_country_blocker_email_notification' );
			$bypass_code = ( isset( $_POST['bypassCode'] ) ) ? $_POST['bypassCode'] : get_option( 'ip2location_country_blocker_bypass_code' );

			$my_country_code = '??';

			if( $response = $this->get_location( $_SERVER['REMOTE_ADDR'] ) ){
				$my_country_code = $response['countryCode'];
			}

			if( isset( $_POST['lookupMode'] ) ) {
				update_option( 'ip2location_country_blocker_lookup_mode', $lookup_mode );
				update_option( 'ip2location_country_blocker_api_key', $api_key );

				$mode_status .= '
				<div id="message" class="updated">
					<p>Changes saved.</p>
				</div>';
			}

			if ( isset( $_POST['saveFrontend'] ) ) {
				if ( !empty( $frontend_target ) && !filter_var( $frontend_target, FILTER_VALIDATE_URL ) ) {
					$frontend_status = '
					<div id="message" class="error">
						<p><strong>ERROR</strong>: Invalid URL provided.</p>
					</div>';
				}
				else if ( $frontend_option == 2 && empty( $frontend_target ) ) {
					$frontend_status = '
					<div id="message" class="error">
						<p><strong>ERROR</strong>: Please provide a valid URL for redirection.</p>
					</div>';
				}
				else {
					update_option( 'ip2location_country_blocker_frontend_enabled', $enable_frontend );
					update_option( 'ip2location_country_blocker_frontend_banlist', $frontend_banlist );
					update_option( 'ip2location_country_blocker_frontend_option', $frontend_option );
					update_option( 'ip2location_country_blocker_frontend_target', $frontend_target );
					update_option( 'ip2location_country_blocker_frontend_reditected_url', $frontend_redirected_url );

					$frontend_status = '
					<div id="message" class="updated">
						<p>Changes saved.</p>
					</div>';
				}
			}

			if(isset($_POST['saveBackend'])) {
				if ( !empty( $backend_target ) && !filter_var( $backend_target, FILTER_VALIDATE_URL ) ) {
					$backend_status = '
					<div id="message" class="error">
						<p><strong>ERROR</strong>: Invalid URL provided.</p>
					</div>';
				}
				else if ( $backend_option == 2 && empty( $backend_target ) ) {
					$backend_status = '
					<div id="message" class="error">
						<p><strong>ERROR</strong>: Please provide a valid URL for redirection.</p>
					</div>';
				}
				else {
					update_option( 'ip2location_country_blocker_backend_enabled', $enable_backend );
					update_option( 'ip2location_country_blocker_backend_banlist', $backend_banlist );
					update_option( 'ip2location_country_blocker_backend_option', $backend_option );
					update_option( 'ip2location_country_blocker_backend_target', $backend_target );
					update_option( 'ip2location_country_blocker_backend_reditected_url', $backend_redirected_url );
					update_option( 'ip2location_country_blocker_email_notification', $email_notification );
					update_option( 'ip2location_country_blocker_bypass_code', $bypass_code );

					$backend_status = '
					<div id="message" class="updated">
						<p>Changes saved.</p>
					</div>';
				}
			}

			echo '
			<script>
				(function( $ ) {
					$(function(){
						$("#download").on("click", function(e){
							e.preventDefault();

							if ($("#productCode").val() == "" || $("#username").val() == "" || $("#password").val() == ""){
								return;
							}

							$("#download").attr("disabled", "disabled");
							$("#download-status").html(\'<div style="padding:10px; border:1px solid #ccc; background-color:#ffa;">Downloading \' + $("#productCode").val() + \' BIN database in progress... Please wait...</div>\');

							$.post(ajaxurl, { action: "update_ip2location_country_blocker_database", productCode: $("#productCode").val(), username: $("#username").val(), password: $("#password").val() }, function(response) {
								if(response == "SUCCESS") {
									alert("Downloading completed.");

									$("#download-status").html(\'<div id="message" class="updated"><p>Successfully downloaded the \' + $("#productCode").val() + \' BIN database. Please refresh information by <a href="javascript:;" id="reload">reloading</a> the page.</p></div>\');

									$("#reload").on("click", function(){
										window.location = window.location.href.split("#")[0];
									});
								}
								else {
									alert("Downloading failed.");

									$("#download-status").html(\'<div id="message" class="error"><p><strong>ERROR</strong>: Failed to download \' + $("#productCode").val() + \' BIN database. Please make sure you correctly enter the product code and login crendential. Please also take note to download the BIN product code only.</p></div>\');
								}
							}).always(function() {
								$("#productCode").val("DB1LITEBIN");
								$("#username").val("");
								$("#password").val("");
								$("#download").removeAttr("disabled");
							});
						});

						$("#form-redirection").on("submit", function(e){
							$(\'select[name="from[]"]\').each(function(){
								if($(this).val() == ""){
									alert("Please select Post/Page for redirection.");

									e.preventDefault();
								}
							});
						});

						$("#use-bin").on("click", function(){
							$("#bin-mode").show();
							$("#ws-mode").hide();

							$("html, body").animate({
								scrollTop: $("#use-bin").offset().top - 50
							}, 100);
						});

						$("#use-ws").on("click", function(){
							$("#bin-mode").hide();
							$("#ws-mode").show();

							$("html, body").animate({
								scrollTop: $("#use-ws").offset().top - 50
							}, 100);
						});

						$("#' . ( ( $lookup_mode == 'bin' ) ? 'bin-mode' : 'ws-mode' ) . '").show();

						$("#frontendTarget").on("focus", function(){
							$("#frontendOption-2").attr("checked", "checked");
						});

						$("#backendTarget").on("focus", function(){
							$("#backendOption-2").attr("checked", "checked");
						});

						$("#saveBackendSettings").on("click", function(e){
							$("#backendBanList :selected").each(function(i, selected){
								if($(selected).val() == "' . $my_country_code . '"){
									if(!confirm("== WARNING ==\nYou are about to block your own country.\nThis can prevent you from login if you do not set a bypass code.")){
										e.preventDefault();
									}
								}
							});
						});
					});
				})( jQuery );
			</script>

			<div class="wrap">
				<h2>IP2Location Country Blocker</h2>

				<h2 class="nav-tab-wrapper">
					<a href="#" class="nav-tab nav-tab-active">General</a>
					<a href="' . admin_url( 'options-general.php?page=ip2location-country-blocker&q=statistics' ) . '" class="nav-tab">Statistic</a>
				</h2>

				<p>
					IP2Location Country Blocker allows user to easily block visitors from accessing your frontend (the blog pages) or backend (the admin area) based on their country.
				</p>

				<p>&nbsp;</p>

				<div style="border-bottom:1px solid #ccc;">
					<h3 id="lookup-mode">Lookup Mode</h3>
				</div>

				' . $mode_status . '

				<form action="#lookup-mode" id="form-lookup-mode" method="post">
					<p>
						<label><input id="use-bin" type="radio" name="lookupMode" value="bin"' . ( ( $lookup_mode == 'bin' ) ? ' checked' : '' ) . '> Local BIN database</label>

						<div id="bin-mode" style="margin-left:50px;display:none;background:#d7d7d7;padding:20px">
							<p>
								BIN file download: <a href="http://www.ip2location.com/?r=wordpress" target="_blank">IP2Location Commercial database</a> | <a href="http://lite.ip2location.com/?r=wordpress" targe="_blank">IP2Location LITE database (free edition)</a>.
							</p>';

			if ( !file_exists( IP2LOCATION_COUNTRY_BLOCKER_ROOT . get_option( 'ip2location_country_blocker_database' ) ) ) {
				echo '
							<div id="message" class="error">
								<p>
									Unable to find the IP2Location BIN database! Please download the database at at <a href="http://www.ip2location.com/?r=wordpress" target="_blank">IP2Location commercial database</a> | <a href="http://lite.ip2location.com/?r=wordpress" target="_blank">IP2Location LITE database (free edition)</a>.
								</p>
							</div>';
			}
			else {
				echo '
							<p>
								<b>Current Database Version: </b>
								' . date( 'F Y', filemtime( IP2LOCATION_COUNTRY_BLOCKER_ROOT . get_option( 'ip2location_country_blocker_database' ) ) ) . '
							</p>';

				if ( filemtime( IP2LOCATION_COUNTRY_BLOCKER_ROOT . get_option( 'ip2location_country_blocker_database' ) ) < strtotime( '-2 months' ) ) {
					echo '
							<div style="background:#fff;padding:2px 10px;border-left:3px solid #cc0000">
								<p>
									<strong>REMINDER</strong>: Your IP2Location database was outdated. Please download the latest version for accurate result.
								</p>
							</div>';
				}
			}

			echo '
							<p>&nbsp;</p>

							<div style="border-bottom:1px solid #ccc;">
								<h4>Download BIN Database</h4>
							</div>

							<div id="download-status" style="margin:10px 0;"></div>

							<strong>Product Code</strong>:
							<select id="productCode" type="text" value="" style="margin-right:10px;" >
								<option value="DB1LITEBIN">DB1LITEBIN</option>
								<option value="DB1BIN">DB1BIN</option>
								<option value="DB1LITEBINIPV6">DB1LITEBINIPV6</option>
								<option value="DB1BINIPV6">DB1BINIPV6</option>
							</select>

							<strong>Email</strong>:
							<input id="username" type="text" value="" style="margin-right:10px;" />

							<strong>Password</strong>:
							<input id="password" type="password" value="" style="margin-right:10px;" />

							<button id="download" class="button action">Download</button>

							<span style="display:block; font-size:0.8em">Enter the product code, i.e, DB1LITEBIN, (the code in square bracket on your license page) and login credential for the download.</span>

							<div style="margin-top:20px;">
								<strong>Note</strong>: If you failed to download the BIN database using this automated downloading tool, please follow the below procedures to manually update the database.
								<ol style="list-style-type:circle;margin-left:30px">
									<li>Download the BIN database at <a href="http://www.ip2location.com/?r=wordpress" target="_blank">IP2Location commercial database</a> | <a href="http://lite.ip2location.com/?r=wordpress" target="_blank">IP2Location LITE database (free edition)</a>.</li>
									<li>Decompress the zip file and update the BIN database to ' . dirname( __FILE__ ) . '.</li>
									<li>Once completed, please refresh the information by reloading the setting page.</li>
								</ol>
							</div>
							<p>&nbsp;</p>
						</div>
					</p>
					<p>
						<label><input id="use-ws" type="radio" name="lookupMode" value="ws"' . ( ( $lookup_mode == 'ws' ) ? ' checked' : '' ) . '> IP2Location Web Service</label>

						<div id="ws-mode" style="margin-left:50px;display:none;background:#d7d7d7;padding:20px">
							<p>Please insert your IP2Location <a href="http://www.ip2location.com/web-service" target="_blank">Web service</a> API key.</p>
							<p>
								<strong>API Key</strong>:
								<input name="apiKey" type="text" value="' . $api_key . '" style="margin-right:10px;" />
							</p>
						</div>
					</p>
					<p class="submit">
						<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"  />
					</p>
				</form>

				<p>&nbsp;</p>

				<div style="border-bottom:1px solid #ccc;">
					<h3 id="ip-lookup">Query IP</h3>
				</div>
				<p>
					Enter a valid IP address for checking.
				</p>';

			$ipAddress = ( isset( $_POST['ipAddress'] ) ) ? $_POST['ipAddress'] : '';

			if ( isset( $_POST['lookup'] ) ) {
				if ( !filter_var($ipAddress, FILTER_VALIDATE_IP ) ) {
					echo '
					<div id="message" class="error">
						<p><strong>ERROR</strong>: Invalid IP address.</p>
					</div>';
				}
				else {
					$response = $this->get_location( $ipAddress );

					if ( $response['countryName'] ) {
						if ( $response['countryCode'] != '??' && strlen( $response['countryCode'] ) == 2 ) {
							echo '
							<div id="message" class="updated">
								<p>IP address <strong>' . $ipAddress . '</strong> belongs to <strong>' . $response['countryName'] . '</strong>.</p>
							</div>';
						}
						else{
							echo '
							<div id="message" class="error">
								<p><strong>ERROR</strong>: ' . $response['countryName'] . '</p>
							</div>';
						}

						$banlist = get_option( 'ip2location_country_blocker_frontend_banlist' );

						if ( get_option( 'ip2location_country_blocker_frontend_enabled' ) && is_array( $banlist ) && $this->is_in_array( $response['countryCode'], $banlist ) ) {
							echo '
							<div id="message" class="updated">
								<p>Visitors from this country are being blocked from accessing your frontend website.</p>
							</div>';
						}

						$banlist = get_option( 'ip2location_country_blocker_backend_banlist' );

						if ( get_option( 'ip2location_country_blocker_backend_enabled' ) && is_array( $banlist ) && $this->is_in_array( $response['countryCode'], $banlist ) ) {
							echo '
							<div id="message" class="updated">
								<p>Visitors from this country are being blocked from accessing your backend website (admin area).</p>
							</div>';
						}
					}
					else{
						echo '
						<div id="message" class="error">
							<p><strong>ERROR</strong>: This record is not supported with this databaase.</p>
						</div>';
					}
				}
			}

			echo '
				<form action="#ip-lookup" method="post">
					<p>
						<label><b>IP Address: </b></label>
						<input type="text" name="ipAddress" value="' . $ipAddress . '" />
						<input type="submit" name="lookup" value="Lookup" class="button action" />
					</p>
				</form>

				<p>&nbsp;</p>

				<div style="border-bottom:1px solid #ccc;">
					<h3 id="frontend-block-list">Frontend Block List</h3>
				</div>
				' . $frontend_status . '
				<form action="#frontend-block-list" method="post">
					<p>
						<input type="checkbox" name="frontendEnabled" id="frontendEnabled"' . (($enable_frontend) ? ' checked' : '') . '>
						<label for="frontendEnabled"> Enable Frontend Blocking</label>
					</p>
					<p>
						Select countries that you wish to block the access from frontend (blog pages). Press "CTRL" for multiple selection.
					</p>
					<p>
						<select name="frontendBanlist[]" multiple="true" style="width:500px;height:200px">';

			foreach( $this->countries as $countryCode=>$countryName ){
				echo '
					<option value="' . $countryCode . '"' . ( ( $this->is_in_array( $countryCode, $frontend_banlist ) ) ? ' selected' : '' ) . '> ' . $countryName . '</option>';
			}

			echo '
						</select>
					</p>
					<p style="font-weight:bold;">
						Show the following page when visitor is blocked.
					</p>
					<div style="margin-left:30px;">
						<p>
							<label>
								<input type="radio" name="frontendOption" value="1"' . ( ( $frontend_option == 1 ) ? ' checked' : '' ) . '>
								Error 403: Access Denied

								<div style="margin-left:25px">
									403 Error Page:
									<select name="frontendRedirectedUrl">
										<option value="default">default</option>';

			$pages = get_pages( array( 'post_status' => 'publish,private' ) );

			foreach ( $pages as $page ) {
				echo '
				<option value="' . $page->guid . '"' . (($frontend_redirected_url == $page->guid) ? ' selected' : '') . '>' . $page->post_title . '</option>';
			}

			echo '
									</select>
								</div>
							</label>
						</p>

						<label><input type="radio" name="frontendOption" id="frontendOption-2" value="2"' . ( ( $frontend_option == 2 ) ? ' checked' : '' ) . '>URL:</label>
						<input type="text" name="frontendTarget" id="frontendTarget" value="' . $frontend_target . '" size="80" />
					</div>
					<p>
						<input type="submit" name="saveFrontend" id="submit" class="button button-primary" value="Save Frontend Settings"  />
					</p>
				</form>

				<p>&nbsp;</p>

				<div style="border-bottom:1px solid #ccc;">
					<h3 id="backend-block-list">Backend (Admin Area) Block List</h3>
				</div>
				' . $backend_status . '
				<form action="#backend-block-list" method="post">
					<p>
						<input type="checkbox" name="backendEnabled" id="backendEnabled"' . ( ( $enable_backend ) ? ' checked' : '' ) . '>
						<label for="backendEnabled"> Enable Backend Blocking</label>
					</p>
					<p>
						Select countries that you wish to block the access from backend (admin area). Press "CTRL" for multiple selection.
					</p>
					<p>
						<select name="backendBanlist[]" id="backendBanList" multiple="true" style="width:500px;height:200px">';

			foreach( $this->countries as $countryCode=>$countryName ) {
				echo '
					<option value="' . $countryCode . '"' . ( ( $this->is_in_array( $countryCode, $backend_banlist ) ) ? ' selected' : '' ) . '> ' . $countryName . '</option>';
			}

			echo '
						</select>
					</p>
					<p style="font-weight:bold;">
						Show the following page when visitor is blocked.
					</p>
					<div style="margin-left:30px;">
						<p>
							<label>
								<input type="radio" name="backendOption" value="1"' . ( ( $backend_option == 1 ) ? ' checked' : '' ) . '>
								Error 403: Access Denied

								<div style="margin-left:25px">
									403 Error Page:
									<select name="backendRedirectedUrl">
										<option value="default">default</option>';

			$pages = get_pages( array( 'post_status' => 'publish,private' ) );

			foreach ( $pages as $page ) {
				echo '
				<option value="' . $page->guid . '"' . ( ( $backend_redirected_url == $page->guid ) ? ' selected' : '' ) . '>' . $page->post_title . '</option>';
			}

			echo '
									</select>
								</div>
							</label>
						</p>

						<label><input type="radio" name="backendOption" id="backendOption-2" value="2"' . ( ( $backend_option == 2 ) ? ' checked' : '' ) . '>URL:</label>
						<input type="text" name="backendTarget" id="backendTarget" value="' . $backend_target . '" size="80" />
					</div>

					<p style="font-weight:bold;">
						Send email notification to:
						<select name="email_notification">
							<option value="none">none</option>';

			$users = get_users( 'search=*' );

			foreach ( $users as $user ) {
				echo '
					<option value="' . $user->user_email . '"' . ( ( $user->user_email == $email_notification ) ? ' selected' : '' ) . '>' . $user->display_name . '</option>';
			}


			echo '
						</select>
					</p>

					<p style="font-weight:bold;">
						Secret code to bypass validation (max 20 chars): <input type="text" name="bypassCode" maxlength="20" value="' . $bypass_code . '" />
						<br />
						<span style="font-size:9px;">To bypass the validation, append the secret_code with value to wp-login.php page. For example, http://www.example.com/wp-login.php?secret_code=1234567</span>
					</p>
					<p>
						<input type="submit" name="saveBackend" id="saveBackendSettings" class="button button-primary" value="Save Backend Settings"  />
					</p>
				</form>
			</div>';
		}
	}

	function check_block() {
		global $wpdb;

		$this->start_session();

		if( isset( $_SESSION['ip2location_country_blocker_checked'] ) ) {
			unset( $_SESSION['ip2location_country_blocker_checked'] );
			return;
		}

		if( is_admin() )
			unset( $_SESSION['ip2location_country_blocker_secret_code'] );

		$frontend_redirected_url = get_option( 'ip2location_country_blocker_frontend_reditected_url' );

		if ( !$frontend_redirected_url ) {
			$frontend_redirected_url = 'default';
		}

		$backend_redirected_url = get_option( 'ip2location_country_blocker_backend_reditected_url' );

		if ( !$backend_redirected_url ) {
			$backend_redirected_url = 'default';
		}

		if ( $frontend_redirected_url == get_permalink() || $backend_redirected_url == get_permalink() ) {
			return;
		}

		$ipAddress = $_SERVER['REMOTE_ADDR'];

		if( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) && filter_var( $_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP ) ) {
			$ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}

		$result = $this->get_location( $ipAddress );

		// Backend
		if ( ( preg_match( '/wp-login\.php/', $_SERVER['SCRIPT_NAME'] ) ) ) {
			$secret_code = ( isset( $_GET['secret_code'] ) ) ? $_GET['secret_code'] : ( ( isset( $_SESSION['ip2location_country_blocker_secret_code'] ) ) ? $_SESSION['ip2location_country_blocker_secret_code'] : md5( microtime() ) );

			$_SESSION['ip2location_country_blocker_secret_code'] = $secret_code;

			$bypass_code = get_option( 'ip2location_country_blocker_bypass_code' );

			if ( $bypass_code != $secret_code ) {
				$banlist = get_option( 'ip2location_country_blocker_backend_banlist' );

				if ( get_option( 'ip2location_country_blocker_backend_enabled' ) && is_array($banlist) && $this->is_in_array( $result['countryCode'], $banlist ) ) {
					$_wp_session['ip2location_country_blocker_checked'] = true;

					$wpdb->query( 'INSERT INTO ' . $wpdb->prefix . 'ip2location_country_blocker_log (ip_address, country_code, side, page, date_created) VALUES ("' . $ipAddress . '", "' . $result['countryCode'] . '", 2, "' . basename(get_permalink()) . '", "' . date('Y-m-d H:i:s') . '")' );

					$email_notification_address = get_option('ip2location_country_blocker_email_notification');

					if ($email_notification_address != 'none') {
						$message = array();

						$message[] = 'Hi,';
						$message[] = 'IP2Location Country Blocker has successfully blocked an user from accessing your admin page. The user\'s details:';
						$message[] = '';
						$message[] = 'IP Address : ' . $ipAddress;
						$message[] = 'Country    : ' . $result['countryName'] . ' (' . $result['countryCode'] . ')';
						$message[] = '';
						$message[] = str_repeat( '-', 100 );
						$message[] = 'Get a free IP2Location LITE database at http://lite.ip2location.com.';
						$message[] = 'Get an accurate IP2Location commercial database at http://www.ip2location.com.';
						$message[] = str_repeat( '-', 100 );
						$message[] = '';
						$message[] = '';
						$message[] = 'Regards,';
						$message[] = 'IP2Location Country Blocker';
						$message[] = 'www.ip2location.com';

						wp_mail( $email_notification_address, 'IP2Location Country Blocker Alert', implode( "\n", $message ) );
					}

					if ( get_option('ip2location_country_blocker_backend_option') == 1 ) {
						$this->deny( $backend_redirected_url );
					}
					else {
						$this->redirect( get_option( 'ip2location_country_blocker_backend_target' ) );
					}
				}
			}
		}

		// Frontend
		else if ( ( !preg_match( '/\/wp-admin\//', $_SERVER['REQUEST_URI'] ) ) ) {
			$banlist = get_option( 'ip2location_country_blocker_frontend_banlist' );

			if( is_array( $banlist ) && $this->is_in_array( $result['countryCode'], $banlist ) ) {
				$_wp_session['ip2location_country_blocker_checked'] = true;

				$wpdb->query( 'INSERT INTO ' . $wpdb->prefix . 'ip2location_country_blocker_log (ip_address, country_code, side, page, date_created) VALUES ("' . $ipAddress . '", "' . $result['countryCode'] . '", 1, "' . basename(get_permalink()) . '", "' . date('Y-m-d H:i:s') . '")' );

				if( get_option( 'ip2location_country_blocker_frontend_option') == 1 ) {
					$this->deny( $frontend_redirected_url );
				}
				else {
					$this->redirect( get_option( 'ip2location_country_blocker_frontend_target' ) );
				}
			}
		}
	}

	function redirect( $url ) {
		header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
		header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
		header( 'Cache-Control: max-age=0, no-cache, no-store, must-revalidate' );
		header( 'Pragma: no-cache' );
		header( 'HTTP/1.1 301 Moved Permanently' );
		header( 'Location: ' . $url );
		die;
	}

	function deny( $url ) {
		if ($url == 'default' || $url == '') {
			die('
			<html>
			<head>
			<meta http-equiv="content-type" content="text/html;charset=utf-8">
			<title>Error 403 Access Denied</title>
			<style>
			<!--
				body {font-family: arial,sans-serif}
				img { border:none; }
			//-->
			</style>
			</head>
			<body>
				<div style="margin:10px; padding:10px; border:1px solid #f00; background-color:#fcc;">
					<h2>Error 403 Access Denied</h2>
					<div>You do not have permission to access the page on this server.</div>
				</div>
			</body>
			</html>');
		}
		else {
			$this->redirect( $url );
		}
	}

	function admin_page() {
		add_options_page( 'IP2Location Country Blocker', 'IP2Location Country Blocker', 8, 'ip2location-country-blocker', array( &$this, 'admin_options' ) );
	}

	function start_session() {
		if( !session_id() )
			session_start();
	}

	function init() {
		// Make sure this plugin loaded as first priority.
		$wp_path_to_this_file = preg_replace( '/(.*)plugins\/(.*)$/', WP_PLUGIN_DIR . "/$2", __FILE__ );
		$this_plugin = plugin_basename( trim( $wp_path_to_this_file ) );
		$active_plugins = get_option( 'active_plugins' );
		$this_plugin_key = array_search( $this_plugin, $active_plugins );

		if ($this_plugin_key) {
			array_splice( $active_plugins, $this_plugin_key, 1 );
			array_unshift( $active_plugins, $this_plugin );
			update_option( 'active_plugins', $active_plugins );
		}

		add_action( 'admin_menu', array( &$this, 'admin_page' ) );
	}

	function set_defaults() {
		global $wpdb;

		update_option( 'ip2location_country_blocker_lookup_mode', 'bin' );
		update_option( 'ip2location_country_blocker_api_key', '' );
		update_option( 'ip2location_country_blocker_frontend_enabled', 1 );
		update_option( 'ip2location_country_blocker_backend_enabled', 1 );
		update_option( 'ip2location_country_blocker_frontend_banlist', '' );
		update_option( 'ip2location_country_blocker_backend_banlist', '' );
		update_option( 'ip2location_country_blocker_frontend_option', 1 );
		update_option( 'ip2location_country_blocker_backend_option', 1 );
		update_option( 'ip2location_country_blocker_frontend_target', '' );
		update_option( 'ip2location_country_blocker_backend_target', '' );
		update_option( 'ip2location_country_blocker_frontend_reditected_url', 'default' );
		update_option( 'ip2location_country_blocker_backend_reditected_url', 'default' );
		update_option( 'ip2location_country_blocker_email_notification', 'none' );
		update_option( 'ip2location_country_blocker_bypass_code', '' );

		$wpdb->query( 'CREATE TABLE IF NOT EXISTS ' . $wpdb->prefix . 'ip2location_country_blocker_log (
			`log_id` INT(11) NOT NULL AUTO_INCREMENT,
			`ip_address` VARCHAR(50) NOT NULL COLLATE \'utf8_bin\',
			`country_code` CHAR(2) NOT NULL COLLATE \'utf8_bin\',
			`side` CHAR(1) NOT NULL COLLATE \'utf8_bin\',
			`page` VARCHAR(100) NOT NULL COLLATE \'utf8_bin\',
			`date_created` DATETIME NOT NULL,
			PRIMARY KEY (`log_id`),
			INDEX `idx_country_code` (`country_code`),
			INDEX `idx_side` (`side`),
			INDEX `idx_date_created` (`date_created`)
		) COLLATE=\'utf8_bin\'' );

		// Find any .BIN files in current directory
		$files = scandir( IP2LOCATION_COUNTRY_BLOCKER_ROOT );

		foreach( $files as $file ){
			if ( strtoupper( substr( $file, -4 ) ) == '.BIN' ){
				update_option( 'ip2location_country_blocker_database', $file );
				break;
			}
		}
	}

	function uninstall() {
		global $wpdb;

		delete_option( 'ip2location_country_blocker_lookup_mode' );
		delete_option( 'ip2location_country_blocker_api_key' );
		delete_option( 'ip2location_country_blocker_database' );
		delete_option( 'ip2location_country_blocker_frontend_enabled' );
		delete_option( 'ip2location_country_blocker_backend_enabled' );
		delete_option( 'ip2location_country_blocker_frontend_banlist' );
		delete_option( 'ip2location_country_blocker_backend_banlist' );
		delete_option( 'ip2location_country_blocker_frontend_option' );
		delete_option( 'ip2location_country_blocker_backend_option' );
		delete_option( 'ip2location_country_blocker_frontend_target' );
		delete_option( 'ip2location_country_blocker_backend_target' );
		delete_option( 'ip2location_country_blocker_frontend_reditected_url' );
		delete_option( 'ip2location_country_blocker_backend_reditected_url' );
		delete_option( 'ip2location_country_blocker_email_notification' );
		delete_option( 'ip2location_country_blocker_bypass_code' );

		$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'ip2location_country_blocker_log' );
	}

	function is_in_array( $needle, $array ) {
		foreach( array_values( $array ) as $key ) {
			$return[$key] = 1;
		}

		return isset( $return[$needle] );
	}

	function get_location( $ip ) {
		switch( get_option( 'ip2location_country_blocker_lookup_mode' ) ) {
			case 'bin':
				// Make sure IP2Location database is exist.
				if ( !is_file( IP2LOCATION_COUNTRY_BLOCKER_ROOT . get_option( 'ip2location_country_blocker_database' ) ) ) {
					return false;
				}

				if ( ! class_exists( 'IP2Location\Database' ) ) {
					require_once( IP2LOCATION_COUNTRY_BLOCKER_ROOT . 'class.IP2Location.php' );
				}

				// Create IP2Location object.
				$db = new \IP2Location\Database( IP2LOCATION_COUNTRY_BLOCKER_ROOT . get_option( 'ip2location_country_blocker_database' ) );

				// Get geolocation by IP address.
				$response = $db->lookup( $ip );

				return array(
					'countryCode' => $response['countryCode'],
					'countryName' => $response['countryName'],
				);
			break;

			case 'ws':
				if ( !class_exists( 'WP_Http' ) ) {
					include_once( ABSPATH . WPINC . '/class-http.php' );
				}

				$request = new WP_Http();
				$response = $request->request( 'http://api.ip2location.com/?' . http_build_query( array(
					'key' => get_option( 'ip2location_country_blocker_api_key' ),
					'ip' => $ip,
				) ) , array( 'timeout' => 3 ) );

				return array(
					'countryCode' => $response['body'],
					'countryName' => $this->get_country_name( $response['body'] ),
				);
			break;
		}
	}

	function download() {
		try {
			$productCode = ( isset( $_POST['productCode'] ) ) ? $_POST['productCode'] : '';
			$username = ( isset( $_POST['username'] ) ) ? $_POST['username'] : '';
			$password = ( isset( $_POST['password'] ) ) ? $_POST['password']: '';

			if ( !class_exists( 'WP_Http' ) ) {
				include_once( ABSPATH . WPINC . '/class-http.php' );
			}

			// Remove existing database.zip.
			if ( file_exists( IP2LOCATION_COUNTRY_BLOCKER_ROOT . 'database.zip' ) ) {
				@unlink( IP2LOCATION_COUNTRY_BLOCKER_ROOT . 'database.zip' );
			}

			// Start downloading BIN database from IP2Location website.
			$request = new WP_Http();
			$response = $request->request( 'http://www.ip2location.com/download?' . http_build_query( array(
				'productcode' => $productCode,
				'login' => $username,
				'password' => $password,
			) ) , array( 'timeout' => 120 ) );

			if ( ( isset( $response->errors ) ) || ( !( in_array( '200', $response['response'] ) ) ) ) {
				die( 'Connection error.' );
			}

			// Save downloaded package into plugin directory.
			$fp = fopen( IP2LOCATION_COUNTRY_BLOCKER_ROOT . 'database.zip', 'w' );

			fwrite( $fp, $response['body'] );
			fclose( $fp );

			// Decompress the package.
			$zip = zip_open( IP2LOCATION_COUNTRY_BLOCKER_ROOT . 'database.zip' );

			if ( !is_resource( $zip ) ) {
				die('Downloaded file is corrupted.');
			}

			while( $entries = zip_read( $zip ) ) {
				// Extract the BIN file only.
				$file_name = zip_entry_name($entries);

				if ( substr( $file_name, -4 ) != '.BIN' ) {
					continue;
				}

				// Remove existing BIN files before extrac the latest BIN file.
				$files = scandir( IP2LOCATION_COUNTRY_BLOCKER_ROOT );

				foreach( $files as $file ){
					if ( strtoupper( substr( $file, -4 ) ) == '.BIN' ){
						@unlink( IP2LOCATION_COUNTRY_BLOCKER_ROOT . $file );
					}
				}

				$handle = fopen( IP2LOCATION_COUNTRY_BLOCKER_ROOT . $file_name, 'w+' );
				fwrite( $handle, zip_entry_read( $entries, zip_entry_filesize($entries) ) );
				fclose( $handle );

				if ( !file_exists( IP2LOCATION_COUNTRY_BLOCKER_ROOT . $file_name ) ) {
					die( 'ERROR' );
				}

				@unlink( IP2LOCATION_COUNTRY_BLOCKER_ROOT . 'database.zip' );

				die('SUCCESS');
			}
		}
		catch( Exception $e ) {
			die( 'ERROR' );
		}

		die( 'ERROR' );
	}

	function get_country_name( $code ) {
		return ( isset( $this->$countries[$code] ) ) ? $this->$countries[$code] : '';
	}
}

// Initial class
$ip2location_country_blocker = new IP2LocationCountryBlocker();
$ip2location_country_blocker->init();

register_activation_hook( __FILE__, array( $ip2location_country_blocker, 'set_defaults' ) );
register_uninstall_hook( __FILE__, array( $ip2location_country_blocker, 'uninstall' ) );

add_action( 'wp_ajax_update_ip2location_country_blocker_database', array( $ip2location_country_blocker, 'download' ) );
add_action( 'init', array( $ip2location_country_blocker, 'check_block' ) );
?>