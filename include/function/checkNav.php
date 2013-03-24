<?php
function checkNav()
{
	$user_agent = getenv("HTTP_USER_AGENT");

	if ((strpos($user_agent, "Nav") !== FALSE) || (strpos($user_agent, "Gold") !== FALSE) ||
	(strpos($user_agent, "X11") !== FALSE) || (strpos($user_agent, "Mozilla") !== FALSE) ||
	(strpos($user_agent, "Netscape") !== FALSE)
	AND (!strpos($user_agent, "MSIE") !== FALSE) 
	AND (!strpos($user_agent, "Konqueror") !== FALSE)
	AND (!strpos($user_agent, "Firefox") !== FALSE)
	AND (!strpos($user_agent, "Safari") !== FALSE))
			$browser = "Netscape";
	elseif (strpos($user_agent, "Opera") !== FALSE)
			$browser = "Opera";
	elseif (strpos($user_agent, "MSIE 8") !== FALSE)
			$browser = "MSIE 8";
	elseif (strpos($user_agent, "MSIE") !== FALSE)
			$browser = "MSIE";
	elseif (strpos($user_agent, "Lynx") !== FALSE)
			$browser = "Lynx";
	elseif (strpos($user_agent, "WebTV") !== FALSE)
			$browser = "WebTV";
	elseif (strpos($user_agent, "Konqueror") !== FALSE)
			$browser = "Konqueror";
	elseif (strpos($user_agent, "Safari") !== FALSE)
			$browser = "Safari";
	elseif (strpos($user_agent, "Firefox") !== FALSE)
			$browser = "Firefox";
	elseif ((stripos($user_agent, "bot") !== FALSE) || (strpos($user_agent, "Google") !== FALSE) ||
	(strpos($user_agent, "Slurp") !== FALSE) || (strpos($user_agent, "Scooter") !== FALSE) ||
	(stripos($user_agent, "Spider") !== FALSE) || (stripos($user_agent, "Infoseek") !== FALSE))
			$browser = "Bot";
	else
			$browser = "Autre";
	
	return $browser;
}
?>