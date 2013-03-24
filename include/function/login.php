<?php
include_once($_SERVER['DOCUMENT_ROOT']."/include/class/sbox.php");
function login($name=0,$pass=0,$quickmode=0)
{
	global $sbox;
		
	if( $_SESSION['user']['username'] == "")
	{
	
		if($name == "")
		{
			// on essaye de recuperer via le cookies
			if($_COOKIE['ProGameMap'] != "" && $_SESSION['logout'] != true)
			{
				$tab_cookie = explode("_",$_COOKIE['ProGameMap']);
				if($tab_cookie[0] != "" && $tab_cookie[1] != "")
				{
					$name = $tab_cookie[0];
					$pass_cookie = $tab_cookie[1];
				}
				else
				{
					return 'LoginFalse';
				}
			}
			else
			{
				$_SESSION['logout'] = true;
				return 'LoginFalse';
			}
		}
		
		$SelectUser = $sbox->select_multi(array('table'=>'site_users','select'=>'*','where'=>'username=/'.$name.'/'));
		
		if( $SelectUser == false )
		{
			return 'LoginFalse';
		} 
		else 
		{
			foreach($SelectUser as $user)
			{
				$uid = $user['uid'];
				$SelectPass = $user['passw'];
				$dname = $user['displayname'];
				$email = $user['email'];
				$name = $user['username'];
				$groupPrincipal = $user['primaryGroupID'];
				$groupSecondaire = $user['otherGroupsID'];
				$permissionsID = $user['permissionsID'];
				$changeDName = $user['changeDName'];
				$teamID = $user['teamID'];
				$teamRank = $user['teamRank'];
			}
			
			if($pass_cookie == "")
			{
				include_once($_SERVER['DOCUMENT_ROOT'].'/include/function/codePassw.php');
				$pass = codePassw($name, $pass);
				if ( $pass != $SelectPass)
				{
					return 'LoginFalse';
				}
			}
			elseif($pass_cookie != sha1($name.$SelectPass))
			{
				return 'LoginFalse';
			}
					
			$UserInfos = array();
			$UserInfos[]['last_connection_time'] = date("Y-m-j H:i:s");
			$UserInfos[]['last_connection_ip'] = $_SERVER['REMOTE_ADDR'];
			
			$insert_user = $sbox->update(array('table'=>'site_users','set'=>$UserInfos,'where'=>'uid=/'.$uid.'/'));
			
			$_SESSION['user']['uid'] = $uid;
			$_SESSION['user']['username'] = $name;
			$_SESSION['user']['password'] = $SelectPass;
			$_SESSION['user']['dname'] = $dname;
			$_SESSION['user']['email'] = $email;
			$_SESSION['user']['permissions'] = $permissionsID;
			$_SESSION['user']['changeDName'] = $changeDName;
			$_SESSION['user']['group']['principal'] = $groupPrincipal;
			$_SESSION['user']['group']['secondaires'] = $groupSecondaire;
			
			$_SESSION['user']['teamID'] = $teamID;
			$_SESSION['user']['teamRank'] = $teamRank;
			
			return 'LoginOk';
		}
	}
}
?>