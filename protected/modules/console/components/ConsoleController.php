<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class ConsoleController extends Controller
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='console.views.layouts.main';

    public function beforeAction($action)
    {
        if ( Yii::app()->user->isGuest )
        {
            $controller = Yii::app()->controller->getId();
            if( $controller != "default" || ( $action->getId() != 'login' && $action->getId() != 'index' ) )
                $this->redirect('/console/default/login');
        }
            else
        {
            $userModel = CatalogUsers::fetch( Yii::app()->user->id );
            if( !$userModel || !$userModel->type_id )
            {
                Yii::app()->user->logout();
                $this->redirect('/console/default/login');
            }

            if( $userModel->type_id->id == 1 )
                $this->redirect('/');
        }

/*
        if ($this->getBackendUser()->getState('expires') > 0 && $this->getBackendUser()->getState('expires') < time()) {
            $this->getBackendUser()->logout(false);
            $this->redirect('/console');
        } else {
            $this->checkAccess();
        }*/

        return parent::beforeAction($action);
    }

    public function checkAccess($action = null)
    {
        if (is_null($action)) $action = $this->getAction();
        if (!$this->getAuthManager()->checkAccess($this->getOperation(), $this->getBackendUser()->getId())
            && $action->getId() != 'login'
        )
            $this->throwException(403, "You do not have enough permissions to walk here!");
        else
            $this->getBackendStaffSession();
    }

}