window.addEvent("domready",function(){function c(){return $("sa").title}var f=0;var e=0;var d=0;var b={"true":"close","false":"open"};var a=1;if($("loginLinkBox")){$("LoginBox").setStyles({opacity:0,display:"block"});$(document.body).addEvent("click",function(g){if($("LoginBox").get("opacity")==1&&a==1){$("LoginBox").fade("out");$("log-username").set("value","");$("log-password").set("value","")}});$("LoginBox").addEvent("mouseover",function(g){a=0});$("LoginBox").addEvent("mouseout",function(g){a=1});$("loginLinkBox").addEvent("click",function(g){g.stop();$("LoginBox").fade("in")})}$("log-submit").addEvent("click",function(g){g.stop();new Request({method:"post",url:"http://www.progamemap.com/include/model/login_verif.php",data:{input:"log-submit",name:$("log-username").value,pass:$("log-password").value,sa:$("sa").value},onComplete:function(h){sbox_view(h);if(h.match("UsernameEmpty")){$("usernameCheck").set("html",'<div class="noticeLog">Username manquant</div>');$("loginCheck").set("html","");f=1}if(h.match("PassEmpty")){$("passwordCheck").set("html",'<div class="noticeLog">Password manquant</div>');$("loginCheck").set("html","");e=1}if(h.match("UsernameOk")){$("usernameCheck").set("html","");$("loginCheck").set("html","");f=0}if(h.match("PassOk")){$("passwordCheck").set("html","");$("loginCheck").set("html","");e=0}if(h.match("LoginFalse")){$("loginCheck").set("html",'<div class="noticeLog">Informations erron&eacute;es</div>');d=1}if(h.match("LoginOk")){location.reload();d=0}if(f==1||e==1||d==1){$("flash_boxes").setStyles({display:"block"})}else{$("flash_boxes").setStyles({display:"none"})}}}).send()})});