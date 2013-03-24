<?
 // Si le nom du fichier apparait dans l'URL, on affiche un message d'erreur.
if (stristr("footer.php", $_SERVER['PHP_SELF'])) {
      exit(1);
      exit(0404);
}
?>
<!-- FOOTER DEBUT -->            
            <table width="985" border="0" align="center" cellpadding="0" cellspacing="0" background="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/footer_15.jpg">
                  <tr> 
                    <td width="139"><img src="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/footer_14.jpg" width="203" height="90"></td>
                    <td width="846" class="petit">
                        <strong><a href="" class="lienvideos">Index</a></strong> - <strong><a href="" class="lienvideos">Entrée des membres</a></strong> - <strong><a href="#_" class="lienvideos" OnClick="affiche_overlay_window('pop_join.php?i=aucune&t=videos','508','423');">Inscription</a></strong> - <strong><a href="" class="lienvideos">Contact</a></strong><br><br><span class="gris">Tous les mod&egrave;les pr&eacute;sents sur ce site sont majeurs au moment du tournage.<br>Toute reproduction, totale ou partielle, est strictement interdite. Protection de l'accès assurée par l'Icra.<br>Copyright 2008 - Déclaration CNIL 1333390 - </span><strong><a href="" class="lienvideos"></a></strong> - <a href="" target="_blank" class="lienvideos">Affiliation</a> - <a href="" target="_blank" class="lienvideos">Outils pour webmasters</a>
                    </td>
                </tr>
            </table>
<!-- FOOTER END -->