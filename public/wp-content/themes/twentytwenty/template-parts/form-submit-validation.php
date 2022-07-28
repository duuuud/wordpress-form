
<?php 

 if(isset($_POST['submitted'])) {
	if(trim($_POST['fName']) === '') {
		$fNameError = 'Please enter your first name.';
		$hasError = true;
	} else {
		$fName = trim($_POST['fName']);
	}

	if(trim($_POST['lName']) === '') {
		$lNameError = 'Please enter your last name.';
		$hasError = true;
	} else {
		$lName = trim($_POST['lName']);
	}
	
	if(trim($_POST['phoneNumber']) === '') {
		$phoneNumberError = 'Please enter your phone number.';
		$hasError = true;
	} else {
		$phoneNumber = trim($_POST['phoneNumber']);
	}

	if(trim($_POST['email']) === '')  {
		$emailError = 'Please enter your email address.';
		$hasError = true;
	} else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['email']))) {
		$emailError = 'You entered an invalid email address.';
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}

	if(trim($_POST['chooseCountry']) === '-1') {
		$chooseCountryError = 'Please select country.';
		$hasError = true;
	} else {
		$chooseCountry = trim($_POST['chooseCountry']);
	}
	
	if(trim($_POST['birthDate']) === '') {
		$birthDateError = 'Please enter your birth date.';
		$hasError = true;
	} else {
		$birthDate = trim($_POST['birthDate']);
	}

	if(!trim($_POST['agree'])) {
		$agreeError = 'Please agree terms.';
		$hasError = true;
	} else {
		$agree_terms = intval(trim($_POST['agree']));
	}
	
	if(!isset($hasError)) {
		$emailTo = get_option('tz_email');
		if (!isset($emailTo) || ($emailTo == '') ){
			$emailTo = get_option('admin_email');
		}
		
		$emailTo = get_option('admin_email');
		$subject = '[PHP Snippets] From '.$fName;
		$body = "Name: $fName . $lName \n\nEmail: $email";
		$headers = 'From: '.$fName . $lName.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
		

		wp_mail($emailTo, $subject, $body, $headers);
		$emailSent = true;

		global $wpdb;
		
		$tableName = $wpdb->prefix . 'submit_application';

		insert_submit_application_table_into_db($tableName);

		$saveData = array(
			'fName' => $fName,
			'lName' => $lName,
			'email' => $email,
			'phoneNumber' => $phoneNumber,
			'chooseCountry' => $chooseCountry,
			'birthDate' => $birthDate,
			'agree_terms' => $agree_terms,
		);
		$format = array( '%s', '%s', '%s', '%s', '%s', '%d' );
		$success=$wpdb->insert( $tableName, $saveData, $format );
	}

	$has_fName = isset($_POST['fName']);
	$has_lName = isset($_POST['lName']);
	$has_phoneNumber = isset($_POST['phoneNumber']);
	$has_email = isset($_POST['email']);
	$has_chooseCountry = isset($_POST['chooseCountry']) && $_POST['chooseCountry'] !== -1;
	$has_birthDate = isset($_POST['birthDate']);
	$agree_terms = isset($_POST['agree_terms']);
}


function insert_submit_application_table_into_db($tableName){
  global $wpdb;

  // set the default character set and collation for the table
  $charset_collate = $wpdb->get_charset_collate();

  // Check that the table does not already exist before continuing
  $sql = "CREATE TABLE IF NOT EXISTS $tableName (
  id bigint(50) NOT NULL AUTO_INCREMENT,
  fName varchar(30) NOT NULL,
  lName varchar(30),
  phoneNumber varchar(15),
  email varchar(30) NOT NULL,
	chooseCountry varchar(20),
	birthDate varchar(10),
	agree_terms TINYINT(1),
	UNIQUE KEY id (id)
  ) $charset_collate;";

  require_once ABSPATH . 'wp-admin/includes/upgrade.php';
  dbDelta( $sql );
  $is_error = empty( $wpdb->last_error );
  return $is_error;
}
