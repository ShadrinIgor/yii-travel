<?php
/**
 * User: Игорь
 * Date: 28.09.12
 * To change this template use File | Settings | File Templates.
 */

class ImageHelper
{
    public $error;
    public $newFileUrl;

    static function getAnimateImageBlock( $item, $link, $title = "" )
    {
        if( !$item->image )$countImages = 4;
            else $countImages = 3;

        $titleValue = !empty( $title ) ? $title : $item->name;
        $listImages = ImageHelper::getImages( $item, $countImages );
        if( sizeof( $listImages ) >0 || $item->image ) : ?>
            <div class="listItemsImages">
                <?php if( $item->image ) : ?><div class="LII_1"><a href="<?= $link ?>" title="<?= $titleValue ?>"><img src="<?= ImageHelper::getImage( $item->image, 2 ) ?>" alt="<?= $titleValue ?>" /></a></div><?php endif; ?>
                <?php
                if( $item->image )$i=2;
                             else $i=1;

                foreach( $listImages as $LItem ) :
                    if( $i == 1 )$imageSize = 2;
                            else $imageSize = 3;
                    ?>
                    <div class="LII_<?= $i ?>">
                        <?php if( $i==1 ) : ?><a href="<?= $link ?>" title="<?= $titleValue ?>"><?php endif; ?>
                        <img src="<?= ImageHelper::getImage( $LItem->image, $imageSize ) ?>" alt="<?= $titleValue ?>" />
                        <?php if( $i==1 ) : ?></a><?php endif; ?>
                    </div>
                    <?php
                    $i++;
                endforeach;
                ?>
            </div>
        <?php endif;
    }

    /*
     * Проверяет сушествование необходимой картинк в нужном размере, если нет то создает
     * @param string $imageFile путь до файла
     * @param int $size размер необходимой картинки ( варинаты : 1, 2, 3 )
     * @param CCModel $itemObject объект текущей записи
     */
    static function getImage( $imageFile, $size = 1, CCModel $itemObject = null  )
    {
        if( empty( $imageFile ) )return false;

        $error = false;
        $size = $size>0 ? (int)$size : 1;
        if( empty( $imageFile ) )$error = true;

        $dirName = dirname( $imageFile );
        $fileName = basename( $imageFile );

        if( $size == 1 )$imageSizeFile = $imageFile;
        else
        {
            if( file_exists( $dirName."/".$size."_".$fileName ) )$imageSizeFile = $dirName."/".$size."_".$fileName;
            else $imageSizeFile = $dirName."/".$fileName;
        }

        return $imageSizeFile;

        // С этим нужно будет разобратся, нужно ли это вообще
        if( $itemObject == null || !property_exists( $itemObject, $field ) )return $imageSizeFile;
        else
        {
            // 1. Проверяем указана ли в катологе уже отптимизированные капии картинки, если да то просто их отдаем
            // 2. Иначе: Проверяем существут ли в действительности файл если дл то
            // создаем 2 картинки меньшего размера и сохраняем их пути в базе для этой записи

            // Если данное свойство у объекта существует и оно не пусто то выдаем его содержимое
            if( $itemObject->$field != "" ) return $itemObject->$field;

            if( !empty( $imageFile ) && !file_exists( $imageFile ) )
            {
                $result = $itemObject->update( array( "image"=>"" ) );
                $error = true;
            }

            if( !$error )
            {
                $tableName = $itemObject->tableName();
                $imageParams = null;
                if( isset( Yii::app()->params["images"][ $tableName ] ) )$imageParams = Yii::app()->params["images"][ $tableName ];
                else $imageParams = Yii::app()->params["images"][ "default" ];

                // Если параметры картинки для данной таблицы не созданно то не проводить оптимизацию
                if( is_array( $imageParams ) && sizeof( $imageParams ) > 0 )
                {
                    /*
                    // Надо проверить еслии вызывается не 1 картнки, а 2 или 3 и её нету
                    // то считаем что адоптации картинкок небыло и запускаем адоптация в цикле( количество равно количесвту свойств этого каталого в конфиге )
                    foreach( $imageParams as $key=>$values )
                    {
                        if( $key!=1 )
                        {
                            $imageName = $key."_".$fileName;
                            $itemProperty =  "image_".$key;
                        }
                            else
                        {
                            $imageName = $fileName;
                            $itemProperty =  "image";
                        }

                        Yii::app()->ih
                            ->load( $_SERVER['DOCUMENT_ROOT'] . "/" . $itemObject->image )
                            ->watermark($_SERVER['DOCUMENT_ROOT'] . Yii::app()->getTheme()->getBaseUrl().'/images/watermark.png', 0, 0, CImageHandler::CORNER_RIGHT_BOTTOM)
                            ->thumb( $values[0], $values[1] )
                            ->save( $_SERVER['DOCUMENT_ROOT'] . "/" . $dirName."/".$imageName );

                        if( is_object( $itemObject ) && property_exists( $itemObject, $propertyName ) )$itemObject->$itemProperty =  $dirName."/".$imageName;
                    }

                    $itemObject->save();
                    return $itemObject->$propertyName;*/
                    return $itemObject->image;
                }
            }
        }

        return Yii::app()->getTheme()->getBaseUrl()."/images/no-image.png";
    }

    static public function getImages( CCModel $itemObject, $limit = 10 )
    {
        if( $itemObject->id >0 )
        {
            $tableName = $itemObject->tableName();
            $queryParams = DBQueryParamsClass::CreateParams()
                ->setConditions( "catalog=:catalog AND item_id=:id" )
                ->setParams( array( ":catalog"=>$tableName, ":id"=>$itemObject->id ) )
                ->setLimit( $limit )
                ->setCache(0);

            return CatGallery::fetchAll( $queryParams );
        }

        return false;
    }

    public function checkFileName($text)
    {
        /*
        $rus=array("а","б","в","г","д","е","ё","ж","з","и","й","к","л","м","н","о","п","р","с","т","у","ф","х","ц","ш","щ","ь","ъ","э","ю","я"," ",".","-","(",")","j","w");
        $eng=array("a","b","v","g","d","e","e","sh","z","i","i","k","l","m","n","o","p","r","s","t","u","f","h","c","sh","sch","","","e","yu","ya","_",".","","(",")","j","w");
        $text=strtolower($text);

        $str="";
        for($n=0;$n<strlen($text);$n++)
        {
            for($i=0;$i<sizeof($rus);$i++)
            {
                if($text[$n]==$rus[$i])
                {
                    $str.=$eng[$i];
                    break;
                }

                if($text[$n]==$eng[$i])
                {
                    $str.=$eng[$i];
                    break;
                }

                if(intval($text[$n]))
                {
                    $str.=$text[$n];
                    break;
                }
            }
        }
*/
        $ar=explode(".",$text);
        $type=$ar[sizeof($ar)-1];

        $rn=rand(1000,99999);
        $str=$rn.".".$type;

        return $str;
    }

    private function optimization( $fileUrl, $img_type="", $upload_type, $dopUrl="", $catalog = "")
    {
        $fileName = basename( $fileUrl );
        $dirPath = $dopUrl.dirname( $fileUrl )."/";

        $typeData = Yii::app()->params["images"][ $img_type ];

        list($width0,$height0)=getimagesize($dopUrl.$fileUrl);
        $wprocent = ceil( ($height0*100)/ $width0 );
        $hprocent = ceil( ($width0*100)/ $height0 );

        $i=0;
        $cout = "";
        for($i=1;$i<=sizeof( $typeData );$i++)
        {
            $width=$typeData[$i]['width'];
            $height=$typeData[$i]['height'];
            if($i==1)
            {
                $new_file_name = $dirPath . $fileName;
                if(!$width&&!$height)list($width,$height)=getimagesize($dopUrl.$fileUrl);
            }
            else
            {
                $new_file_name = $dirPath.$i."_".$fileName;

                if( $width0 == $height )
                {
                    if( !$width && $height )$width=$height;
                    if( $width && !$height )$height=$width;
                }
            }

            // Если указынны оба параметра то высоту обнуляем меньший из параметров
            if( $width>0 && $height>0 )
            {
                if( $width>=$height )$height=0;
                if( $width<$height )$width=0;
            }

            // Если не указан один из параметров, то недостоющий расщитываем
            if( !$width && $height )$width= ceil( ($height*$hprocent)/100 );
            if( $width && !$height )$height= ceil( ($width*$wprocent)/100 );

            // Проверяем чтобы указынне параметры небыли больше чем заданы для данного типа картинки
            if( $width > $width0 )$width = $width0;
            if( $height > $height0 )$height = $height0;

            if( $width&&$height )
            {
                switch( $upload_type )
                {
                    case "jpg" :$image_o=imagecreatefromjpeg($dopUrl.$fileUrl);break;
                    case "image/jpg" :$image_o=imagecreatefromjpeg($dopUrl.$fileUrl);break;

                    case "jpeg":$image_o=imagecreatefromjpeg($dopUrl.$fileUrl);break;
                    case "image/jpeg":$image_o=imagecreatefromjpeg($dopUrl.$fileUrl);break;
                    case "image/pjpeg":$image_o=imagecreatefromjpeg($dopUrl.$fileUrl);break;

                    case "gif" :$image_o=imagecreatefromgif($dopUrl.$fileUrl);break;
                    case "image/gif" :$image_o=imagecreatefromgif($dopUrl.$fileUrl);break;

                    case "png" :$image_o=imagecreatefrompng($dopUrl.$fileUrl);break;
                    case "image/png" :$image_o=imagecreatefrompng($dopUrl.$fileUrl);break;
                }

                list($width_o,$height_o)=getimagesize($dopUrl.$fileUrl);

                $new_file=imagecreatetruecolor($width,$height);

                $res=imagecopyresampled($new_file,$image_o,0,0,0,0,$width,$height,$width_o,$height_o);

                if($res===True)
                    switch( $upload_type )
                    {
                        case "jpeg":ImageJPEG($new_file,$new_file_name, Yii::app()->params["images_quality"]);break;
                        case "image/jpeg":ImageJPEG($new_file,$new_file_name, Yii::app()->params["images_quality"]);break;
                        case "image/pjpeg":ImageJPEG($new_file,$new_file_name, Yii::app()->params["images_quality"]);break;

                        case "jpg":ImageJPEG($new_file,$new_file_name, Yii::app()->params["images_quality"]);break;
                        case "image/jpg":ImageJPEG($new_file,$new_file_name, Yii::app()->params["images_quality"]);break;

                        case "gif":ImageGIF($new_file,$new_file_name);break;
                        case "image/gif":ImageGIF($new_file,$new_file_name);break;

                        case "png":ImagePNG($new_file,$new_file_name);break;
                        case "image/png":ImagePNG($new_file,$new_file_name);break;
                    }
                else
                    $cout ="<p class=\"err\">Произошла ошибка обработки файла (".$new_file_name.")</p>";

                #Наложение логотипа на картинки
                if( SiteHelper::getConfig( "watermark" ) )$this->addLogoOnImage( $dopUrl.$fileUrl, $upload_type, $dopUrl.SiteHelper::getConfig( "watermark" ), $catalog );
            }
        }
        return $cout;
    }

    public function uploadFile( CCModel $model, $field, $catalog, $is_image=true, $img_type="default", $dopUrl="" )
    {
        $error="";
        $fileUrl="";
        if(is_uploaded_file($_FILES[ $catalog ]['tmp_name'][ $field ]))
        {
            if($model->id)
            {
                $imageName = basename( $model->field );

                @unlink("../../". dirname( $model->field )."/".$imageName);
                @unlink("../../". dirname( $model->field )."/2_".$imageName);
                @unlink("../../". dirname( $model->field )."/3_".$imageName);
            }

            if( $is_image &&  strpos($_FILES[ $catalog ]['type'][ $field ],"image")===False )$error="Не правельный тип закачиваемого файла";

            if(!$error)
            {
                $new_name = $this->checkFileName( $_FILES[ $catalog ]['name'][ $field ] );
                $s_table = $model->tableName();

                // Каталог
                $fileUrl = "f/".$s_table;
                if( $res = @mkdir( $dopUrl.$fileUrl ) )
                {
                    chmod( $dopUrl.$fileUrl, 0777);
                }

                // Год
                $fileUrl .= "/".date("Y");
                if( $res = @mkdir( $dopUrl.$fileUrl ) )
                {
                    chmod( $dopUrl.$fileUrl, 0777);
                }

                // Месяц
                $fileUrl .= "/".date("m");
                if( $res = @mkdir( $dopUrl.$fileUrl ) )
                {
                    chmod( $dopUrl.$fileUrl, 0777);
                }

                // День
                $fileUrl .= "/".date("d");
                if( $res = @mkdir( $dopUrl.$fileUrl ) )
                {
                    chmod( $dopUrl.$fileUrl, 0777);
                }

                if( $model->id )
                {
                    $fileUrl .= "/".$model->id;
                    if( $res = @mkdir( $dopUrl.$fileUrl ) )
                    {
                        chmod($dopUrl.$fileUrl, 0777);
                    }
                }

                $fileUrl .= "/".$new_name;
                $this->newFileUrl = $fileUrl;

                $res=move_uploaded_file( $_FILES[ $catalog ]['tmp_name'][ $field ], $dopUrl.$fileUrl );
                if( $res===False )$error="Произошла ошибка закачивания файла|".$_FILES[ $catalog ]['error'][ $field ];
            }

            if( $is_image==1 && !$error && $img_type && $_FILES[ $catalog ]['tmp_name'][ $field ] )
            {
                $fileType = $_FILES[ $catalog ]['type'][ $field ];
                if( $catalog != "ExBanner" && ( mb_stripos( $fileType, "jpg" ) !== false || mb_stripos( $fileType, "jpeg" ) !== false ) )
                {
                    $this->optimization( $fileUrl, $img_type, $fileType, "", $catalog );
                }
            }
        }


        if( !empty( $error ) )
            $this->error = $error;

        return !empty( $error ) ? false : true ;
    }

    static public function deleteFile( CCModel &$model, $field )
    {
        if( $model->$field )
        {
            $image = $model->$field;
            $model->$field = "";

            $file = basename( $image );
            $dir = dirname( $image );
            @unlink( $dir."/".$file );
            @unlink( $dir."/2_".$file );
            @unlink( $dir."/3_".$file );
        }
    }

    /*
     * Проверяет на наличие ошибок, анализируется масив $_FILES
     */
    static public function checkError( $ftype, $fsize=0, $ferror="", $type = array(), $size = 0 )
    {
        $error = "";
        if( !$ftype || !$fsize )$error = "Произошла ошибка закачивания";
        if( !$error && $ferror )$error = "Произошла ошибка закачивания";
        if( !$error && $fsize>$size )$error = "Превышен размер загружаемого файла";

        $ftypeAr = explode( "/", $ftype );
        if( empty( $ftypeAr[1] ) || !in_array( $ftypeAr[1], $type ) )
        {
            echo "$";
            $error="Выбран не верный тип файла";
        }
        if( !empty( $error ) )return $error;
    }

    /*
     * Накладываем водяной знак
     */
    function addLogoOnImage( $tempImage, $imgType, $logo, $catalog = "" )
    {
        if( $catalog == "ExBanner" )return;

        switch( $imgType )
        {
            case "jpeg":$srcImage = ImageCreateFromJPEG($tempImage);break;
            case "image/jpeg":$srcImage = ImageCreateFromJPEG($tempImage);break;
            case "image/pjpeg":$srcImage = ImageCreateFromJPEG($tempImage);break;

            case "jpg":$srcImage = ImageCreateFromJPEG($tempImage);break;
            case "image/jpg":$srcImage = ImageCreateFromJPEG($tempImage);break;

            case "gif":$srcImage = ImageCreateFromGIF($tempImage);break;
            case "image/gif":$srcImage = ImageCreateFromGIF($tempImage);break;

            case "png":$srcImage = ImageCreateFromPNG($tempImage);break;
            case "image/png":$srcImage = ImageCreateFromPNG($tempImage);break;
            default:return -1;break;
        }

        $logoImage = imagecreatefrompng( $logo );

        $srcWidth  = ImageSX($srcImage);
        $srcHeight = ImageSY($srcImage);

        $logoWidth  = ImageSX($logoImage);
        $logoHeight = ImageSY($logoImage);

        $newLogoWeight = $logoWidth;
        $newlogoHeightt = $logoHeight;

        if( $logoWidth>$srcWidth )
        {
            $newLogoWeight = $srcWidth;
            $pr = (100*$srcWidth)/$logoWidth;
            $newlogoHeightt = ($logoHeight*$pr)/100;
        }

        $res = imagecopyresized($srcImage, $logoImage, 0, $srcHeight - $newlogoHeightt, 0, 0, $newLogoWeight, $newlogoHeightt, $logoWidth, $logoHeight);

        unlink($tempImage);

        switch( $imgType )
        {
            case "jpeg":ImageJPEG($srcImage, $tempImage, 100);break;
            case "image/jpeg":ImageJPEG($srcImage, $tempImage, 100);break;
            case "image/pjpeg":ImageJPEG($srcImage, $tempImage, 100);break;

            case "jpg":ImageJPEG($srcImage, $tempImage, 100);break;
            case "image/jpg":ImageJPEG($srcImage, $tempImage, 100);break;

            case "gif":ImageGIF($srcImage, $tempImage);break;
            case "image/gif":ImageGIF($srcImage, $tempImage);break;

            case "png":ImagePNG($srcImage, $tempImage);break;
            case "image/png":ImagePNG($srcImage, $tempImage);break;
        }

        ImageDestroy($srcImage);
    }

}