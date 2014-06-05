<?php

class Widget extends CWidget {

	/**
	 * Looks for the view script file according to the view name.
	 * This method will look for the view under the widget's {@link getViewPath viewPath}.
	 * The view script file is named as "ViewName.php". A localized view file
	 * may be returned if internationalization is needed. See {@link CApplication::findLocalizedFile}
	 * for more details.
	 * Since version 1.0.2, the view name can also refer to a path alias
	 * if it contains dot characters.
	 * @param string $viewName name of the view (without file extension)
	 * @return string the view file path. False if the view file does not exist
	 * @see CApplication::findLocalizedFile
	 */
	public function getViewFile($viewName) {
		if (($renderer = Yii::app()->getViewRenderer()) !== null)
			$extension = $renderer->fileExtension;
		else
			$extension='.php';
				
		$viewFile = Yii::app()->getBasePath() .DIRECTORY_SEPARATOR."components".DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR.$viewName;

		if (is_file($viewFile . $extension))
			return Yii::app()->findLocalizedFile($viewFile . $extension);
		else if ($extension !== '.php' && is_file($viewFile . '.php'))
			return Yii::app()->findLocalizedFile($viewFile . '.php');
		else
			return false;
	}

    public function render($view,$data=null,$return=false, $cache = true)
    {
        $className =  strtolower( get_class($this) );
        $widgetName = isset(Yii::app()->getParams()->widgetList[ $className ])  ? strtolower( $className ) : strtolower( $className."_".$view );

        if(isset(Yii::app()->getParams()->widgetList[$widgetName]) && $cache)$widgetParams = Yii::app()->getParams()->widgetList[ $widgetName ];
                else $widgetParams = array('duration' => 3600, 'cacheID' => 'CDummyCache');

        if(($viewFile=$this->getViewFile($view))!==false)
        {
            if( $this->beginCache($widgetName."_".Yii::app()->getLanguage(), array('duration'=>3600) ) )
            {
                $this->renderFile( $viewFile, $data, $return );
                $this->endCache();
            }
        }
        else
            throw new CException(Yii::t('yii','{widget} cannot find the view "{view}".',
                array('{widget}'=>get_class($this), '{view}'=>$view)));
    }

}