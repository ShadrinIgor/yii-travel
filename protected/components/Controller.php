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

    public function run($actionID)
    {
        // Это необходимо чтобы не писать каждый раз в адресной строке INDEX
        $action=$this->createAction($actionID);
        if( $action === null )
        {
            $_GET = array();
            $actionID = "index";

            $urlArray = explode( Yii::app()->controller->getId(), Yii::app()->request->getUrl() );
            $urlArray = explode( "?", $urlArray[1] );
            $urlArrayList = explode( "/", $urlArray[0] );
            if( !empty( $urlArray[1] ) )
            {
                // Собирем переменные переденные после знака ?
                $urlArrayDop = explode( "&", $urlArray[1] );
                for( $i=0;$i<sizeof( $urlArrayDop );$i++ )
                {
                    $arr = explode( "=", $urlArrayDop[$i] );
                    $key = $arr[ 0 ];
                    if( !empty( $arr[ 1 ] ) )$_GET[$key] =$arr[ 1 ];
                                        else $_GET[$key] = "null";
                }
            }

            if( sizeof( $urlArrayList )>0 )
            {
                for( $i=1;$i<sizeof( $urlArrayList );$i+=2 )
                {
                    $key = $urlArrayList[ $i ];
                    if( !empty( $urlArrayList[ $i+1 ] ) )$_GET[$key] = $urlArrayList[ $i+1 ];
                                                else $_GET[$key] = "null";
                }
            }

            $action=$this->createAction($actionID);
        }

        if($action!==null)
        {
            if(($parent=$this->getModule())===null)
                $parent=Yii::app();
            if($parent->beforeControllerAction($this,$action))
            {
                $this->runActionWithFilters($action,$this->filters());
                $parent->afterControllerAction($this,$action);
            }
        }
        else
            $this->missingAction($actionID);
    }

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            //  captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page'=>array(
                'class'=>'CViewAction',
            ),
        );
    }

    public function filters()
    {
        return array(
            array(
                'application.filters.YXssFilter',
                'clean'   => '*',
                'tags'    => 'none',
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
            if( !Yii::app()->user->isGuest )
            {
                $userModel = CatalogUsers::fetch( Yii::app()->user->getId() );
                if( $userModel->id > 0 )$USER = $userModel;
                    else 
                {
                    Yii::app()->user->logout();
                    $this->redirect( SiteHelper::createUrl("/") );
                }
            }
                else $USER = new CatalogUsers();

            $data = array_merge( $data,
                array(
                    "Theme"     => Yii::app()->getTheme(),
                    "controller" => $this,
                    "USER"       => $USER,
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