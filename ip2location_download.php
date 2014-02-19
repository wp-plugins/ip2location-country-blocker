<?php
	try{
		$product_code = $_POST['product_code'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$db_path = $_POST['db_path'];
		
		set_time_limit(1200);
		$fp = fopen ("database.zip", 'w+');//This is the file where we save the    information
		$ch = curl_init("http://www.ip2location.com/download?productcode=" . strtoupper($product_code) . "&login=" . rawurlencode($username) . "&password=" . rawurlencode($password));
		curl_setopt($ch, CURLOPT_TIMEOUT, 50);
		curl_setopt($ch, CURLOPT_FILE, $fp); // write curl response to file
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_exec($ch); // get curl response
		curl_close($ch);
		fclose($fp);
		
		//unzip the file
		$zip = zip_open("database.zip");
		
		//Make sure it is a ZIP resource
		if (is_resource($zip)) {
			$found = false;
			while($zip_entry = zip_read($zip)){
				//Extract the BIN file only
				$zip_name = zip_entry_name($zip_entry);
				$pos = strpos(strtoupper($zip_name), '.BIN');
				if ($pos !== false){
					$file_size = zip_entry_filesize($zip_entry);
					$whandle = fopen("database.bin", 'w+');
					fwrite($whandle, zip_entry_read($zip_entry, $file_size));
					fclose($whandle);
					
					//success
					$found = true;
				}
			}
			
			//Only report true upon success unzip
			if ($found)
				echo "SUCCESS";
			else
				echo "ERROR";
		}
		else
			echo "ERROR";
				
		
	}catch (Exception $e){
		echo 'ERROR' . $e.getMessage();
	}
?>