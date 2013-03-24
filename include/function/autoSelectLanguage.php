<?php
 
/**
 * Détection automatique de la langue du navigateur
 *
 * Les codes langues du tableau $aLanguages doivent obligatoirement être sur 2 caractères
 *
 * @param array $aLanguages Tableau 1D des langues du site disponibles (ex: array('fr','en','es','it','de','cn')).
 * @param string $sDefault Langue à choisir par défaut si aucune n'est trouvée
 * @return string La langue du navigateur ou bien la langue par défaut
 * @author Hugo Hamon
 * @version 0.1
 */
function autoSelectLanguage($aLanguages = array('fr','en','es','it','de','cn'), $sDefault = 'fr') {
	if(!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
		$aBrowserLanguages = explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
		foreach($aBrowserLanguages as $sBrowserLanguage) {
			$sLang = strtolower(substr($sBrowserLanguage,0,2));
			if(in_array($sLang, $aLanguages)) {
				return $sLang;
			}
		}
	}
	return $sDefault;
}
 
?>