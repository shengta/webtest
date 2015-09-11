



	var checkMobile = false;
	var isIndex = true;

$(document).ready(function(){

  checkMobile =isMobile.any();
   
   setBanner();
   
   
   setResize();
	if(!checkMobile){
		setFloatAd();
	}
	get_banner();
	
	$("#cardBtn").hover(function() {
		$(this).attr("src","imgs/wallpaper/buycard-hover.png");
			}, function() {
		$(this).attr("src","imgs/wallpaper/buycard.png");
	});
	$("#appBtn").hover(function() {
		$(this).attr("src","imgs/wallpaper/app-hover.png");
			}, function() {
		$(this).attr("src","imgs/wallpaper/app.png");
	});
	$("#playBtn").hover(function() {
		$(this).attr("src","imgs/wallpaper/googleplay-hover.png");
			}, function() {
		$(this).attr("src","imgs/wallpaper/googleplay.png");
	});
	$("#apkBtn").hover(function() {
		$(this).attr("src","imgs/wallpaper/apk-hover.png");
			}, function() {
		$(this).attr("src","imgs/wallpaper/apk.png");
	});



});
//-----------------FB------------------------------------
(function(d, s, id) {  var js, fjs = d.getElementsByTagName(s)[0];  if (d.getElementById(id)) return;  js = d.createElement(s); js.id = id;  js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v2.4&appId=529793780434455";  fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));
//-----------------FB------------------------------------					

var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};
/*
$(document).resize(function(){
	setResize();
});
*/
(function($){
  $(window).resize(function(){
    // windowResize();                      
	setResize();
  });         
})(jQuery);


$(window).on("orientationchange",function(){
  
  setResize();
});

function setResize() {
	//console.log("setResize screen.width="+screen.width);
	//var docWidth=$(document).width();
   if (screen.width <= 640) {
		$(".fb-page").css("display","none");
		//$ad.hide();
		//$("#abgne_float_ad").css("display","none");
		
		//$("#banner").css("height","250px");
		//$("#bannerImg").css("height","200px");
   }else{
		$(".fb-page").css("display","block");
		
		
		//$ad.hide();
		//$("#abgne_float_ad").css("display","block");		
		//$("#banner").css("height","250px");
		//$("#bannerImg").css("height","200px");
   }
   $(".fb-page").css("height",$("#news_data").height());
   $("._h7l").css("max-height","800pt");
   $("._h7l").css("height","800pt");
   
   

	mainResize();
}


function setBanner(){

		  $('.banner').slick({
			  dots: true,
			  infinite: true,
			  speed: 400,
			  arrows: false,			  
//			  slidesToShow: 3,
//			  slidesToScroll: 1,
				focusOnSelect: false,
			  centerMode: false,
			  adaptiveHeight: false,
			  autoplay: false,
			  autoplaySpeed:300,
			  adaptiveWidth: true
			
		  });
	  

}
function get_banner(){
	

	
	
  $.ajax({
  type: "POST",
  data: {},
  dataType:"json",
  url: "banner/banner.json"
  }).done(function(msg) {
    
    $.each(msg,function(k,v){
		
		  var html = '';
		  //v.picture="banner/img/a1.jpg";
		  html += "<a  href="+v.link+" target='event'><div id='bannerIma' style='background-image: url("+v.picture+");background-size: cover; height:220px;'></div></a>";
		  //$('#bannerGroup').append(html);
		  
		  
		 $('.banner').slick('slickAdd',html);
    }); 
  });
}


  
function setFloatAd(){
	 $(window).load(function(){
		var $win = $(window),
			$ad = $('#abgne_float_ad').css('opacity', 0).show(),	// 讓廣告區塊變透明且顯示出來
			_width = $ad.width(),
			_height = $ad.height(),
			_diffY = $(window).height()/2, _diffX = 20,	// 距離右及下方邊距
			_moveSpeed = 800;	// 移動的速度
	 
		// 先把 #abgne_float_ad 移動到定點
		$ad.css({
			top: $(document).height(),
			left: $win.width() - _width - _diffX,
			opacity: 1
		});
	 
		// 幫網頁加上 scroll 及 resize 事件
		$win.bind('scroll resize', function(){
			var $this = $(this);
	 
			// 控制 #abgne_float_ad 的移動
			$ad.stop().animate({
				top: $this.scrollTop() + $this.height() - _height - _diffY,
				left: $this.scrollLeft() + $this.width() - _width - _diffX
			}, _moveSpeed);
		}).scroll();	// 觸發一次 scroll()
	 
		// 關閉廣告
		$('#abgne_float_ad .abgne_close_ad').click(function(){
			$ad.hide();
		});
	}); 
}	 

//------ main----------------------------------------------------------------------------
var canvas, stage, exportRoot,logo,ciImage,logox,logoy,ciImagex,ciImagey,logoyy,logoxx,ciImagexx,ciImageyy;

function init() {
	canvas = document.getElementById("canvas");
	images = images||{};

	var manifest = [
		{src:"main/images/gamelogo.png", id:"gamelogo"},
		{src:"main/images/gamelogo_1.png", id:"gamelogo_1"},
		{src:"main/images/mainci.png", id:"mainci"}
	];

	var loader = new createjs.LoadQueue(false);
	loader.addEventListener("fileload", handleFileLoad);
	loader.addEventListener("complete", handleComplete);
	loader.loadManifest(manifest);

}

function handleFileLoad(evt) {
	if (evt.item.type == "image") { images[evt.item.id] = evt.result; }
}

function handleComplete() {
	exportRoot = new lib.main();

	stage = new createjs.Stage(canvas);
	stage.addChild(exportRoot);
	stage.update();

	createjs.Ticker.setFPS(24);
	createjs.Ticker.addEventListener("tick", stage);
	
	mainResize();
	setTimeout(function() { initMoveHandler(); }, 2000);
}
 function initMoveHandler() { 
	stage.addEventListener('stagemousemove', moveHandler); 	
	logo=exportRoot.instance;
	logox=exportRoot.instance.x;
	logoy=627.5 ;//exportRoot.instance.y;
	ciImage=exportRoot.instance_1;
	ciImagex=exportRoot.instance_1.x;
	ciImagey=645.5;//exportRoot.instance_1.y;
	moveHandler();
 }
 function moveHandler() { 
	if(stage.mouseX>0 && stage.mouseY>0 && stage.mouseX<1000 && stage.mouseY<920){
		//var mx= stage.mouseX-500;
		//var my= stage.mouseY-460;
		var mx1= stage.mouseX-213;
		var my1= stage.mouseY-150;
		var mx2= stage.mouseX-675;
		var my2= stage.mouseY-206;
		
		//console.log("stage.mouseX; ="+stage.mouseX+"  exportRoot.instance="+exportRoot.instance.x);
		logoxx = parseInt(logox+mx1*-0.02);
		logoyy = parseInt(logoy+my1*-0.02); 
		ciImagexx = parseInt(ciImagex+mx2*-0.04);
		ciImageyy = parseInt(ciImagey+my2*-0.04);
		//console.log("mx="+mx+" my="+my+" stage.mouseX="+stage.mouseX+"  logo.x="+logo.x+"  logo.y="+logo.y+"  logox="+logox+" logoy="+logoy+" logoyy="+logoyy+" ciImagexx="+ciImagexx); 
		
		//logo.y=351.4;
		//console.log(" exportRoot.x="+exportRoot.x+" exportRoot.y="+exportRoot.y);
		
		createjs.Tween.get(logo).to({x:logoxx}, 200,createjs.Ease.circOut);
		createjs.Tween.get(ciImage).to({y:ciImageyy}, 200,createjs.Ease.circOut);
		createjs.Tween.get(logo).to({y:logoyy}, 200,createjs.Ease.circOut);
		createjs.Tween.get(ciImage).to({x:ciImagexx}, 200,createjs.Ease.circOut);
		
	}
 }
function mainResize(){
   //stage.canvas.width = window.innerWidth;
   //stage.canvas.height = window.innerHeight;    
   var docWidth=0;
   checkMobile =isMobile.any();
   if(checkMobile){
		docWidth= $(window).width();
   }else{
		docWidth=window.innerWidth;//$(document).width();   
   }
   console.log("mainResize  checkMobile="+checkMobile+"  docWidth="+docWidth+" screen.width="+screen.width+" $(window).width()="+$(window).width())
   
   
   var test = (docWidth/1000)*1;
   if(test>1){
	   test=1;
   }
   if(exportRoot){
	exportRoot.scaleX = exportRoot.scaleY = test;   
   }
   
   if(stage){
		stage.canvas.width = 1000*test;
		stage.canvas.height = 920*test;
		
	   console.log("mainResize docWidth="+stage.canvas.width);
	   console.log("mainResize docHeight="+stage.canvas.height);
		
	}
	

	
}


