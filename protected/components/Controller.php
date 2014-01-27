<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    public function init()
    {
        parent::init();

        if ( !empty($_GET['language'] ))
            Yii::app()->language = $_GET['language'];
    }

    public function filters()
    {
        return array(
            array(
                'application.filters.YXssFilter',
                'clean'   => '*',
                'tags'    => 'strict',
                'actions' => 'all'
            )
        );
    }

	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();

    public $listJsFiles=array();
    public $listCssFiles=array();

	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

    public function render($view,$data=array(),$return=false)
    {
        if($this->beforeRender($view))
        {
            $data = array_merge( $data,
                array(
                    "Theme"     => Yii::app()->getTheme(),
                    "controller" => $this,
                )
            );

            $output=$this->renderPartial($view,$data,true);
            if( ($layoutFile=$this->getLayoutFile($this->layout))!==false)
            {
                $output=$this->renderFile($layoutFile, array_merge( $data, array( "content" => $output ) ),true);
            }

            $this->afterRender($view,$output);

            $output=$this->processOutput($output);

            if($return)
                return $output;
            else
                echo $output;
        }
    }

    /*
     * Генерация динамических блоков например rightColumn
     * @param strim $view название вьюшки
     * @param array data параметры отображения
     * @param bool $return
     * @param $processOutput
     */
    public function renderPartial($view,$data=array(),$return=false,$processOutput=false)
    {
        $data = array_merge( $data,
            array(
                "Theme"     => Yii::app()->getTheme(),
                "controller" => $this,
            )
        );

        if(($viewFile=$this->getViewFile($view))!==false)
        {
            $output=$this->renderFile($viewFile,$data,true);
            if($processOutput)
                $output=$this->processOutput($output);
            if($return)
                return $output;
            else
                echo $output;
        }
        else
            throw new CException(Yii::t('yii','{controller} cannot find the requested view "{view}".',
                array('{controller}'=>get_class($this), '{view}'=>$view)));
    }

    public function getJsFiles( $cs )
    {
        foreach( $this->listJsFiles as $key=>$file )
        {
            $cs->registerScriptFile( $file );
        }

        /*
         Yii::app()->clientScript->registerScriptFile(
    Yii::app()->assetManager->publish(
        Yii::getPathOfAlias('ext.myExtension.assets').'/main.js'
    ),
    CClientScript::POS_END
);
         */
    }

    public function getCssFiles( $cs )
    {
        foreach( $this->listJsFiles as $key=>$file )
        {
            $cs->registerScriptFile( $file );
        }

        /*
         Yii::app()->clientScript->registerScriptFile(
    Yii::app()->assetManager->publish(
        Yii::getPathOfAlias('ext.myExtension.assets').'/main.js'
    ),
    CClientScript::POS_END
);
         */
    }
}