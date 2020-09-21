<?php
	require_once('api.class.php');

	const API_URL = 'API_URL';

	const API_KEY = 'API_KEY';
	
    $email = $_POST['email'];
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$ssource = "Yes";
		$fsubscribe_val = $_POST['fsubscribe'];;

		$url = API_URL;
		$api_key = API_KEY;

		if($fsubscribe_val == 1){
			$fsubscribe = 'Yes';
		}else{
			$fsubscribe = 'No';
		}

		// Create API wrapper object
		$api = new Api($url, $api_key, '3.3');

		//main list
		$list_id = 12345;

		$search_criteria = array(
			array('Email', 'exactly', $email),
		);

		$response = array();

		$contacts = $api->invokeMethod('countContacts', $list_id, $search_criteria);

		$contact_details = array(
			'Email'         => $email,
			'First Name'	=> $fname,
			'Last Name'	=> $lname,
			'Website Account' => $ssource,
			'Subscribed' => $fsubscribe,
		);

		$consent_type = 'gdpr';
		$consent_text = 'By submitting this form I consent to receiving marketing content.';

		//check the person participated in competition or not
		if ($contacts['result'] == 0){
			// if contact not exist and choose to subscribe
			if ($fsubscribe_val == 1){
				$contact_id = $api->invokeMethod('subscribeContact', $list_id, $contact_details, $consent_type, $consent_text,);
			}			
			$response['exist'] = 0;
			$response['contacts'] = $contacts['error'];
			$response['fsubscribe_val'] = $fsubscribe_val;
		}else{
			$contact_id_no = $contacts['result'][0]['id'];
			$edit_contacts = array();
			$edit_contacts[] = array(
				'id' => $contact_id_no,
				'First Name'	=> $fname,
				'Last Name'	=> $lname,
				'Website Account' => $ssource,
			);

			$edited_contacts = $api->invokeMethod('editContacts', $list_id, $edit_contacts);

			$response['exist'] = 1;
			$response['contacts'] = $contacts['result'][0]['id'];
			$response['fsubscribe_val'] = $fsubscribe_val;
		}

		echo json_encode($response);

?>