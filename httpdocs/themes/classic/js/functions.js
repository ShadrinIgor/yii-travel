 $(document).ready(function() {     if( $(".openDisplayNone").length>0 )     {         $(".openDisplayNone").click( function ()         {             var obj = $( this.parentNode.parentNode).find(".displayNone");             if( obj.css("display") == 'none' )obj.show(200);                                          else obj.hide(200);             return false;         })     }     tinyMCE.init({         mode : "textareas",         theme : "simple"         });     if( $(".itemAction .popup").length >0 )     {        $(".PDel").click( function()        {            $( this.parentNode).find(".popup").show( 200 );            return false;        })         $(".PCancel").click( function()         {             $( this.parentNode).hide( 200 );             return false;         })     }     var selectedCity=0;     if( $(".field_city_id").length>0 )     {         if( $(".field_city_id option:selected").length >0 )         {             selectedCity = $(".field_city_id option:selected").val();         }         $(".field_city_id option").remove();         $(".field_city_id").append( $('<option value="">выберите страну</option>') );     }     var fieldCountry = $(".field_country_id");     if( fieldCountry.length>0 )     {         fieldCountry.change( function ()         {             var parentTable = $( this.parentNode.parentNode.parentNode);             parentTable.find(".field_city_id option").remove();             parentTable.find(".field_city_id").append( $('<option value="">загрузка...</option>') );             parentTable.find(".field_city_id").load( "/catalog/default/ajaxGetList",                 {                     catalog : "catalog_city",                     field   : "country_id",                     id      : $( this).val()                 }                 , function ()                 {                     if( $( this).find("option").length ==0 )                     {                         $( this ).append( $('<option value="">список пуст</option>') );                     }                 });         })         // РЎРѕР±С‹С‚РёСЏ РєРѕРіРґР° РїСЂРё Р·Р°РіСЂСѓР·РєРё СЃС‚СЂС‚Р°РЅРёС†С‹ РјР°СЂРєР° СѓР¶Рµ СѓРєР°Р·Р°РЅР° Р° РјРѕРґРµР»СЊ РЅРµС‚         for( var i=0;i<fieldCountry.length;i++ )         {             if( fieldCountry[i].value >0 )             {                 var parentTable = $( fieldCountry[i].parentNode.parentNode.parentNode );                 parentTable.find(".field_city_id").load( "/catalog/default/ajaxGetList",                     {                         catalog : "catalog_city",                         field   : "country_id",                         id      : fieldCountry[i].value                     }                     , function ()                     {                         if( $( this.parentNode.parentNode.parentNode ).find(".field_city_id").find("option").length ==0 )                         {                             $( this.parentNode.parentNode.parentNode).find(".field_city_id").append( $('<option value="">выберите страну</option>') );                         }                         else                         {                             if( selectedCity > 0 )                                 $(".field_city_id [value='"+selectedCity+"']").attr("selected", "selected");                         }                     });             }         }     }     if( $( ".OrderRequest").length >0 )     {         $( ".OrderRequest").click( function()         {             var obj = $( this.parentNode.parentNode).find("#orderInfo");             obj.css("top", (($(window).height() - obj.outerHeight()) / 2) + $(window).scrollTop() + "px");             obj.css("left", (($(window).width() - obj.outerWidth()) / 2) + $(window).scrollLeft() + "px");             if( obj.css( "display" ) == "none" )obj.show(500, "", function()                     {                         if( $( ".overflowBackground").length == 0 )                         {                            $( "body").prepend("<div class=\"overflowBackground\"></li>");                            $( ".overflowBackground").click( function ()                            {                                $( "#orderInfo").hide(200);                                $( this).hide();                            })                         }                         $( ".overflowBackground").show(200);                     });                else obj.hide(500);             return false;         })         if( $(".orderClose").length >0 )         {             $(".orderClose").click( function()             {                 $( "#orderInfo").hide(200);                 $( ".overflowBackground").hide(100);                 return false;             })         }     }     $(window).scroll(function() {         var top = $(document).scrollTop();         if (top > 215) $('#Menu').addClass('fixed'); //200 - это значение высоты прокрутки страницы для добавления класс            else $('#Menu').removeClass('fixed');         if (top > 150) $('.MInnerPage #Menu').addClass('fixed'); //200 - это значение высоты прокрутки страницы для добавления класс             else $('.MInnerPage #Menu').removeClass('fixed');     });     if( $( ".ITextHref").length >0 )     {         $( ".ITextHref").click( function()         {             var obj = $( this.parentNode.parentNode).find("#ITText");             if( obj.hasClass("ITSmallText") )             {                 obj.removeClass("ITSmallText");                 $( this).text( "закрыть" );             }                                         else             {                 obj.addClass("ITSmallText");                 $( this).text( "подробнее.." );             }             return false;         })     }/* old functions */	if( $("#setions").length>0 )	{		var listSection = $("#setions div");		for( var i=0;i<listSection.length;i++ )		{			listSection[i].onmouseover = function ()				{					$("#setions div").removeClass("SISelect");					this.className = "SItems SISelect";				}			listSection[i].onmouseout = function ()				{					this.className = "SItems";				}						}	}})function MenuActions( idParentDiv ){	var aListElements = document.getElementById( idParentDiv ).getElementsByTagName("a");	for( var m=0;m < aListElements.length; m++ )	{		if( aListElements[m].className == "MenuJsClass" )		{			aListElements[m].onmouseover = function ()				{					var hintDiv = document.getElementById( 'b'+this.id );					hintDiv.style.display = "block";				}			aListElements[m].onmouseout = function ()				{					var hintDiv = document.getElementById( 'b'+this.id );					hintDiv.style.display = "none";				}						}	}	var divListElements = document.getElementById( idParentDiv ).getElementsByTagName("div");			for( var m=0;m < divListElements.length-1; m++ )	{		if( divListElements[m].className == "CHint" )		{			divListElements[m].onmouseover = function ()				{					this.style.display = "block";				}							divListElements[m].onmouseout = function ()				{					this.style.display = "none";				}						}	}	}function LeftMenuActions( idParentDiv ){	var aListElements = document.getElementById( idParentDiv ).getElementsByTagName("li");	for( var m=0;m < aListElements.length; m++ )	{		if( aListElements[m].parentNode.parentNode.id == "RMenu" )		{			aListElements[m].onmouseover = function ()				{					this.className = "select";				}			aListElements[m].onmouseout = function ()				{					this.className = "";				}		}	}}function displayOrNone( id, form, haveActive ){	var obj = document.getElementById( id );	if( haveActive && dON_actve && obj!=dON_actve )dON_actve.style.display='none';	if( obj.style.display == 'none' || obj.style.display == '' )obj.style.display='block';			else		{			obj.style.display='none';			if( form )document.getElementById( form ).reset( );		}	if( haveActive )dON_actve = obj;		return false;}function jqDisplayOrNone( id, form, haveActive ){	var obj = $( '#'+id );	var heightObj = obj.css('height');		if( obj.css( 'display' ) == 'none' )	{		obj.css( 'height', '0' );		obj.show();		obj.animate( {height: heightObj}, 400 );	}		else	{		obj.animate( {height: 0}, 400, 0, function ()			{				obj.css( 'height', heightObj );				obj.hide();							}		);		}		return false;	}var activObj, timer;function setActionForMenu( tagName ){	var aTag, divTag;	var listDiv = document.getElementById("obj").getElementsByTagName( "td" );	for( var i=0;i<listDiv.length;i++ )	{		if( listDiv[i].className == "col02" )		{			aTag = listDiv[i].getElementsByTagName( "a" );			if(aTag[0])			{				aTag[0].onmouseover = function ()				 {					var obj = document.getElementById( this.id+'_popup' );					if( timer ) clearTimeout( timer );					if( activObj && activObj!=obj )activObj.style.display = 'none';					obj.style.display = 'block';					activObj = obj;				 }				aTag[0].onmouseout = function ()				 {					timer = setTimeout( 'hideObj()', 100);				 }				divTag = listDiv[i].getElementsByTagName( "div" );				divTag[0].onmouseover = function ()				 {					if( timer ) clearTimeout( timer );				 }				divTag[0].onmouseout = function ()				 {					timer = setTimeout( 'hideObj()', 100);				 }				}		}	}}function hideObj(){	activObj.style.display='none';}function new_window(url,width,height){window.open(url,'_blank','toolbar=0,location=0,directories=0,status=1,menubar=0,scrollbars=yes,resizable=yes,width='+width+',height='+height+',top='+(window.screen.height/2 - height/2)+',left='+(window.screen.width/2 - width/2)); return false;}function comentTabs( id, aObj ){	var listTabs = aObj.parentNode.getElementsByTagName( "a" );	for( var i=0;i<listTabs.length;i++ )		listTabs[i].className = "";		aObj.className = "activeTab";		if( id=='faceBook' )	{		document.getElementById( 'faceBook' ).className = '';		document.getElementById( 'vkontakte' ).className = 'display_none';			}		else	{		document.getElementById( 'vkontakte' ).className = '';		document.getElementById( 'faceBook' ).className = 'display_none';			}		return false;}