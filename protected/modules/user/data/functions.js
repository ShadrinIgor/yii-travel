$(document).ready(  function ()
{
    if( $(".countryList").length>0 && $(".cityList").length>0 )
    {
        $(".countryList").change( function()
        {
            $(".cityList").load( "http://yii-news/ajax/site/ListCity/?country="+$(".countryList").val() );
        })
    }
})
