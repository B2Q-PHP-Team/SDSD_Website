<?php
	if( isset($_GET['paypal']) ){
		global $lms_paypal;

		$debug_text  = 'time: ' . date('l jS \of F Y h:i:s A') . '<br><br>';
		$debug_text .= 'post: ';
		
		ob_start();
		print_r($_POST);
		$debug_text .= ob_get_contents() . '<br><br>';
		ob_end_clean();

		// STEP 1: read POST data
		$raw_post_data = file_get_contents('php://input');
		$raw_post_array = explode('&', $raw_post_data);
		$myPost = array();
		foreach ($raw_post_array as $keyval) {
		  $keyval = explode ('=', $keyval);
		  if (count($keyval) == 2)
			 $myPost[$keyval[0]] = urldecode($keyval[1]);
		}
		
		$debug_text .= 'mypost: ';
		
		ob_start();
		print_r($myPost);
		$debug_text .= ob_get_contents() . '<br><br>';
		ob_end_clean();
		
		// read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
		$req = 'cmd=_notify-validate';
		if(function_exists('get_magic_quotes_gpc')) {
		   $get_magic_quotes_exists = true;
		} 
		foreach ($myPost as $key => $value) {        
		   if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) { 
				$value = urlencode(stripslashes($value)); 
		   } else {
				$value = urlencode($value);
		   }
		   $req .= "&$key=$value";
		}
		 
		 
		// Step 2: POST IPN data back to PayPal to validate
		$ch = curl_init($lms_paypal['url']);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

		if( !($res = curl_exec($ch)) ) {	
			$debug_text .= 'error: ' . curl_error($ch) . '<br><br>';
			update_option('paypal_debug', $debug_text);
			
			curl_close($ch);
			exit;
		}
		curl_close($ch);
		
		$debug_text .= 'response: ' . $res . '<br><br>';
		update_option('paypal_debug', $debug_text);
		
		// inspect IPN validation result and act accordingly
		if( strcmp ($res, "VERIFIED") == 0 ) {
			global $wpdb;
			$wpdb->update( $wpdb->prefix . 'gdlrpayment', 
				array('payment_status'=>'paid', 'attachment'=>serialize($_POST), 'payment_date'=>date('Y-m-d H:i:s')), 
				array('id'=>$_POST['invoice']), 
				array('%s', '%s', '%s'), 
				array('%d')
			);			
			
			$temp_sql  = "SELECT payment_info FROM " . $wpdb->prefix . "gdlrpayment ";
			$temp_sql .= "WHERE id = " . $_POST['invoice'];	
			$result = $wpdb->get_row($temp_sql);
			
			$payment_info = unserialize($result->payment_info);

			gdlr_lms_mail($payment_info['email'], 
				__('Paypal Payment Received', 'gdlr-lms'), 
				__('Your verification code is', 'gdlr-lms') . ' ' . $payment_info['code']);
		}
	}else if( isset($_GET['paypal_print']) ){
		print_r(get_option('gdlr_paypal', array()));
		die();
	}else if( isset($_GET['paypal_debug']) ){
		print_r(get_option('paypal_debug', 'nothing'));
		die();
	}else if( isset($_GET['paypal_clear']) ){
		delete_option('gdlr_paypal');
		echo 'Option Deleted';
		die();
	}

?>