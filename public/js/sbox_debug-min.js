try{var mv=MooTools.version;window.addEvent("domready",function(){if($("debug_bar")){var c=new Fx.Slide("v-menu");c.hide();$("debug_bar").setStyle("display","block");$("sbox_c").addEvent("click",function(d){d=new Event(d);c.toggle();d.stop()});var b=$$(".v-menu li"),a=b.getStyle("backgroundColor");color_text=b.getStyle("color");$$(".v-menu li").set("opacity",0.7).addEvents({mouseenter:function(){this.morph({opacity:0.8,"background-color":"#FC3",color:"#FFF","font-weight":"bold"})},mouseleave:function(){this.morph({opacity:0.7,"background-color":a,color:color_text,"font-weight":"normal"})}})}});function sbox_view(b){var d="";try{d=document.getElementById("inc_sbox_debug").value}catch(a){alert("Veuillez verifier la presence des balises html necessaire a la console sbox")}if(d==""){alert("le lien (inc_sbox_debug) de la console sbox  est incorrect !")}else{try{if(b){document.getElementById("v-menu").innerHTML='<br /><table style="color:#F00; padding-left:5px;" width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td>Reponse AJAX :</td><td>'+b+"</td></tr></table><br />"}var c=new Request({method:"get",url:d,data:"view=1",onRequest:function(){document.getElementById("sbox_c_error").innerHTML+='<div style="color:#FFF; font-size:12px;">Loading ...</div>'},onComplete:function(e){document.getElementById("sbox_c_error").innerHTML=e}}).send();var c=new Request({method:"get",url:d,data:"view=2",onRequest:function(){document.getElementById("v-menu").innerHTML+="Loading ..."},failure:function(e){alert("Echec de la requete de mise a jour de la console sbox !")},onComplete:function(e){document.getElementById("v-menu").innerHTML+=e}}).send()}catch(a){alert("Une erreur inattendue c'est produite durant la requete ajax de la console sbox !")}}}sbox_view()}catch(ex){alert("ERREUR CONSOLE SBOX : \n\n"+ex)};