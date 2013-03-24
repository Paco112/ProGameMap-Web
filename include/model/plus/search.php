<?php
# Google AdSense for Search freeware add-on
# This file is intended to keep this software freeware and is not part of the open-source code of this software.
# It comes as a plugin which should bring a few cents to the developer of this Plus version of phpMyChat,  as a reward for his work.
# This will not cost you or any of your users anything. So please be kind and don't alter in any way this script.
# On the other hand, changing or removing it from this chat may result in getting you suspended from using this chat version!
# You will also not get any future support if you'll need it.
# If you have questions or comments about this, please contact the developer of this chat.
# Thank you for your understanding. I appreciate it!

switch($L)
{
	case "argentinian_spanish":
		$L_G_EXT = "com.ar";
		$L_G_SA = "Buscar";
		$L_G_HL = "es";
		$L_G_CX = "sn00uj-w8oi";
		break;
	case "spanish":
		$L_G_EXT = "es";
		$L_G_SA = "Buscar";
		$L_G_HL = "es";
		$L_G_CX = "pw7i8w-y4de";
		break;
	case "english":
		$L_G_EXT = "co.uk";
		$L_G_SA = "Search";
		$L_G_HL = "en";
		$L_G_CX = "29rzcl-ytld";
		break;
	case "german":
		$L_G_EXT = "de";
		$L_G_SA = "Suche";
		$L_G_HL = "de";
		$L_G_CX = "nmp2xz-ibwi";
		break;
	case "french":
		$L_G_EXT = "fr";
		$L_G_SA = "Rechercher";
		$L_G_HL = "fr";
		$L_G_CX = "qu42zo-puy3";
		break;
	case "italian":
		$L_G_EXT = "it";
		$L_G_SA = "Cerca";
		$L_G_HL = "it";
		$L_G_CX = "xcwimo-lord";
		break;
	case "dutch":
		$L_G_EXT = "nl";
		$L_G_SA = "Zoeken";
		$L_G_HL = "nl";
		$L_G_CX = "efn8u2-oedw";
		break;
	case "romanian":
		$L_G_EXT = "ro";
		$L_G_SA = "Căutare";
		$L_G_SA = "C&#x0103;utare";
		$L_G_HL = "ro";
		$L_G_CX = "cd8a0m-8lw3";
		break;
	case "turkish":
		$L_G_EXT = "com.tr";
		$L_G_SA = "Ara";
		$L_G_HL = "tr";
		$L_G_CX = "thmxut-u4sx";
		break;
	case "vietnamese":
		$L_G_EXT = "com.vn";
#		$L_G_SA = "Tìm kiếm";
		$L_G_SA = "Ti&#768;m ki&#234;&#769;m";
		$L_G_HL = "vi";
		$L_G_CX = "73gv6i-7nsh";
		break;
	default:
		$L_G_EXT = "com";
		$L_G_SA = "Search";
		$L_G_HL = "en";
		$L_G_CX = "v5m0ds-vk8w";
		break;
}
?>
<?php
$search = 
"<table align=\"center\">
<tr valign=\"middle\">
<td align=\"center\">
	<form action=\"http://www.google.$L_G_EXT/cse\" id=\"cse-search-box\" target=\"_blank\">
		<div>
			<input type=\"hidden\" name=\"cx\" value=\"partner-pub-9362782527650497:$L_G_CX\" />
			<input type=\"hidden\" name=\"ie\" value=\"UTF-8\" />
			<input type=\"text\" name=\"q\" size=\"40\" />
			<input type=\"submit\" name=\"sa\" value=\"$L_G_SA\" />
		</div>
	</form>
<script type=\"text/javascript\" style=\"background-color:transparent;\" src=\"http://www.google.$L_G_EXT/coop/cse/brand?form=cse-search-box&amp;lang=$L_G_HL\"></script>
</td>
</tr>
</table>\n";
?>