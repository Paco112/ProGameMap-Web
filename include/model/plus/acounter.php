<?php
/**
 * ----------------------------------------------
 * Simple Animated Counter PHP 1.1
 * Copyright (c)2001 Chi Kien Uong
 * URL: http://www.proxy2.de
 * ----------------------------------------------
 */

class acounter {

    var $config = array();

    function acounter () {

        /* URL to the digitset */
        $this->config['img'] = "./acount/digits/";

        /* URL to the animated digitset */
        $this->config['animated_img'] = "./acount/digits_ani/";

        /* How many digits to show */
        $this->config['pad'] = 4;

        /* digit width and height */
        $this->config['width']  = 9;
        $this->config['height'] = 13;

        /* ip blocking (true/false) */
        $this->config['block_ip'] = true;

        /* path to ip logfiles */
        $this->config['logfile'] = "./acount/pages/ip.txt";

        /* timeout (minutes) */
        $this->config['block_time'] = 60;
    }

    function is_new_visitor() {
        $is_new = true;
        $rows = @file($this->config['logfile']);
        $this_time = time();
        $ip = getenv("REMOTE_ADDR");
        $reload_dat = fopen($this->config['logfile'],"wb");
        flock($reload_dat, 2);
        for ($i=0; $i<sizeof($rows); $i++) {
            list($time_stamp,$ip_addr) = split("\|",$rows[$i]);
            if ($this_time < ($time_stamp+$this->config['block_time'])) {
                if (chop($ip_addr) == $ip) {
                    $is_new = false;
                } else {
                    fwrite($reload_dat,"$time_stamp|$ip_addr");
                }
            }
        }
        fwrite($reload_dat,"$this_time|$ip\n");
        flock($reload_dat, 3);
        fclose($reload_dat);
        return $is_new;
    }

    function read_counter_file($page) {
        $update = false;
        if (!file_exists("./acount/pages/$page.txt")) {
            $count_dat = fopen("./acount/pages/$page.txt","w+");
            $this->counter = 1;
            fwrite($count_dat,$this->counter);
            fclose($count_dat);
        } else {
            $fp = fopen("./acount/pages/$page.txt", "r+");
            flock($fp, 2);
            $this->counter = fgets($fp, 4096);
            flock($fp, 3);
            fclose($fp);
            if ($this->config['block_ip']) {
                if ($this->is_new_visitor()) {
                    $this->counter++;
                    $update = true;
                }
            } else {
                $this->counter++;
                $update = true;
            }
            if ($update) {
                $fp = fopen("./acount/pages/$page.txt", "r+");
                flock($fp, 2);
                rewind($fp);
                fwrite($fp, $this->counter);
                flock($fp, 3);
                fclose($fp);
            }
        }
        return $this->counter;
    }

    function create_output($page='') {
        if (empty($page)) {
            $page = "counter";
        }
        $this->read_counter_file($page);
        $this->counter = sprintf("%0"."".$this->config['pad'].""."d",$this->counter);
        $ani_digits = sprintf("%0"."".$this->config['pad'].""."d",$this->counter+1);
        $html_output = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr align=\"center\">\n";
        for ($i=0; $i<strlen($this->counter); $i++) {
            if (substr("$this->counter",$i,1) == substr("$ani_digits",$i,1)) {
                $digit_pos = substr("$this->counter",$i,1);
                $html_output .= "<td><img src=\"".$this->config['img']."$digit_pos.gif\" alt=\"Visitors\"";
            } else {
                $digit_pos = substr("$ani_digits",$i,1);
                $html_output .= "<td><img src=\"".$this->config['animated_img']."$digit_pos.gif\" alt=\"Visitors\"";
            }
            $html_output .= " width=\"".$this->config['width']."\" height=\"".$this->config['height']."\"></td>\n";
        }
        $html_output .= "</tr></table>\n";
        return $html_output;
    }

}


// This script exports all the IPs that hit this chat server into a file called /logs/chat_ip_logs.txt
function getip() {
  if(isset($_SERVER)) {
    if(isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
    $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    }elseif(isset($_SERVER["HTTP_CLIENT_IP"])) {
      $realip = $_SERVER["HTTP_CLIENT_IP"];
    }else{
      $realip = $_SERVER["REMOTE_ADDR"];
    }
  }else{
  if(getenv( 'HTTP_X_FORWARDED_FOR' ) ) {
    $realip = getenv( 'HTTP_X_FORWARDED_FOR' );
  }elseif (getenv( 'HTTP_CLIENT_IP' ) ) {
    $realip = getenv( 'HTTP_CLIENT_IP' );
  }else {
    $realip = getenv( 'REMOTE_ADDR' );
  }
}
return $realip;
}

$logIP = getip();
if (!eregi("86.121.5", $logIP)) //Replace this IP (mine) with yours IP (entire - if it's a static IP or partial - if it's a dinamic one like mine)
{
	$proxy = $_SERVER['REMOTE_ADDR'];
	$loguri = $_SERVER['REQUEST_URI'];
	$logref = $_SERVER['HTTP_REFERER'];
	$logDATE = date("D, d-m-y, H:i:s");
	$logHOST = gethostbyaddr($logIP);
	$invoegen = $logDATE . " | " . $logIP . " | " . $logHOST . " | " . $proxy . " | " . $loguri . " - " . $logref . "\n";
if (!file_exists("./acount/pages/chat_ip_logs.txt"))
{
	copy("./acount/pages/bak/chat_ip_logs.txt","./acount/pages/chat_ip_logs.txt");
	chmod("./acount/pages/chat_ip_logs.txt", 0666);
}
	$fopen = fopen("./acount/pages/chat_ip_logs.txt", "a");
	fwrite($fopen, $invoegen);
	fclose($fopen);
}
?>