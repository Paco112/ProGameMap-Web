<table style="width:94%">
  <tr>
    <td style="width:50%">
      <div class="menuCompte">
      	<form action="" method="post">
    	<h2>{$#RECHERCHE_USER} :</h2>
        <div>{$#NOMAFFICHAGEJOUEUR} :<br /><input type="text" id="dname" value="{$ProfilSearch}" /><br /><br />
        <div class="right gistsubmit"><input type="submit" id="search_profil" value="{$#RESEARCH}" onclick="profil_search('profil','{$linkForm}'); return false;" /><span></span></div><br /><br /></div>
        </form>
      </div>
    </td><td style="width:50%">
      <div class="menuCompte" style="margin-right:8px; width:100%;">
    	<form action="" method="post">
        <h2>{$#RECHERCHEDETEAM} :</h2>
        <div>{$#NOMDELATEAM} :<br /><input type="text" id="name" value="{$TeamSearch}" /><br /><br />
        <div class="right gistsubmit"><input type="submit" id="search_team" value="{$#RESEARCH}" onclick="profil_search('team','{$linkForm}'); return false;" /><span></span></div><br /><br /></div>
        </form>
      </div>
    </td>
  </tr>
</table>
<div class="menuCompte" style="margin-right:8px;">
	<div style="width:100%; margin-left:5px; margin-bottom:5px; font-style:italic;">{$StatsListe}</div>
    {$ListeProfil}
    <div style="width:100%; position:relative; display:block;"><br/>
        <table border="0" cellspacing="0" cellpadding="0" style="margin:auto; text-align:center;">
          <tr>
            <td>{$Paging}</td>
          </tr>
        </table>
        <br/>
    </div>
</div>