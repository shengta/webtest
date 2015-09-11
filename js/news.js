
//新聞 API 位置設定 
var  apiurl='http://webapi.quizandsprites.kkplay.com.tw/announcement';

//----------------------------------------------------------------------------------

  	var  max=10;
	var  count=0;
	var  newUrl='';
	var  page=0;
	var  pageMax=10;
	var  pageTotal=0;
	var checkMobile = false;
	var  currentPage=1;
	
	
	
	
$(document).ready(function(){
  
	
  
   

	//if(undefined != isIndex){   
	console.log("window.location.pathname="+window.location.pathname);
	if (window.location.pathname  === '/news_list.html') {
		if(!checkMobile){
			max = 10000;
		}else{
			max = 10000;
		}
	}else{
		if(!checkMobile){
			max = 10;
		}else{
			max = 5;
		}
	}
	
        function getUrlParam(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //
            var r = window.location.search.substr(1).match(reg);  //
            if (r != null) return unescape(r[2]); return null; //
        }
		currentPage = getUrlParam('page');
		console.log('currentPage='+currentPage);
		if(currentPage){
			
		}else{
			currentPage=0;
		}
			console.log('currentPage='+currentPage);
	//get_news('http://kkplay.fb2get.com/news/testdata.json');
	get_news(apiurl);

   
});

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
   if (screen.width <= 640) {
   }else{
   }
}

function get_news(url){
	

	
	
  $.ajax({
  type: "POST",
  data: {},
  dataType:"json",
  url: url
  //url: "http://kkplay.fb2get.com/api.php?url="+url
  }).done(function(msg) {
    var html = '';
    $.each(msg,function(k,v){
		  
		  var d = new Date(v.announce_timestamp*1000);
		  var news_date = d.getFullYear()+'-'+(d.getMonth()+1)+'-'+d.getDate();
		  
		 // var MyDateString = ('0' + d.getDate()).slice(-2) + '/' + ('0' + (d.getMonth()+1)).slice(-2) + '/' + d.getFullYear();
			var MyDateString =  d.getFullYear()+ '/' + ('0' + (d.getMonth()+1)).slice(-2) + '/' +('0' + d.getDate()).slice(-2)  ;
	
		if(count%pageMax == 0){
			html += "<div id='page"+page+"'  style='display:none'>";
			console.log("count%pageMax == 000");
		}
		if(count<max){
		  //v.url = '';
		  html += "<li  style='width:100% '>";
		  html += "<a href=javascript:openPopup('"+v.url+"') >" 
		  //html += "<a href='"+v.url+"' class='url' >";
		  //html += "<span class='date' style='width:30%'>"+count+" "+news_date+"</span>  "+v.title+"</a>";
		  html += "  <span class='date' style='width:30%'> "+MyDateString+"</span>  "+v.title+"</a>";
		  html += "</li>";
		  console.log("+++++");
		 }
		if(count%pageMax == 9){
			//html += "</div tt='"+(count%pageMax)+"'>";
			html += "</div tt='46546'>";
			console.log("count%pageMax == 9");
		}
		console.log(count+"  "+html);
		  
		  count=count+1
		  page= parseInt(count/pageMax);
		 
    }); 
	$('#news_data').append(html);
	pageTotal= parseInt(count/pageMax);
	if(currentPage>pageTotal){
		currentPage=pageTotal;
	}
	$("#page"+currentPage).css("display","block");	
	
	if (window.location.pathname  != '/news_list.html') {
		var htmlMore = "<li> <a href='news_list.html' ><span style='width:70%';> </span><span class='newsmore'>  更多消息...</span></a></li> ";
		$('#news_data').append(htmlMore);
	}
	$('.news_con').append("<li><a href='/news_list.php?page=0'><<</a></li>");
	var phtml;
	for(var i=1;i<=pageTotal;i++){
		var p=i-1;
		
		if(p == currentPage){
			phtml = "<li ><a class='active' href='/news_list.php?page="+p+"'>"+i+"</a></li>";
		}else{
			phtml = "<li><a href='/news_list.php?page="+p+"'>"+i+"</a></li>";
		}
		$('.news_con').append(phtml);
	}
	$('.news_con').append("<li><a href='/news_list.php?page="+(pageTotal-1)+"'>>></a></li>");
	
	
	        
	
	
	
	
  });
  
  
  
}
function openPopup(url){
	console.log("openPopup url="+url);
	if(url != 'undefined' && url != undefined && url != null && url != '' && url != "http://kkplay.fb2get.com/undefined"){
		newUrl = url;
		
		$( ".dialog" ).dialog( "option", "closeText", "hide" );
		//alert("checkMobile="+checkMobile)
		if(checkMobile){
			$('#dialog').css('overflow-y', 'scroll');
		}else{
			$('#dialog').css('overflow', 'hidden');
			
		}
		 //
		$('#dialogIFame').attr('src', url)
		 $('#dialogIFame').css('height', $(window).height * 0.9 );
		$( "#dialog" ).dialog( "open" );
		  //$("body").css({ overflow: 'hidden' })
	}
}


 $(function() {
    $( "#dialog" ).dialog({
      autoOpen: false,
	  title: "NEWS",
	  closeText: "CLOSE",
	  width: $(document).width()*0.9,
	  height: $(window).height()*0.9,
	  minHeight: 500,
	  minWidth: 500,
      show: {
        effect: "blind",
        duration: 400
      },
      hide: {
        effect: "blind",
        duration: 400
      }
    });
 
    $( "#opener" ).click(function() {
      $( "#dialog" ).dialog( "open" );
    });
  });

