<?php
ini_set('max_execution_time', 350);
set_time_limit(350);
 
// Robot de création automatique des zip maps en fonction de l'id map et l'id serveur
include('include/class/sbox.php');
class zipfile
{
    /**
     * Array to store compressed data
     *
     * @var  array    $datasec
     */
    var $datasec      = array();

    /**
     * Central directory
     *
     * @var  array    $ctrl_dir
     */
    var $ctrl_dir     = array();

    /**
     * End of central directory record
     *
     * @var  string   $eof_ctrl_dir
     */
    var $eof_ctrl_dir = "\x50\x4b\x05\x06\x00\x00\x00\x00";

    /**
     * Last offset position
     *
     * @var  integer  $old_offset
     */
    var $old_offset   = 0;


    /**
     * Converts an Unix timestamp to a four byte DOS date and time format (date
     * in high two bytes, time in low two bytes allowing magnitude comparison).
     *
     * @param  integer  the current Unix timestamp
     *
     * @return integer  the current date in a four byte DOS format
     *
     * @access private
     */
    function unix2DosTime($unixtime = 0) {
        $timearray = ($unixtime == 0) ? getdate() : getdate($unixtime);

        if ($timearray['year'] < 1980) {
            $timearray['year']    = 1980;
            $timearray['mon']     = 1;
            $timearray['mday']    = 1;
            $timearray['hours']   = 0;
            $timearray['minutes'] = 0;
            $timearray['seconds'] = 0;
        } // end if

        return (($timearray['year'] - 1980) << 25) | ($timearray['mon'] << 21) | ($timearray['mday'] << 16) |
                ($timearray['hours'] << 11) | ($timearray['minutes'] << 5) | ($timearray['seconds'] >> 1);
    } // end of the 'unix2DosTime()' method


    /**
     * Adds "file" to archive
     *
     * @param  string   file contents
     * @param  string   name of the file in the archive (may contains the path)
     * @param  integer  the current timestamp
     *
     * @access public
     */
    function addFile($data, $name, $time = 0)
    {
        $name     = str_replace('\\', '/', $name);

        $dtime    = dechex($this->unix2DosTime($time));
        $hexdtime = '\x' . $dtime[6] . $dtime[7]
                  . '\x' . $dtime[4] . $dtime[5]
                  . '\x' . $dtime[2] . $dtime[3]
                  . '\x' . $dtime[0] . $dtime[1];
        eval('$hexdtime = "' . $hexdtime . '";');

        $fr   = "\x50\x4b\x03\x04";
        $fr   .= "\x14\x00";            // ver needed to extract
        $fr   .= "\x00\x00";            // gen purpose bit flag
        $fr   .= "\x08\x00";            // compression method
        $fr   .= $hexdtime;             // last mod time and date

        // "local file header" segment
        $unc_len = strlen($data);
        $crc     = crc32($data);
        $zdata   = gzcompress($data);
        $zdata   = substr(substr($zdata, 0, strlen($zdata) - 4), 2); // fix crc bug
        $c_len   = strlen($zdata);
        $fr      .= pack('V', $crc);             // crc32
        $fr      .= pack('V', $c_len);           // compressed filesize
        $fr      .= pack('V', $unc_len);         // uncompressed filesize
        $fr      .= pack('v', strlen($name));    // length of filename
        $fr      .= pack('v', 0);                // extra field length
        $fr      .= $name;

        // "file data" segment
        $fr .= $zdata;

        // "data descriptor" segment (optional but necessary if archive is not
        // served as file)
        // nijel(2004-10-19): this seems not to be needed at all and causes
        // problems in some cases (bug #1037737)
        //$fr .= pack('V', $crc);                 // crc32
        //$fr .= pack('V', $c_len);               // compressed filesize
        //$fr .= pack('V', $unc_len);             // uncompressed filesize

        // add this entry to array
        $this -> datasec[] = $fr;

        // now add to central directory record
        $cdrec = "\x50\x4b\x01\x02";
        $cdrec .= "\x00\x00";                // version made by
        $cdrec .= "\x14\x00";                // version needed to extract
        $cdrec .= "\x00\x00";                // gen purpose bit flag
        $cdrec .= "\x08\x00";                // compression method
        $cdrec .= $hexdtime;                 // last mod time & date
        $cdrec .= pack('V', $crc);           // crc32
        $cdrec .= pack('V', $c_len);         // compressed filesize
        $cdrec .= pack('V', $unc_len);       // uncompressed filesize
        $cdrec .= pack('v', strlen($name) ); // length of filename
        $cdrec .= pack('v', 0 );             // extra field length
        $cdrec .= pack('v', 0 );             // file comment length
        $cdrec .= pack('v', 0 );             // disk number start
        $cdrec .= pack('v', 0 );             // internal file attributes
        $cdrec .= pack('V', 32 );            // external file attributes - 'archive' bit set

        $cdrec .= pack('V', $this -> old_offset ); // relative offset of local header
        $this -> old_offset += strlen($fr);

        $cdrec .= $name;

        // optional extra field, file comment goes here
        // save to central directory
        $this -> ctrl_dir[] = $cdrec;
    } // end of the 'addFile()' method


    /**
     * Dumps out file
     *
     * @return  string  the zipped file
     *
     * @access public
     */
    function file()
    {
        $data    = implode('', $this -> datasec);
        $ctrldir = implode('', $this -> ctrl_dir);

        return
            $data .
            $ctrldir .
            $this -> eof_ctrl_dir .
            pack('v', sizeof($this -> ctrl_dir)) .  // total # of entries "on this disk"
            pack('v', sizeof($this -> ctrl_dir)) .  // total # of entries overall
            pack('V', strlen($ctrldir)) .           // size of central dir
            pack('V', strlen($data)) .              // offset to start of central dir
            "\x00\x00";                             // .zip file comment length
    } // end of the 'file()' method

} // end of the 'zipfile' class

if(!$_GET['game'] && !$_GET['id_s'])
{
	?>
	<form name="form1" method="get" action="ROBOT_ZIP.php">
	  <p>Jeux (Majuscule):</p>
	  <p>
		<label>
		  <input name="game" type="text" id="game" value="MOHAA">
		</label>
	  </p>
	  <p>ID SERVEUR :</p>
	  <p>
		<label>
		  <input type="text" name="id_s" id="id_s">
		</label>
	  </p>
	  <p>
		<label>
		  <input type="submit" name="button" id="button" value="Envoyer">
		</label>
	  </p>
	</form>
    <?php
}
else
{
	// création des zip
	
	// on récupère les infos du serveur
	$serv = $sbox->select(array('table'=>'ip_servers','select'=>'*','where'=>'id=/'.$_GET['id_s'].'/'));
	
	// on récupère la liste des maps du jeux demandé
	$list_maps = $sbox->select_multi(array('table'=>'maps_'.$_GET['game'],'select'=>'*'));	
	
	foreach($list_maps as $map)
	{		  

     $zip = new zipfile( ) ; //on crée une nouvelle instance zip
	 
	 if($_GET['game'] == "MOHAA")
	 {
     	$nom_fichier = $map['file'].'.'.$map['file_ext']; //nom du fichier à compresser
		
		$fo = fopen("maps/".$_GET['game']."/".$nom_fichier,'r') ; //on ouvre le fichier
		
		 if($fo)
		 {
			 $contenu = fread($fo, filesize("maps/".$_GET['game']."/".$nom_fichier)) ; //on enregistre le contenu
			 fclose($fo) ; //on ferme le fichier
		
			 $zip->addfile($contenu, $map['folder'].'\\'.$nom_fichier) ; //on ajoute le fichier
		
			 $archive_zip = $zip->file() ; //on associe l'archive
			 
			 // créer le nouveau nom du fichier zip via les 2 clée
			 $zip_name = sha1($serv->key_files.$map['file_key']).'.zip';
		
			 $open = fopen('ftp://'.$serv->login.':'.$serv->password.'@'.$serv->ip.$serv->folder.$zip_name , 'wb'); //crée le fichier zip
			 if(fwrite($open, $archive_zip)) //enregistre le contenu de l'archive
			 {
				 echo "OK ".$nom_fichier." -> ".$zip_name."<br>";
			 }
			 else
			 {
				 echo "ERREUR ".$nom_fichier." -> ".$zip_name."<br>";
			 }
			 fclose($open); //ferme l'archive
		 }
		 else
		 {
			 echo "ERREUR FICHIER INTROUVABLE".$nom_fichier;
		 }
	 }
	 else
	 {
     	 $nom_fichier = $map['file'];
		 
		$fo = fopen("maps/".$_GET['game']."/".$nom_fichier."/".$nom_fichier.".".$map['file_ext'],'r') ; //on ouvre le fichier
		
		 if($fo)
		 {
			 // file 1
			 $contenu = fread($fo, filesize("maps/".$_GET['game']."/".$nom_fichier."/".$nom_fichier.".".$map['file_ext'])) ; //on enregistre le contenu
			 fclose($fo) ; //on ferme le fichier
			 $zip->addfile($contenu, $map['folder'].'\\'.$nom_fichier.'\\'.$nom_fichier.'.'.$map['file_ext']) ; //on ajoute le fichier
			 
			 // file 2
			 $fo = fopen("maps/".$_GET['game']."/".$nom_fichier."/".$nom_fichier.".ff",'r') ; //on ouvre le fichier
			 $contenu = fread($fo, filesize("maps/".$_GET['game']."/".$nom_fichier."/".$nom_fichier.".ff")) ; //on enregistre le contenu
			 fclose($fo) ; //on ferme le fichier
			 $zip->addfile($contenu, $map['folder'].'\\'.$nom_fichier.'\\'.$nom_fichier.'.ff') ; //on ajoute le fichier
			 
			 // file 3
			 $fo = fopen("maps/".$_GET['game']."/".$nom_fichier."/".$nom_fichier."_load.ff",'r') ; //on ouvre le fichier
			 $contenu = fread($fo, filesize("maps/".$_GET['game']."/".$nom_fichier."/".$nom_fichier."_load.ff")) ; //on enregistre le contenu
			 fclose($fo) ; //on ferme le fichier
			 $zip->addfile($contenu, $map['folder'].'\\'.$nom_fichier.'\\'.$nom_fichier.'_load.ff') ; //on ajoute le fichier
		
			 $archive_zip = $zip->file() ; //on associe l'archive
			 
			 // créer le nouveau nom du fichier zip via les 2 clée
			 $zip_name = sha1($serv->key_files.$map['file_key']).'.zip';
		
			 $open = fopen('ftp://'.$serv->login.':'.$serv->password.'@'.$serv->ip.$serv->folder.$zip_name , 'wb'); //crée le fichier zip
			 if(fwrite($open, $archive_zip)) //enregistre le contenu de l'archive
			 {
				 echo "OK ".$nom_fichier." -> ".$zip_name."<br>";
			 }
			 else
			 {
				 echo "ERREUR ".$nom_fichier." -> ".$zip_name."<br>";
			 }
			 fclose($open); //ferme l'archive
		 }
		 else
		 {
			 echo "ERREUR FICHIER INTROUVABLE".$nom_fichier;
		 }
	 }
	}
	echo "fini";
}
?>