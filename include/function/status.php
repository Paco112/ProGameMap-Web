<?php
function checkos( )
{
    $fa = 0;
    $fb = 0;
    $fd = 0;
    if ( substr( PHP_OS, 0, 3 ) == "WIN" )
    {
        $osType['windows'] = 1;
    }
    if ( PHP_OS == "FreeBSD" )
    {
        $osType['freebsd'] = 1;
    }
    if ( PHP_OS == "Linux" )
    {
        $osType['linux'] = 1;
    }
    return $osType;
}

function cryptlic( $enct )
{
    $$idnt[0] = "dontcrackme";
    $$idnt[1] = "2007";
    $idnt2[0] = crc32( $enct );
    $idnt2[1] = crypt( $enct, $$idnt[0] );
    $idnt2[2] = md5( $enct );
    $idnt2 = implode( $$idnt[1], $idnt2 );
    return sha1( $enct.$idnt2 );
}

function multiservers( )
{
    global $prefix,$config,$LANG;
    $bolMult = false;
    if ( $config['multiservers'] == "true" )
    {
        if ( !( $qr = mysql_query( "SELECT host, name, services, phpinfo, statusurl, mstatusurl, sortnumb FROM ".$prefix."multiservers ORDER BY sortnumb" ) ) )
        {
            exit( "Query failed: ".mysql_error( ) );
        }
        while ( ( $fArrCm = mysql_fetch_assoc( $qr ) ) !== false )
        {
            if ( $fArrCm )
            {
                $htm = "\r\n<table align=\"center\" border=\"1\" cellpadding=\"4\" cellspacing=\"0\" class=\"tables\">\r\n<tr><td width=\"100%\" align=\"center\" class=\"barbg\"><b>".$uptms['other']."</b></td>\r\n</tr>";
                $hosts = $fArrCm['host'];
                $names = $fArrCm['name'];
                $services = $fArrCm['services'];
                $phpinf = $fArrCm['phpinfo'];
                $statUrl = $fArrCm['statusurl'];
                $exUrl = $fArrCm['mstatusurl'];
                $exUrl .= "?action=stat";
                if ( function_exists( "curl_version" ) )
                {
                    $ch = curl_init( );
                    curl_setopt( $ch, CURLOPT_URL, $exUrl );
                    curl_setopt( $ch, CURLOPT_HEADER, 0 );
                    curl_setopt( $ch, CURLOPT_USERAGENT, "Status2k" );
                    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
                    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $config['timeout'] * 5 );
                    $chx = @curl_exec( $ch );
                    curl_close( $ch );
                }
                else
                {
                    $chx = @file_get_contents( $exUrl );
                }
                preg_match( "/\\<load\\>(.*?)\\<\\/load\\>/", $chx, $chload );
                preg_match( "/\\<uptime\\>(.*?)\\<\\/uptime\\>/", $chx, $reguptime );
                preg_match( "/\\<os\\>(.*?)\\<\\/os\\>/", $chx, $chos );
                $chload = $chload[1];
                $reguptime = $reguptime[1];
                $chos = $chos[1];
                if ( !$chload )
                {
                    $chload = $uptms['notav'];
                }
                if ( !$reguptime )
                {
                    $reguptime = $uptms['notav'];
                }
                $bolMult .= "\r\n<tr><td width=\"100%\">\r\n<table border=\"1\" cellpadding=\"3\" class=\"multiservertable\">\r\n<tr><td align=\"center\" id=\"bg\" class=\"multitd\" height=\"18\"><b>".$uptms['server']."</b></td>";
                if ( $chos )
                {
                    $bolMult .= "<td align=\"center\" id=\"bg\" class=\"multitd\" height=\"18\"><b>OS</b></td>";
                }
                if ( $services )
                {
                    $services = explode( "|", $services );
                    foreach ( $services as $val )
                    {
                        $val = explode( ":", $val );
                        $sval = $val[0];
                        $bolMult .= "<td align=\"center\" id=\"bg\" class=\"multitd\" height=\"18\"><b>{$sval}</b></td>";
                    }
                }
                if ( $phpinf == "yes" )
                {
                    $bolMult .= "<td align=\"center\" height=\"18\" id=\"bg\" class=\"multitd\"><b>".$uptms['phpinfo']."</b></td>";
                }
                if ( $chload )
                {
                    $bolMult .= "<td align=\"center\" height=\"18\" id=\"bg\" class=\"multitd\"><b>".$uptms['load']."</b></td>";
                }
                if ( $reguptime )
                {
                    $bolMult .= "<td align=\"center\" height=\"18\" id=\"bg\" class=\"multitd\"><b>".$uptms['uptime']."</b></td></tr>";
                }
                if ( $statUrl )
                {
                    $bolMult .= "<tr><td height=\"25\" align=\"center\" class=\"multitd\"><a href=\"{$statUrl}\">{$names}</a></td>";
                }
                else
                {
                    $bolMult .= "<tr><td height=\"25\" align=\"center\" class=\"multitd\">{$names}</td>";
                }
                if ( $chos )
                {
                    $bolMult .= "<td height=\"25\" align=\"center\" class=\"multitd\"><img src=\"http://www.progamemap.com/public/images/status/multi/".$chos.".gif\" border=\"0\"></td>";
                }
                if ( $services )
                {
                    foreach ( $services as $val )
                    {
                        $val = explode( ":", $val );
                        $sval1 = $val[1];
                        $fsk = @fsockopen( $hosts, $sval1, &$varfs2, &$varfs3j, $config['timeout'] );
                        if ( $fsk )
                        {
                            $fsk = "<img border=\"0\" src=\"http://www.progamemap.com/public/images/status/ball_green_small.gif\" alt=\"UP\">";
                        }
                        else
                        {
                            $fsk = "<img border=\"0\" src=\"http://www.progamemap.com/public/images/status/ball_red_small.gif\" alt=\"DOWN\">";
                        }
                        $bolMult .= "<td height=\"25\" align=\"center\" class=\"multitd\">{$fsk}</td>";
                    }
                }
                if ( $phpinf == "yes" )
                {
                    $bolMult .= "<td height=\"25\" align=\"center\" class=\"multitd\"><a href=\"http://{$hosts}/multiservers/multiserv.php?action=phpinfo\">".$uptms['phpinfo']."</a></td>";
                }
                if ( $chload )
                {
                    $bolMult .= "<td height=\"25\" align=\"center\" class=\"multitd\">{$chload}</td>";
                }
                if ( $reguptime )
                {
                    $bolMult .= "<td height=\"25\" align=\"center\" class=\"multitd\">{$reguptime}</td>";
                }
                $bolMult .= "</tr></table></tr>";
            }
            $entable = "</table><BR>";
        }
    }
    return $htm.$bolMult.$entable;
}

function news( )
{
    global $prefix, $config;
    $addw = NULL;
    if ( $config['newsnumb'] == 0 )
    {
        $addw = "<img border=\"0\" src=\"http://www.progamemap.com/public/images/status/logo.gif\" alt=\"Status2k\">";
    }
    else
    {
        if ( !( $qr = mysql_query( "SELECT news, date FROM ".$prefix."news LIMIT ".$config['newsnumb'] ) ) )
        {
            exit( "Query failed: ".mysql_error( ) );
        }
        while ( ( $fArrCm = mysql_fetch_assoc( $qr ) ) !== false )
        {
            $addwS = $fArrCm['news'];
            $addwDate = $fArrCm['date'];
            if ( !$addw )
            {
                $addw = "<BR><img src=\"http://www.progamemap.com/public/images/status/news.gif\"><BR><BR>";
            }
            $addw .= "{$addwS} - <B>{$addwDate}</B><BR><BR>";
        }
    }
    return $addw;
}

function check( $hostname, $varfs1, $k, $varfs4, $reguptime )
{
    global $config;
    $fsck = @fsockopen( $hostname, $varfs1, &$varfs2, &$varfs3j, $config['timeout'] );
    if ( $k == 1 )
    {
        $id1 = "";
    }
    else
    {
        $id1 = "bg";
    }
    if ( $fsck )
    {
        $img_blg = "<img border=\"0\" src=\"http://www.progamemap.com/public/images/status/ball_green.gif\" alt=\"UP\">";
        $img_blg1 = "\r\n<tr>\r\n<td id=\"{$id1}\">{$varfs4}</td>\r\n<td id=\"{$id1}\">{$varfs1}</td>\r\n<td id=\"{$id1}\">{$reguptime}%</td>\r\n<td id=\"{$id1}\" align=\"center\">\r\n<p align=\"center\">{$img_blg}</td>\r\n</tr>";
    }
    else
    {
        $img_blg = "<img border=\"0\" src=\"http://www.progamemap.com/public/images/status/ball_red.gif\" alt=\"DOWN\">";
        $img_blg1 = "\r\n<tr>\r\n<td id=\"{$id1}\">{$varfs4}</td>\r\n<td id=\"{$id1}\">{$varfs1}</td>\r\n<td id=\"{$id1}\">{$reguptime}%</td>\r\n<td id=\"{$id1}\" align=\"center\">\r\n<p align=\"center\">{$img_blg}</td>\r\n</tr>";
    }
    @fclose( $fsck );
    return $img_blg1;
}

function percent( $valsc, $valsTotal )
{
    if ( $valsc && $valsTotal )
    {
        $perct = round( $valsc / $valsTotal * 100, 1 );
    }
    else
    {
        $perct = 0;
    }
    return $perct;
}

function bar( $perct, $per, $varfs4, $valbartp, $imgloc )
{
    $imgbar = "\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n<tr>\r\n<td width=\"1\"><img border=\"0\" src=\"http://www.progamemap.com/public/images/status/sides.png\" width=\"1\" alt=\"Bar\"></td>\r\n<td width=\"{$perct}%\"><img border=\"0\" src=\"http://www.progamemap.com/public/images/status/red.png\" width=\"100%\" height=\"10\" alt=\"Bar\"></td>\r\n<td width=\"100%\"><img border=\"0\" src=\"http://www.progamemap.com/public/images/status/green.png\" width=\"100%\" height=\"10\" alt=\"Bar\"></td>\r\n<td width=\"1\"><img border=\"0\" src=\"http://www.progamemap.com/public/images/status/sides.png\" width=\"1\" alt=\"Bar\"></td>\r\n</tr>\r\n</table>\r\n";
    $valbar = "\r\n<table border=\"0\" cellpadding=\"0\" width=\"100%\">\r\n<tr>\r\n<td width=\"20%\" align=\"left\"><div onMouseover=\"ddrivetip('{$valbartp}', 250)\" onMouseout=\"hideddrivetip()\"><B>{$varfs4}</B></div></td>\r\n<td width=\"55%\" align=\"center\">{$imgbar}</td>\r\n<td width=\"8%\" align=\"center\"><B>{$perct}%</B></td>\r\n<td width=\"17%\" align=\"center\">{$per}</td>\r\n</tr>\r\n</table>\r\n";
    return $valbar;
}

function uptime( $uptms, $reguptime )
{
    $days = floor( $reguptime / 60 / 60 / 24 );
    $hours = $reguptime / 60 / 60 % 24;
    $minutes = $reguptime / 60 % 60;
    $secs = $reguptime % 60;
    if ( $days == 1 )
    {
        $wDays = $uptms['day'];
    }
    else
    {
        $wDays = $uptms['days'];
    }
    if ( $hours == 1 )
    {
        $wHour = $uptms['hour'];
    }
    else
    {
        $wHour = $uptms['hours'];
    }
    if ( $minutes == 1 )
    {
        $wMinute = $uptms['min'];
    }
    else
    {
        $wMinute = $uptms['mins'];
    }
    if ( $secs == 1 )
    {
        $wSec = $uptms['sec'];
    }
    else
    {
        $wSec = $uptms['secs'];
    }
    $timeup = "{$days} {$wDays}, {$hours} {$wHour}, {$minutes} {$wMinute}, {$secs} {$wSec}";
    return $timeup;
}

function versions( )
{
    $sVrs = array( );
    $sVrs['zend'] = zend_version( );
    $sVrs['mysql'] = mysql_get_server_info( );
    $sVrs['php'] = phpversion( );
    if ( $_ENV['COMPUTERNAME'] )
    {
        $sVrs['compname'] = $_ENV['COMPUTERNAME'];
    }
    else
    {
        $sVrs['compname'] = str_replace( "www.", "", $_SERVER['SERVER_NAME'] );
        $sVrs['compname'] = strtoupper( $sVrs['compname'] );
    }
    if ( $_ENV['OS'] )
    {
        $sVrs['winver'] = ereg_replace( "_", " ", $_ENV['OS'] );
    }
    else
    {
        $sVrs['winver'] = "N/A";
    }
    $sVrs['serversoft'] = str_replace( "/", " ", $_SERVER['SERVER_SOFTWARE'] );
    $sVrs['serverdate'] = date( "r" );
    return $sVrs;
}

function cmdrun( $input )
{
    global $connection, $ssh2;
    if ( $ssh2 )
    {
        ob_start( );
        $streams = ssh2_exec( $connection, $input );
        stream_set_blocking( $streams, 1 );
        echo stream_get_contents( $streams );
        $streamser = ob_get_contents( );
        fclose( $streams );
        ob_end_clean( );
    }
    else
    {
        $streamser = shell_exec( $input );
    }
    return $streamser;
}

$past = time( ) - 3;
mysql_query( "DELETE FROM ".$prefix."antiflood WHERE time < '".$past."'" );
mysql_query( "INSERT INTO ".$prefix."antiflood (ip_addr, time) VALUES ('".$_SERVER['REMOTE_ADDR']."', '".time( )."')" );
$sql = mysql_query( "SELECT ip_addr FROM ".$prefix."antiflood WHERE ip_addr = '".$_SERVER['REMOTE_ADDR']."'" );
$numrow = mysql_num_rows( $sql );
if ( 5 <= $numrow )
{
    exit( "<br><br><center><font face=\"Verdana\" size=\"3\" color=\"red\"><b>Possible Denial Of Service Attack Detected!</b></font><BR><font face=\"Verdana\" size=\"1\">Please wait 3 seconds before reloading the page.</font></center>" );
}
$count = 0;
$services = NULL;
if ( !( $query = mysql_query( "SELECT host, name, port, up, down, sortnumb FROM ".$prefix."ports ORDER BY sortnumb" ) ) )
{
    exit( "Query failed: ".mysql_error( ) );
}
while ( ( $results = mysql_fetch_assoc( $query ) ) !== false )
{
    $ip = $results['host'];
    $name = $results['name'];
    $portnum = $results['port'];
    $up = $results['up'];
    $down = $results['down'];
    if ( $down == "0" )
    {
        $uptime = 100;
    }
    else
    {
        $downtime = $down / $up * 100;
        $uptime = round( 100 - $downtime, 2 );
    }
    $count++;
    $services .= check( $ip, $portnum, $count, $name, $uptime );
    if ( $count == 2 )
    {
        $count = 0;
    }
}

function drives( )
{
    global $config;
    $vDEx = explode( ",", $config['ddrives'] );
    $cDf = cmdrun( "df -h" );
    $vDexR = explode( "\n", $cDf );
    $k = 0;
    $drv = NULL;
    $val = NULL;
    $item = array( );
    foreach ( $vDexR as $val )
    {
        foreach ( $vDEx as $vval )
        {
            if ( $vval && $val && eregi( $vval, $val ) )
            {
                $val = 0;
            }
        }
        $item = split( " +", $val );
        if ( 0 < $k && isset( $item[4] ) )
        {
            $per = $item[2]."B / ".$item[1]."B";
            $drv .= "<tr><td align=\"center\" colspan=\"3\">";
            $item[4] = eregi_replace( "%", "", $item[4] );
            $drv .= bar( $item[4], $per, $item[5].":", $item[5].": = ".$item[4], $config['templaten'] );
            $drv .= "</td></tr>";
        }
        $k++;
    }
    return $drv;
}

function load( )
{
    $loadsh = cmdrun( "cat /proc/loadavg" );
    $uptim = explode( " ", $loadsh );
    $cms1 = $uptim[0];
    $cms2 = $uptim[1];
    $load3 = $uptim[2];
    return $uptim;
}

function uptimeseconds( )
{
    $uptimesSh = cmdrun( "cat /proc/uptime" );
    $uptimesSh = split( " ", $uptimesSh );
    return $uptimesSh[0];
}

function distroimage( $distros )
{
    $distros = strtolower( $distros );
    if ( eregi( "centos", $distros ) )
    {
        $distro_img = "<img src=\"http://www.progamemap.com/public/images/status/distros/centos.gif\" alt=\"CentOS\">";
    }
    if ( eregi( "debian", $distros ) )
    {
        $distro_img = "<img src=\"http://www.progamemap.com/public/images/status/distros/debian.gif\" alt=\"Debian\">";
    }
    if ( eregi( "fedora", $distros ) )
    {
        $distro_img = "<img src=\"http://www.progamemap.com/public/images/status/distros/fedora.gif\" alt=\"Fedora\">";
    }
    if ( eregi( "freebsd", $distros ) )
    {
        $distro_img = "<img src=\"http://www.progamemap.com/public/images/status/distros/freebsd.gif\" alt=\"FreeBSD\">";
    }
    if ( eregi( "gentoo", $distros ) )
    {
        $distro_img = "<img src=\"http://www.progamemap.com/public/images/status/distros/gentoo.gif\" alt=\"Gentoo\">";
    }
    if ( eregi( "mandrake", $distros ) )
    {
        $distro_img = "<img src=\"http://www.progamemap.com/public/images/status/distros/mandrake.gif\" alt=\"Mandrake\">";
    }
    if ( eregi( "redhat", $distros ) )
    {
        $distro_img = "<img src=\"http://www.progamemap.com/public/images/status/distros/redhat.gif\" alt=\"RedHat\">";
    }
    if ( eregi( "slackware", $distros ) )
    {
        $distro_img = "<img src=\"http://www.progamemap.com/public/images/status/distros/slackware.gif\" alt=\"Slackware\">";
    }
    if ( eregi( "suse", $distros ) )
    {
        $distro_img = "<img src=\"http://www.progamemap.com/public/images/status/distros/suse.gif\" alt=\"SuSe\">";
    }
    if ( !$distro_img || eregi( "Unknown", $distros ) )
    {
        $distro_img = "<img src=\"http://www.progamemap.com/public/images/status/distros/linux.gif\" alt=\"Linux\">";
    }
    return $distro_img;
}

function distro( )
{
    $distros = NULL;
    $distroT = "/etc/debian_release,/etc/debian_version,/etc/SuSE-release,/etc/UnitedLinux-release,/etc/mandrake-release,/etc/gentoo-release,/etc/redhat_version,/etc/redhat-release,/etc/fedora-release,/etc/slackware-release,/etc/slackware-version,/etc/trustix-release,/etc/trustix-version,/etc/eos-version,/etc/arch-release,/etc/lsb-release,/etc/gentoo-release,/etc/cobalt-release,/etc/lfs-release,/etc/rubix-version";
    foreach ( explode( ",", $distroT ) as $val )
    {
        if ( !$distros )
        {
            if ( file_exists( $val ) )
            {
                $distros = file_get_contents( $val );
            }
        }
        if ( !$distros )
        {
            $distros = cmdrun( "cat ".$val );
        }
    }
    if ( !$distros )
    {
        $distros = "Unknown";
    }
    return $distros;
}

function memory( )
{
    $rmem = cmdrun( "cat /proc/meminfo" );
    $fErmem = explode( "\n", $rmem );
    foreach ( $fErmem as $mvr )
    {
        $mvr = preg_replace( "/ kB/", "", $mvr );
        $arMrm = explode( ":", $mvr );
        if ( isset( $arMrm[0] ) )
        {
            $str1 = rtrim( $arMrm[0] );
        }
        if ( isset( $arMrm[1] ) )
        {
            $str2 = rtrim( $arMrm[1] );
        }
        if ( $str1 == "MemTotal" )
        {
            $mTot = $str2;
        }
        if ( $str1 == "MemFree" )
        {
            $mFree = $str2;
        }
        if ( $str1 == "SwapTotal" )
        {
            $mSwpTot = $str2;
        }
        if ( $str1 == "SwapFree" )
        {
            $mSwpFree = $str2;
        }
        if ( $str1 == "Buffers" )
        {
            $mem_item = $str2;
        }
        if ( $str1 == "Cached" )
        {
            $mCach = $str2;
        }
        if ( $str1 == "MemShared" )
        {
            $mShare = $str2;
        }
    }
    $agrt = $mTot - $mFree - $mCach - $mem_item;
    $agrtSwp = $mSwpTot - $mSwpFree;
    $memr['swapkb'] = $agrtSwp;
    $memr['memkb'] = $agrt;
    $memr['used'] = round( $agrt / 1024 / 1024, 2 );
    if ( 1000000 < $mTot )
    {
        $memr['total'] = ceil( $mTot / 1024 / 1024 );
    }
    else
    {
        $memr['total'] = round( $mTot / 1024 / 1024, 2 );
    }
    $memr['swapused'] = round( $agrtSwp / 1024 / 1024, 2 );
    if ( 1000000 < $mSwpTot )
    {
        $memr['swaptotal'] = ceil( $mSwpTot / 1024 / 1024 );
    }
    else
    {
        $memr['swaptotal'] = round( $mSwpTot / 1024 / 1024, 2 );
    }
    return $memr;
}

function cpuinfo( )
{
    global $config;
    $cuprin = cmdrun( "cat /proc/cpuinfo" );
    $cpur = explode( "\n", $cuprin );
    $cpu_clk_d = array( );
    $k = 0;
    foreach ( $cpur as $val )
    {
        $xplA = explode( ":", $val );
        if ( isset( $xplA[0] ) )
        {
            $str1 = rtrim( $xplA[0] );
        }
        if ( isset( $xplA[1] ) )
        {
            $str2 = rtrim( $xplA[1] );
        }
        if ( $str1 == "processor" )
        {
            $k++;
        }
        if ( $str1 == "model name" )
        {
            $cpu_clk_d['name'] = $str2;
        }
        if ( $str1 == "cache size" )
        {
            $cpu_clk_d['cache'] = $str2;
        }
        if ( $str1 == "cpu MHz" )
        {
            $cpu_clk_d['mhz'] = $str2;
        }
    }
    $cpu_clk_d['total'] = $k;
    return $cpu_clk_d;
}

function cpuimage( $cpuimg )
{
    if ( eregi( "AMD Opteron", $cpuimg ) )
    {
        $cpuimght = "<img src=\"http://www.progamemap.com/public/images/status/cpus/amdopteron.gif\" alt=\"AMD Opteron\">";
    }
    if ( eregi( "Xeon", $cpuimg ) )
    {
        $cpuimght = "<img src=\"http://www.progamemap.com/public/images/status/cpus/xeon.gif\" alt=\"Xeon\">";
    }
    if ( eregi( "Intel\\(R\\) Core", $cpuimg ) )
    {
        $cpuimght = "<img src=\"http://www.progamemap.com/public/images/status/cpus/core2.gif\" alt=\"Intel Core2 Duo\">";
    }
    if ( eregi( "Pentium\\(R\\) D", $cpuimg ) )
    {
        $cpuimght = "<img src=\"http://www.progamemap.com/public/images/status/cpus/pd.gif\" alt=\"Pentium D\">";
    }
    if ( eregi( "Pentium\\(R\\) 4", $cpuimg ) )
    {
        $cpuimght = "<img src=\"http://www.progamemap.com/public/images/status/cpus/p4.gif\" alt=\"Pentium 4\">";
    }
    if ( eregi( "Pentium III", $cpuimg ) )
    {
        $cpuimght = "<img src=\"http://www.progamemap.com/public/images/status/cpus/p3.gif\" alt=\"Pentium 3\">";
    }
    if ( eregi( "Pentium 2", $cpuimg ) )
    {
        $cpuimght = "<img src=\"http://www.progamemap.com/public/images/status/cpus/p2.gif\" alt=\"Pentium 2\">";
    }
    if ( eregi( "AMD Duron", $cpuimg ) )
    {
        $cpuimght = "<img src=\"http://www.progamemap.com/public/images/status/cpus/amdduron.gif\" alt=\"Pentium 4\">";
    }
    if ( eregi( "AMD Sempron", $cpuimg ) )
    {
        $cpuimght = "<img src=\"http://www.progamemap.com/public/images/status/cpus/amdsempron.gif\" alt=\"Pentium 4\">";
    }
    if ( eregi( "AMD Athlon", $cpuimg ) )
    {
        $cpuimght = "<img src=\"http://www.progamemap.com/public/images/status/cpus/amdathlon.gif\" alt=\"AMD Athlon\">";
    }
    if ( eregi( "Celeron", $cpuimg ) )
    {
        $cpuimght = "<img src=\"http://www.progamemap.com/public/images/status/cpus/celeron.gif\" alt=\"Celeron\">";
    }
    return $cpuimght;
}
?>
