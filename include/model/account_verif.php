<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/class/sbox.php");
$_SESSION['sbox_ajax'] = 1;

sbox_function::check_ajax(false);

$input = $_POST['input'];
$name  = $_POST['name'];
$dname = $_POST['dname'];
$pass  = $_POST['pass'];
$pass2 = $_POST['pass2'];
$mail  = $_POST['mail'];
$mail2 = $_POST['mail2'];
$captcha = $_POST['captcha'];

if ( $input == 'reg-submit' ){
	$input = 'reg-name|reg-dname|reg-password|reg-password-check|reg-emailaddress|reg-emailaddress-two|reg-captcha';
	$onSubmit = 1;
}


if ( preg_match('/reg-name/', $input) ){
	if($name == ""){
		$return .= "NameEmpty|";
	} else {
		$SelectName = $sbox->select_multi(array('table'=>'site_users','select'=>'*','where'=>'username=/'.$name.'/'));

		if( $SelectName == false ){
			$return .= 'NameOK|';
		} else {
			$return .= 'NameTaken|';
		}	
	}
}
	
if ( preg_match('/reg-dname/', $input) ){
	if($dname == ""){
		$return .= "DName2Empty|";
	} else {
		
		/**$IllegalChars = array('[',']','|',',',';','$','"','<','>','\\');
		
		foreach($IllegalChars as $i){
			if ( preg_match($i, $dname) ){
				$return .= "DName2Illegal|";
			}
		} ***/
		
		$SelectDName = $sbox->select_multi(array('table'=>'site_users','select'=>'*','where'=>'displayname=/'.$dname.'/'));

		if( $SelectDName == false ){
			$return .= 'DName2OK|';
		} else {
			$return .= 'DName2Taken|';
		}
		
	}
}

if ( preg_match('/reg-password/', $input) || preg_match('/reg-password-check/', $input) ){
	if (($pass != "" && $pass2 == "") || ($pass == "" && $pass2 != "") || ($pass == "" && $pass2 == "")){
		$return .= 'PassEmpty|';
	} elseif ($pass != $pass2){
		$return .= 'PassNegal|';
	} else {
		$return .= 'PassOK|';
	}
}	

if ( preg_match('/reg-emailaddress/', $input) || preg_match('/reg-emailaddress-two/', $input) ){
	if (($mail != "" && $mail2 == "") || ($mail == "" && $mail2 != "") || ($mail == "" && $mail2 == "")){
		$return .= 'MailEmpty|';
	} elseif ($mail != $mail2){
		$return .= 'MailNegal|';
	} else {
		$SelectName = $sbox->select_multi(array('table'=>'site_users','select'=>'*','where'=>'email=/'.$mail.'/'));

		if( $SelectName == false ){
			$return .= 'MailOK|';
		} else {
			$return .= 'MailTaken|';
		}
	}
}

if ( preg_match('/reg-captcha/', $input) ){
	
	$cryptinstall=$_SERVER['DOCUMENT_ROOT']."/include/crypt/cryptographp.fct.php";
	include $cryptinstall;

	if (chk_crypt($captcha)) {
		$return .= 'CaptchaOK|';
	} else {
		$return .= 'CaptchaFalse|';
	}
}



if($onSubmit == 1 && $return == "NameOK|DName2OK|PassOK|MailOK|CaptchaOK|"){
	// Initialisations des variables.
	$date 		= date("Y-m-d H:i:s");
	$time 		= time();
	$ip 		= $_SERVER['REMOTE_ADDR'];
	//$newsletter = $_POST['allow_newsletter'];
			
	/*** include function ***/
	include_once('./../../include/function/codePassw.php');
	include_once('./../../include/function/forum.php');
	
	//link for activation email
	$activate_string = base64_encode(time());
	
	//valid email with link activation ?
	 if ($site_registration_mail == 0) $valid_email = 'Y';
	 else $valid_email ='N';  // player have to valid his email by clicking on link
	 
	 if ($newsletter == 1) $newsletter = 'Y';
	 else $newsletter = 'N';
	 
	 $LastID = $sbox->select_multi(array('table'=>'site_users','select'=>'uid','order by'=>'uid DESC LIMIT 1'));
	 foreach($LastID as $user) $UserID = $user['uid']+1;
	 
	 /*** add user ***/
	 $UserInfos   = array();
	 $UserInfos[] = array(
		'uid'				=> $UserID,
		'username' 			=> $name,
		'displayname' 		=> $dname,
		'passw' 			=> codePassw($name, $pass),
		'email' 			=> $mail,
		'registration_date' => $date,
		'registration_time' => $time,
		'registration_ip' 	=> $ip,
		'valid_email' 		=> $valid_email,
		'activation_string' => $activate_string);
	 	 
	 /*** add profil ***/
	 $ProfilInfos   = array();
	 $ProfilInfos[] = array(
		'uid' => $UserID);
	 	 
	 $ForumInfos   = array();
	 $ForumInfos[] = array(
		'user_id'			=> $UserID,
		'username'			=> $dname,
		'username_clean'	=> strtolower($dname),
		'user_password'		=> phpbb_hash($pass),
		'user_pass_convert'	=> 0,
		'user_email'		=> $mail,
		'user_email_hash'	=> 0,
		'group_id'			=> 2,
		'user_type'			=> 0,
		'user_permissions'	=> '',
		'user_timezone'		=> '0.00',
		'user_dateformat'	=> 'd F Y, H:i',
		'user_lang'			=> 'fr',
		'user_style'		=> 2,
		'user_actkey'		=> '',
		'user_ip'			=> '',
		'user_regdate'		=> time(),
		'user_passchg'		=> time(),
		'user_options'		=> 230271,
		// We do not set the new flag here - registration scripts need to specify it
		'user_new'			=> 0,

		'user_inactive_reason'	=> 0,
		'user_inactive_time'	=> 0,
		'user_lastmark'			=> time(),
		'user_lastvisit'		=> 0,
		'user_lastpost_time'	=> 0,
		'user_lastpage'			=> '',
		'user_posts'			=> 0,
		'user_dst'				=> 0,
		'user_colour'			=> '',
		'user_occ'				=> '',
		'user_interests'		=> '',
		'user_avatar'			=> '',
		'user_avatar_type'		=> 0,
		'user_avatar_width'		=> 0,
		'user_avatar_height'	=> 0,
		'user_new_privmsg'		=> 0,
		'user_unread_privmsg'	=> 0,
		'user_last_privmsg'		=> 0,
		'user_message_rules'	=> 0,
		'user_full_folder'		=> '-3',
		'user_emailtime'		=> 0,

		'user_notify'			=> 0,
		'user_notify_pm'		=> 1,
		'user_notify_type'		=> 0,
		'user_allow_pm'			=> 1,
		'user_allow_viewonline'	=> 1,
		'user_allow_viewemail'	=> 1,
		'user_allow_massemail'	=> 1,

		'user_sig'					=> '',
		'user_sig_bbcode_uid'		=> '',
		'user_sig_bbcode_bitfield'	=> '',

		//'user_form_salt'			=> unique_id(),
	);
	 
	 $ForumInfos2   = array();
	 $ForumInfos2[] = array(
		'group_id' => 2,
		'user_id' => $UserID,
		'user_pending' => 0
		);
	 
	 $insert_user   = $sbox->insert(array('table'=>'site_users','set'=>$UserInfos));
							
	if ($insert_user == FALSE){ 
		$return = $insert_user.';InsertFalse';
	} else {
		
		$insert_profil = $sbox->insert(array('table'=>'site_profil','set'=>$ProfilInfos));
		$insert_forum  = $sbox->insert(array('table'=>'phpbb_users','set'=>$ForumInfos));
		$insert_forum2 = $sbox->insert(array('table'=>'phpbb_user_group','set'=>$ForumInfos2));
		
		if($insert_profil == false || $insert_forum == false || $insert_forum2 == false)
		{
			$return = 'InsertFalse';
		}
		else
		{		
			include_once('./../../include/function/login.php');
			login($name, $pass);
			$return = 'InsertTrue';
		}
	}
}

echo $return;

?>