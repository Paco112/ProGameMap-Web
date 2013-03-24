var MooFlow=new Class({Implements:[Events,Options],options:{onStart:$empty,onClickView:$empty,onAutoPlay:$empty,onAutoStop:$empty,onRequest:$empty,onResized:$empty,onEmptyinit:$empty,reflection:0.4,heightRatio:0.6,offsetY:0,startIndex:0,interval:3000,factor:115,bgColor:"#000",useCaption:false,useResize:false,useSlider:false,useWindowResize:false,useMouseWheel:true,useKeyInput:false,useViewer:false},initialize:function(b,a){this.MooFlow=b;this.setOptions(a);this.foc=150;this.factor=this.options.factor;this.offY=this.options.offsetY;this.isFull=false;this.isAutoPlay=false;this.isLoading=false;this.inMotion=false;this.MooFlow.addClass("mf").setStyles({overflow:"hidden","background-color":this.options.bgColor,position:"relative",height:this.MooFlow.getSize().x*this.options.heightRatio,opacity:0});if(this.options.useWindowResize){window.addEvent("resize",this.update.bind(this,"init"))}if(this.options.useMouseWheel||this.options.useSlider){this.MooFlow.addEvent("mousewheel",this.wheelTo.bind(this))}if(this.options.useKeyInput){document.addEvent("keydown",this.keyTo.bind(this))}this.getElements(this.MooFlow)},clearInit:function(){this.fireEvent("emptyinit")},getElements:function(b){this.master={images:[]};var a=b.getChildren();if(!a.length){this.clearInit();return}$$(a).each(function(c){var d=$H(c.getElement("img").getProperties("src","title","alt","longdesc"));if(c.get("tag")=="a"){d.combine(c.getProperties("href","rel","target"))}this.master.images.push(d.getClean());c.dispose()},this);this.clearMain()},clearMain:function(){if(this.cap){this.cap.fade(0)}if(this.nav){new Fx.Tween(this.nav,{onComplete:function(){this.MooFlow.empty();this.createAniObj()}.bind(this)}).start("bottom",-50)}if(!this.nav&&!this.cap){this.MooFlow.empty();this.createAniObj()}},getMooFlowElements:function(b){var a=[];this.master.images.each(function(c){a.push(c[b])});return a},createAniObj:function(){this.aniFx=new Fx.Value({transition:Fx.Transitions.Expo.easeOut,link:"cancel",duration:750,onMotion:this.process.bind(this),onStart:this.flowStart.bind(this),onComplete:this.flowComplete.bind(this)});this.addLoader()},addLoader:function(){this.MooFlow.store("height",this.MooFlow.getSize().y);this.loader=new Element("div",{"class":"loader"}).inject(this.MooFlow);new Fx.Tween(this.MooFlow,{duration:100,onComplete:this.preloadImg.bind(this)}).start("opacity",1)},preloadImg:function(){this.loadedImages=new Asset.images(this.getMooFlowElements("src"),{onComplete:this.loaded.bind(this),onProgress:this.createMooFlowElement.bind(this)})},createMooFlowElement:function(a,c){var d=this.getCurrent(c);var b=this.loadedImages[c];d.width=b.width;d.height=b.height;b.removeProperties("width","height");d.div=new Element("div").setStyles({position:"absolute",display:"none",height:this.MooFlow.getSize().y}).inject(this.MooFlow);d.con=new Element("div").inject(d.div);b.setStyles({"vertical-align":"bottom",width:"100%",height:"50%"});b.addEvents({click:this.viewCallBack.bind(this,c)});b.inject(d.con);new Element("div").reflect({img:b,ref:this.options.reflection,height:d.height,width:d.width,color:this.options.bgColor}).setStyles({width:"100%",height:"50%","background-color":this.options.bgColor}).inject(d.con);this.loader.set("text",(a+1)+" / "+this.loadedImages.length)},loaded:function(){this.index=this.options.startIndex;this.iL=this.master.images.length-1;new Fx.Tween(this.loader,{duration:100,onComplete:this.createUI.bind(this)}).start("opacity",0)},createUI:function(){this.loader.dispose();if(this.options.useCaption){this.cap=new Element("div").addClass("caption").set("opacity",0).inject(this.MooFlow)}this.nav=new Element("div").addClass("mfNav").setStyle("bottom","-50px");this.autoPlayCon=new Element("div").addClass("autoPlayCon");this.sliderCon=new Element("div").addClass("sliderCon");this.resizeCon=new Element("div").addClass("resizeCon");if(this.options.useAutoPlay){this.autoPlayCon.adopt(new Element("a",{"class":"stop",events:{click:this.stop.bind(this)}}),new Element("a",{"class":"play",events:{click:this.play.bind(this)}}))}if(this.options.useSlider){this.sliPrev=new Element("a",{"class":"sliderNext",events:{click:this.prev.bind(this)}});this.sliNext=new Element("a",{"class":"sliderPrev",events:{click:this.next.bind(this)}});this.knob=new Element("div",{"class":"knob"});this.knob.adopt(new Element("div",{"class":"knobleft"}));this.slider=new Element("div",{"class":"slider"}).adopt(this.knob);this.sliderCon.adopt(this.sliPrev,this.slider,this.sliNext);this.slider.store("parentWidth",this.sliderCon.getSize().x-this.sliPrev.getSize().x-this.sliNext.getSize().x)}if(this.options.useResize){this.resizeCon.adopt(new Element("a",{"class":"resize",events:{click:this.setScreen.bind(this)}}))}this.MooFlow.adopt(this.nav.adopt(this.autoPlayCon,this.sliderCon,this.resizeCon));this.showUI()},showUI:function(){if(this.cap){this.cap.fade(1)}this.nav.tween("bottom",20);this.fireEvent("start");this.update()},update:function(a){if(a=="init"){return}this.oW=this.MooFlow.getSize().x;this.sz=this.oW*0.5;if(this.options.useSlider){this.slider.setStyle("width",this.slider.getParent().getSize().x-this.sliPrev.getSize().x-this.sliNext.getSize().x-1);this.knob.setStyle("width",(this.slider.getSize().x/this.iL));this.sli=new SliderEx(this.slider,this.knob,{steps:this.iL}).set(this.index);this.sli.addEvent("onChange",this.glideTo.bind(this))}this.glideTo(this.index);this.isLoading=false},setScreen:function(){if(this.isFull=!this.isFull){this.holder=new Element("div").inject(this.MooFlow,"after");this.MooFlow.wraps(new Element("div").inject(document.body));this.MooFlow.setStyles({position:"absolute","z-index":"100",top:"0",left:"0",width:window.getSize().x,height:window.getSize().y});if(this.options.useWindowResize){this._initResize=this.initResize.bind(this);window.addEvent("resize",this._initResize)}}else{this.MooFlow.wraps(this.holder);window.removeEvent("resize",this._initResize);delete this.holder,this._initResize;this.MooFlow.setStyles({position:"relative","z-index":"",top:"",left:"",width:"",height:this.MooFlow.retrieve("height")});this.slider.setStyle("width",this.slider.retrieve("parentWidth"))}this.fireEvent("resized",this.isFull);this.update()},initResize:function(){this.MooFlow.setStyles({width:window.getSize().x,height:window.getSize().y});this.update()},getCurrent:function(a){return this.master.images[$chk(a)?a:this.index]},loadJSON:function(a){if(!a||this.isLoading){return}this.isLoading=true;new Request.JSON({onComplete:function(b){if($chk(b)){this.master=b;this.clearMain();this.fireEvent("request",b)}}.bind(this)},this).get(a)},loadHTML:function(a,b){if(!a||!b||this.isLoading){return}this.isLoading=true;new Request.HTML({onSuccess:function(d,f,e){var c=new Element("div",{html:e}).getChildren(b);this.getElements(c);this.fireEvent("request",c)}.bind(this)},this).get(a)},flowStart:function(){this.inMotion=true},flowComplete:function(){this.inMotion=false},viewCallBack:function(a){if(this.index!=a||this.inMotion){return}var c=$H(this.getCurrent());var b={};b.coords=c.div.getElement("img").getCoordinates();c.each(function(e,d){if($type(e)=="number"||$type(e)=="string"){b[d]=e}},this);this.fireEvent("clickView",b)},prev:function(){if(this.index>0){this.clickTo(this.index-1)}},next:function(){if(this.index<this.iL){this.clickTo(this.index+1)}},stop:function(){$clear(this.autoPlay);this.isAutoPlay=false;this.fireEvent("autoStop")},play:function(){this.autoPlay=this.auto.periodical(this.options.interval,this);this.isAutoPlay=true;this.fireEvent("autoPlay")},auto:function(){if(this.index<this.iL){this.next()}else{if(this.index==this.iL){this.clickTo(0)}}},keyTo:function(a){switch(a.code){case 37:a.stop();this.prev();break;case 39:a.stop();this.next()}},wheelTo:function(a){if(a.wheel>0){this.prev()}if(a.wheel<0){this.next()}a.stop().preventDefault()},clickTo:function(a){if(this.index==a){return}if(this.sli){this.sli.set(a)}this.glideTo(a)},glideTo:function(a){this.index=a;this.aniFx.start(this.aniFx.get(),a*-this.foc);if(this.cap){this.cap.set("html",this.getCurrent().title)}},process:function(x){var z,W,H,zI=this.iL,foc=this.foc,f=this.factor,sz=this.sz,oW=this.oW,offY=this.offY,div,elh,elw;this.master.images.each(function(el){div=el.div.style;elw=el.width;elh=el.height;if(x>-foc*6&&x<foc*6){with(Math){z=sqrt(10000+x*x)+100;H=round((elh/elw*f)/z*sz);W=round(elw*H/elh);if(H>=elw*0.5){W=round(f/z*sz)}div.left=round(((x/z*sz)+sz)-(f*0.5)/z*sz)+"px";div.top=round(oW*0.4-H)+offY+"px"}el.con.style.height=H*2+"px";div.width=W+"px";div.zIndex=x<0?zI++:zI--;div.display="block"}else{div.display="none"}x+=foc})}});var SliderEx=new Class({Extends:Slider,set:function(a){this.step=Math.round(a);this.fireEvent("tick",this.toPosition(this.step));return this},clickedElement:function(c){var b=this.range<0?-1:1;var a=c.page[this.axis]-this.element.getPosition()[this.axis]-this.half;a=a.limit(-this.options.offset,this.full-this.options.offset);this.step=Math.round(this.min+b*this.toStep(a));this.checkStep();this.fireEvent("tick",a)}});Fx.Value=new Class({Extends:Fx,compute:function(c,b,a){this.value=Fx.compute(c,b,a);this.fireEvent("motion",this.value);return this.value},get:function(){return this.value||0}});Element.implement({reflect:function(a){i=a.img.clone().set("src",a.img.src);if(Browser.Engine.trident){i.style.filter="flipv progid:DXImageTransform.Microsoft.Alpha(opacity=20, style=1, finishOpacity=0, startx=0, starty=0, finishx=0, finishy="+100*a.ref+")";i.setStyles({width:"100%",height:"100%"});return new Element("div").adopt(i)}else{var e=new Element("canvas").setProperties({width:a.width,height:a.height});if(e.getContext){var b=e.getContext("2d");b.save();b.translate(0,a.height-1);b.scale(1,-1);try{b.drawImage(i,0,0,a.width,a.height)}catch(d){}b.restore();b.globalCompositeOperation="destination-out";b.fillStyle=a.color;b.fillRect(0,a.height*0.5,a.width,a.height);var c=b.createLinearGradient(0,0,0,a.height*a.ref);c.addColorStop(1,"rgba(255, 255, 255, 1.0)");c.addColorStop(0,"rgba(255, 255, 255, "+(1-a.ref)+")");b.fillStyle=c;b.rect(0,0,a.width,a.height);b.fill();delete b,c}return e}}});window.addEvent("domready",function(){$$(".MooFlowieze").each(function(b){new MooFlow(b)});var a=new MooFlow($("MooFlow"),{startIndex:1,bgColor:"transparent",useAutoPlay:false,useCaption:true,useMouseWheel:true,useKeyInput:true,onClickView:function(d){var c=window.location.toString();var b=c.length;if((b-c.lastIndexOf("/"))==1){window.location=c+d.alt+"/"}else{window.location=c+"/"+d.alt+"/"}}})});