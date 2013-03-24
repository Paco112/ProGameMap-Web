<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/class/sbox.php");
$_SESSION['sbox_ajax'] = 1;

sbox_function::check_ajax(true);

  $RECALL = $_POST["RECALL"];
  $ID = $_POST["ID"];
  $NDD = $_POST["NDD"];
  
  if( trim($RECALL) == "" ){
      echo 0;
	  exit();
  }
  
  if( trim($NDD) == "" ){
      echo 2;
	  exit();
  }
  // $RECALL contient le code d'accès
  $RECALL = urlencode( $RECALL );

  // $AUTH doit contenir l'identifiant de VOTRE document

  if($ID == '1') $AUTH = urlencode( "202663/795935/3071419" ); // Plan starter
  if($ID == '2') $AUTH = urlencode( "202663/796076/3071419" ); // Plan basic
  if($ID == '3') $AUTH = urlencode( "202663/796081/3071419" ); // Plan medium
  if($ID == '4') $AUTH = urlencode( "202663/796110/3071419" ); // Plan premium

  /**
   * envoi de la requête vers le serveur AlloPAss
   * dans la variable $r[0] on aura la réponse du serveur
   * dans la variable $r[1] on aura le code du pays d'appel de l'internaute
   * (FR,BE,UK,DE,CH,CA,LU,IT,ES,AT,...)
   * Dans le cas du multicode, on aura également $r[2],$r[3] etc...
   * contenant à chaque fois le résultat et le code pays.
   */
  $r = @file( "http://payment.allopass.com/api/checkcode.apu?code=$RECALL&auth=$AUTH" );

  // on teste la réponse du serveur

  if( substr( $r[0],0,2 ) != "OK" ) {
      echo 0;
  } else {
	  if($ID == '1'){
		 /*** add user ***/
		 $UserInfos   = array();
		 $UserInfos[] = array(
			'uid' 				=> $_SESSION['user']['uid'],
			'pid' 				=> '1',
			'prix' 				=> '1',
			'dernier_paiement' 	=> time(),
			'date_achat' 		=> date("d.m.y"));
	
		 $insert_user = $sbox->insert(array('table'=>'site_hosting','set'=>$UserInfos));
	  	 echo 1;
	  } elseif($ID == '2'){
	  	 echo 1;
	  } elseif($ID == '3'){
	  	 echo 1;
	  } elseif($ID == '4'){
	  	 echo 1;
	  }
  }

?>
