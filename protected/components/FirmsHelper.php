<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Igor
 * Date: 20.01.14
 * Time: 15:54
 * To change this template use File | Settings | File Templates.
 */

class FirmsHelper
{
    static public function getBannerByCategory( $position, $firmId )
    {
        $cout = "";
        $DBParams = DBQueryParamsClass::CreateParams()
            ->setConditions( "position_id=:position_id AND firm_id=:firmId AND active=1" )
            ->setParams( array( ":position_id"=>$position, ":firmId"=>$firmId ))
            ->setOrderBy( "col" )
            ->setLimit( 1 )
            ->setCache(0);

        $bannerArray = CatalogFirmsBanners::fetchAll( $DBParams );
        if( sizeof( $bannerArray ) > 0 && $bannerArray[0]->file )
        {
            $banner = $bannerArray[0];
            $banner->col = $banner->col + 1;
            if( !$banner->save() )print_r( $banner->getErrors() );

            $cout = '<div class="banerBlock">';
            if( $banner->type_id->id==1 )
            {
                if( $banner->link )$cout .= '<a href="'.$banner->link.'" title="">';
                $cout .= '<img src="'.$banner->file.'" alt="" />';
                if( $banner->link )$cout .= '</a>';
            }
                else
            {
                $width = ( $banner->width ) ? ' width="'.$banner->width.'"' : ' width="800"';
                $height = ( $banner->height ) ? ' height="'.$banner->height.'"' : ' height="90"';
                $cout .= '<br/><a href="'.$banner->href.'" title="">
                            <object '.$width .' '. $height .' classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000">
                               <param value="'.$banner->image.'" name="movie"/>
                               <embed '.$width .' '. $height .' src="'.$banner->file.'" type="application/x-shockwave-flash"/>
                            </object>
                        </a>';
            }
            $cout .= '</div>';
        }

        return $cout;
    }
}