function ajaxDeleteAction( obj, url, type ){    $.ajax({        type: "GET",        url: url,        success: function(msg){            if( msg == 1 )            {                var trObj =  $( obj.parentNode.parentNode.parentNode.parentNode );                var message = '';                if( !type )                {                    trObj.hide(400);                }            }        }    });    return false;}function ajaxAction( obj, url, type ){    var tdObj = $( obj.parentNode.parentNode.parentNode );    $.ajax({        type: "GET",        url: url,        success: function(msg){            var message = '';            // Ok            if( msg == 1 )            {                var trObj =  $( obj.parentNode.parentNode.parentNode.parentNode );                if( type == "readItem" )                {                    trObj.removeClass( "isNewItem" );                    trObj.find( '.readNew').hide(400);                    message = 'запись помеченна прочитанной';                }                if( !type || type == 'comment' )                {                    if( trObj.find( '#dopMenu .publishLink').length == 0 )                    {                        if( trObj.find( '.publishStatus').html() == "опубликовано" )                        {                            trObj.find( '.publishStatus').html( "не опубликовано" );                            trObj.find( '.publishLink').html("Опубликовать");                            message = 'запись снята с публикации на сайте';                        }                        else                        {                            trObj.find( '.publishStatus').html( "опубликовано" );                            trObj.find( '.publishLink').html("Снять с публикации");                            message = 'запись опубликована на сайте';                        }                    }                        else                    {                        if( trObj.find( '#dopMenu .publishLink' ).html() == "\nОпубликовать на сайте ?" )                        {                            trObj.find( '.publishStatus').html( "опубликован" );                            trObj.find( '#dopMenu .publishLink' ).html("\nСнять с публикации ?");                            message = 'запись опубликована на сайте';                        }                            else                        {                            trObj.find( '.publishStatus').html( "не опубликован" );                            trObj.find( '#dopMenu .publishLink' ).html("\nОпубликовать на сайте ?");                            message = 'запись снята с публикации на сайте';                        }                    }                }                if( type == 'comment' )                {                    if( trObj.hasClass("publish") )                    {                        trObj.removeClass( "publish" );                    }                         else                    {                        trObj.addClass( "publish" );                    }                }            }            // Error min images            if( msg == 3 )            {                message = "Для публикации необходимо добавить минимум 1 картинку";            }            if( message )            {                $( obj.parentNode.parentNode.parentNode ).append( '<div class="ajaxError">'+message+'</div>' );                setTimeout( '$(".ajaxError").hide(400)', 4000 );            }        }    });    return false;}function reloadBanner(){    if( $(".BannerBlock").length >0 )    {        var rand = Math.floor(Math.random() * (999999 - 100000 + 1)) + 100000;        $(".BannerBlock").load( "http://world-travel.uz/site/reloadBanner/"+rand );    }} $(document).ready(function() {     if( $(".BannerBlock").length>0 )     {        setInterval( reloadBanner, 4500 );     }     // Форма подбора тура и отеля     if( $("#FTHeader").length >0 )     {         $( "#FTHeader a").click( function()         {            var active = $( "#findTour .FTFActive" );            var newBlockId = this.id + 'Tab';            if( newBlockId != active.attr("id" ) )            {                $( "#FTHeader .FTActive" ).removeClass( "FTActive" );                $( this ).addClass( "FTActive" );                $( "#FTHeader font").removeClass();                $( "#FTHeader font").addClass( this.id + 'Separ' )                active.hide( 200, null, function()                {                    $( this ).removeClass( "FTFActive" );                    $( '#'+newBlockId).addClass( "FTFActive" );                    $( '#'+newBlockId).show();                });            }             return false;         })     }     if( $(".commentHref").length > 0 )     {         $(".commentHref").click( function()         {             var oldDiv = $( this.parentNode.parentNode ).find(".commentLText");             var newDiv = $( this.parentNode.parentNode ).find(".commentText");             if( newDiv.css("display") == "none" )             {                 oldDiv.animate( {opacity:0}, 200, function()                 {                     $( this ).hide();                     var newDiv = $( this.parentNode).find(".commentText");                     var oldHeight = $( this ).css("height");                     newDiv.css( "height", "auto" );                     var newHeight = newDiv.css("height");                     newDiv.css( "height", oldHeight );                     newDiv.show();                     newDiv.css("opacity", 0);                     newDiv.animate( {opacity:1,height:newHeight}, 200 )                 })             }                else             {                 var oldHeight = oldDiv.css("height");                 newDiv.animate( {height:oldHeight}, 200, function()                 {                     $( this ).animate( {opacity:0}, 100, function()                     {                         $( this).hide();                         var oldDiv = $( this.parentNode).find(".commentLText");                         oldDiv.css("opacity", 1);                         oldDiv.show();                     })                 })             }             return false;         })     }     if( $(".openDisplay").length >0 )     {         $(".openDisplay").click( function()         {             var div = $('#'+this.id+'_display');             if( div.css("display") == 'none' )div.show(400);                                          else div.hide(400);             return false;         })     }    // Выезжающие страницы     if( $(".dopMenuPages").length >0 )     {         $(".dopMenuPages").click( function ()         {             var activePage = $(".activePage");             var widthPage = $(".activePage").css("width");             var heightActivePage = $(".activePage").css("height");             var selectPage = $("#" + this.id + "_page" );             var heightSelectPage = $("#" + this.id + "_page" ).css("height");             if( selectPage.length>0 )             {                 if( activePage.length>0 && activePage.attr("id") != selectPage.attr("id") )                 {                     $(".activeDM").removeClass("activeDM");                     $( this).addClass( "activeDM" );                     var newWidth = parseInt( widthPage ) + 700;                     selectPage.css("width", widthPage);                     selectPage.css( "height", heightActivePage );                     activePage.css("width", widthPage);                     // определяем направление движение в зависимости от индексов страниц                     selectIndex = $(".pageTab").index( selectPage[0] );                     activeIndex = $(".pageTab").index( activePage[0] );                     if( selectIndex < activeIndex )                     {                         var activeZnak = "-";                         var selectZnak = "";                     }                        else                     {                         var activeZnak = "";                         var selectZnak = "-";                     }                     activePage.animate({'margin-left':activeZnak+newWidth+'px',opacity: 0}, 500, null, function()                     {                         $( this ).hide();                         $( this ).css("position", "static");                         $( this ).removeClass( "activePage" );                     });                     selectPage.css("position", "absolute");                     selectPage.css("margin-left", selectZnak+widthPage );                     selectPage.css("opacity", 0 );                     selectPage.show();                     selectPage.animate({'margin-left':'0px',opacity: 1}, 500, null, function()                     {                         $( this ).css("position", "static");                         $( this ).addClass( "activePage" );                         $( this ).animate( {'height':heightSelectPage}, 400, null, function()                         {                             $( this ).css("height", "auto");                         });                     });                 }             }             return false;         })     }     if( $(".openDisplayNone").length>0 )     {         $(".openDisplayNone").click( function ()         {             var obj = $( this.parentNode.parentNode).find(".displayNone");             if( obj.css("display") == 'none' )obj.show(200);                                          else obj.hide(200);             return false;         })     }     if( $(".itemAction .popup").length >0 )     {        $(".PDel").click( function()        {            $( this.parentNode).find(".popup").show( 200 );            return false;        })         $(".PCancel").click( function()         {             $( this.parentNode).hide( 200 );             return false;         })     }     var selectedCity=0;     if( $(".field_city_id").length>0 )     {         if( $(".field_city_id option:selected").length >1 )         {             selectedCity = $(".field_city_id option:selected")[1].value;         }         $(".field_city_id option").remove();         $(".field_city_id").append( $('<option value="">выберите страну</option>') );     }     var fieldCountry = $(".field_country_id");     if( fieldCountry.length>0 )     {         fieldCountry.change( function ()         {             var parentTable = $( this.parentNode.parentNode.parentNode);             parentTable.find(".field_city_id option").remove();             parentTable.find(".field_city_id").append( $('<option value="">загрузка...</option>') );             parentTable.find(".field_city_id").load( "/catalog/default/ajaxGetList",                 {                     catalog : "catalog_city",                     field   : "country_id",                     id      : $( this).val()                 }                 , function ()                 {                     if( $( this).find("option").length ==0 )                     {                         $( this ).append( $('<option value="">список пуст</option>') );                     }                 });         })         // РЎРѕР±С‹С‚РёСЏ РєРѕРіРґР° РїСЂРё Р·Р°РіСЂСѓР·РєРё СЃС‚СЂС‚Р°РЅРёС†С‹ РјР°СЂРєР° СѓР¶Рµ СѓРєР°Р·Р°РЅР° Р° РјРѕРґРµР»СЊ РЅРµС‚         for( var i=0;i<fieldCountry.length;i++ )         {             if( fieldCountry[i].value >0 )             {                 var parentTable = $( fieldCountry[i].parentNode.parentNode.parentNode );                 parentTable.find(".field_city_id").load( "/catalog/default/ajaxGetList",                     {                         catalog : "catalog_city",                         field   : "country_id",                         id      : fieldCountry[i].value                     }                     , function ()                     {                         if( $( this.parentNode.parentNode.parentNode ).find(".field_city_id").find("option").length ==0 )                         {                             $( this.parentNode.parentNode.parentNode).find(".field_city_id").append( $('<option value="">выберите страну</option>') );                         }                         else                         {                             if( selectedCity > 0 )                                 $(".field_city_id [value='"+selectedCity+"']").attr("selected", "selected");                         }                     });             }         }     }     if( $( ".OrderRequest").length >0 )     {         $( ".OrderRequest").click( function()         {             var obj = $( this.parentNode.parentNode).find("#orderInfo");             obj.css("top", (($(window).height() - obj.outerHeight()) / 2) + $(window).scrollTop() + "px");             obj.css("left", (($(window).width() - obj.outerWidth()) / 2) + $(window).scrollLeft() + "px");             if( obj.css( "display" ) == "none" )obj.show(500, "", function()                     {                         if( $( ".overflowBackground").length == 0 )                         {                            $( "body").prepend("<div class=\"overflowBackground\"></li>");                            $( ".overflowBackground").click( function ()                            {                                $( "#orderInfo").hide(200);                                $( this).hide();                            })                         }                         $( ".overflowBackground").show(200);                     });                else obj.hide(500);             return false;         })         if( $(".orderClose").length >0 )         {             $(".orderClose").click( function()             {                 $( "#orderInfo").hide(200);                 $( ".overflowBackground").hide(100);                 return false;             })         }     }     $(window).scroll(function() {         var top = $(document).scrollTop();         if (top > 215) $('#Menu').addClass('fixed'); //200 - это значение высоты прокрутки страницы для добавления класс            else $('#Menu').removeClass('fixed');         if (top > 150) $('.MInnerPage #Menu').addClass('fixed'); //200 - это значение высоты прокрутки страницы для добавления класс             else $('.MInnerPage #Menu').removeClass('fixed');     });     if( $( ".ITextHref").length >0 )     {         $( ".ITextHref").click( function()         {             var obj = $( this.parentNode.parentNode).find("#ITText");             if( obj.hasClass("ITSmallText") )             {                 obj.removeClass("ITSmallText");                 $( this).text( "закрыть" );             }                                         else             {                 obj.addClass("ITSmallText");                 $( this).text( "подробнее.." );             }             return false;         })     }/* old functions */	if( $("#setions").length>0 )	{		var listSection = $("#setions div");		for( var i=0;i<listSection.length;i++ )		{			listSection[i].onmouseover = function ()				{					$("#setions div").removeClass("SISelect");					this.className = "SItems SISelect";				}			listSection[i].onmouseout = function ()				{					this.className = "SItems";				}						}	}})function MenuActions( idParentDiv ){	var aListElements = document.getElementById( idParentDiv ).getElementsByTagName("a");	for( var m=0;m < aListElements.length; m++ )	{		if( aListElements[m].className == "MenuJsClass" )		{			aListElements[m].onmouseover = function ()				{					var hintDiv = document.getElementById( 'b'+this.id );					hintDiv.style.display = "block";				}			aListElements[m].onmouseout = function ()				{					var hintDiv = document.getElementById( 'b'+this.id );					hintDiv.style.display = "none";				}						}	}	var divListElements = document.getElementById( idParentDiv ).getElementsByTagName("div");			for( var m=0;m < divListElements.length-1; m++ )	{		if( divListElements[m].className == "CHint" )		{			divListElements[m].onmouseover = function ()				{					this.style.display = "block";				}							divListElements[m].onmouseout = function ()				{					this.style.display = "none";				}						}	}	}function LeftMenuActions( idParentDiv ){	var aListElements = document.getElementById( idParentDiv ).getElementsByTagName("li");	for( var m=0;m < aListElements.length; m++ )	{		if( aListElements[m].parentNode.parentNode.id == "RMenu" )		{			aListElements[m].onmouseover = function ()				{					this.className = "select";				}			aListElements[m].onmouseout = function ()				{					this.className = "";				}		}	}}function displayOrNone( id, form, haveActive ){	var obj = document.getElementById( id );	if( haveActive && dON_actve && obj!=dON_actve )dON_actve.style.display='none';	if( obj.style.display == 'none' || obj.style.display == '' )obj.style.display='block';			else		{			obj.style.display='none';			if( form )document.getElementById( form ).reset( );		}	if( haveActive )dON_actve = obj;		return false;}function jqDisplayOrNone( id, form, haveActive ){	var obj = $( '#'+id );	var heightObj = obj.css('height');		if( obj.css( 'display' ) == 'none' )	{		obj.css( 'height', '0' );		obj.show();		obj.animate( {height: heightObj}, 400 );	}		else	{		obj.animate( {height: 0}, 400, 0, function ()			{				obj.css( 'height', heightObj );				obj.hide();							}		);		}		return false;	}var activObj, timer;function setActionForMenu( tagName ){	var aTag, divTag;	var listDiv = document.getElementById("obj").getElementsByTagName( "td" );	for( var i=0;i<listDiv.length;i++ )	{		if( listDiv[i].className == "col02" )		{			aTag = listDiv[i].getElementsByTagName( "a" );			if(aTag[0])			{				aTag[0].onmouseover = function ()				 {					var obj = document.getElementById( this.id+'_popup' );					if( timer ) clearTimeout( timer );					if( activObj && activObj!=obj )activObj.style.display = 'none';					obj.style.display = 'block';					activObj = obj;				 }				aTag[0].onmouseout = function ()				 {					timer = setTimeout( 'hideObj()', 100);				 }				divTag = listDiv[i].getElementsByTagName( "div" );				divTag[0].onmouseover = function ()				 {					if( timer ) clearTimeout( timer );				 }				divTag[0].onmouseout = function ()				 {					timer = setTimeout( 'hideObj()', 100);				 }				}		}	}}function hideObj(){	activObj.style.display='none';}function new_window(url,width,height){window.open(url,'_blank','toolbar=0,location=0,directories=0,status=1,menubar=0,scrollbars=yes,resizable=yes,width='+width+',height='+height+',top='+(window.screen.height/2 - height/2)+',left='+(window.screen.width/2 - width/2)); return false;}function comentTabs( id, aObj ){	var listTabs = aObj.parentNode.getElementsByTagName( "a" );	for( var i=0;i<listTabs.length;i++ )		listTabs[i].className = "";		aObj.className = "activeTab";		if( id=='faceBook' )	{		document.getElementById( 'faceBook' ).className = '';		document.getElementById( 'vkontakte' ).className = 'display_none';			}		else	{		document.getElementById( 'vkontakte' ).className = '';		document.getElementById( 'faceBook' ).className = 'display_none';			}		return false;}