<?php

/**
 * This is the model class for table "catalog_users".
   */
class CatalogUsers extends CCModel
{
    protected $id; // integer 
    protected $del; // integer 
    protected $name; // string 
    protected $active; // integer 
    protected $password; // string 
    protected $surname; // string 
    protected $fatchname; // string 
    protected $email; // string 
    protected $country_id; // integer 
    protected $city_id; // integer 
    protected $type_id; // integer 
    protected $image; // string 
    protected $country_other; // string 
    protected $last_visit; // integer 
    protected $phone; // string 
    protected $site; // string 
    protected $quote; // string 
    protected $desktop; // integer 
    protected $amount; // integer 
    protected $pos; // integer 
    protected $pass; // string 
    protected $subscribe; // integer 
    protected $icq; // string 
    protected $skype; // string 

/*
* Поля - связи
*/
    protected $catalogFirms; //  CatalogFirms
    protected $catalogFirmsBanners; //  CatalogFirmsBanners
    protected $catalogFirmsComments; //  CatalogFirmsComments
    protected $catalogFirmsItems; //  CatalogFirmsItems
    protected $catalogFirmsServices; //  CatalogFirmsService
    protected $catalogHotels; //  CatalogHotels
    protected $catalogItems; //  CatalogItems
    protected $catalogKurorts; //  CatalogKurorts
    protected $catalogTours; //  CatalogTours
    protected $catalogWorks; //  CatalogWork
    protected $exFavorites; //  ExFavorites
    protected $notifications; //  Notifications
    protected $orderRequests; //  OrderRequest
    protected $subscribeSends; //  SubscribeSend


    public function attributeNames()
    {
    }


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'catalog_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, password, email, type_id', 'required'),
			array('subscribe, del, active, last_visit, amount, country_id, city_id, type_id, desktop', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>35),
			array('password, image', 'length', 'max'=>255),
			array('surname, fatchname', 'length', 'max'=>25),
			array('email', 'length', 'max'=>50),
            array('email', 'email'),
            array('email', 'check_exists_email'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('subscribe, pass, pos, del, name, active, password, surname, fatchname, email, country_id, city_id, type_id, image, country_other, last_visit, phone, site, quote, desktop, amount', 'safe'),
			array('id, del, name, active, password, surname, fatchname, email, country_id, city_id, type_id, image, country_other, last_visit, phone, site, quote, desktop, amount, pos, pass, subscribe, icq, skype', 'safe', 'on'=>'search'),
		);
	}

    public function setDefaultActive( $attribute,$params)
    {
        if( empty( $this->active ) )
        {
            $this->active = 0;
        }
    }

    public function setDefaultType( $attribute,$params)
    {
        if( empty( $this->type_id ) )
        {
            $type = CatalogUsersType::fetchByKeyWord( "user" );
            $this->type_id = intval( $type->id );
        }
    }

    public function check_exists_email($attribute,$params)
    {
        if( !$this->hasErrors() )
        {
            $conditions = "email=:email";
            $params = array( ":email"=> $this->email );
            if( $this->id >0 )
            {
                $conditions .= " AND id !=:id";
                $params = array_merge( $params, array( ":id"=>$this->id ) );
            }

            $dbCriterii = DBQueryParamsClass::CreateParams()
                ->setCache(0)
                ->setConditions( $conditions )
                ->setParams( $params );

            $exists = CatalogUsers::fetchAll( $dbCriterii );
            if( sizeof( $exists )>0 )
            {
                $textError = "Email:".$this->email.", уже зарегистрирован в системе<br/>";
                if( $exists[0]->active == 0 )$textError .= "Вам по почте должно было прийти письмо для подверждения регистрации.
                                                           <br/><br/><b>Письмо не пришло?</b><br/><a href=\"".SiteHelper::createUrl( "/user/default/resend", array( "email"=>$this->email ) ) ."\">отправить заново письмо для подтверждения регистрации на ".$this->email."</a>
                                                           <br/><br/><b>Все равно не пришло?</b><br/>Это странно, тогда Вам необходимо будет написать, с Email который вы указали при регистрации, письмо в службу тех. потдержки <a href=\"mailto:".Yii::app()->params["supportEmail"]."\">".Yii::app()->params["supportEmail"]."</a><br/>Пример письма:<br/>Заголовок письма - У меня проблемы с регистрацией<br/>Текст сообщения - Разберитесь пожалуйста";
                    else
                        $textError .= "<br/><b>Забыли пароль?</b><br/><a href=\"".SiteHelper::createUrl( "/user/default/lost" ) ."\">востановить пароль</a>";

                $this->addErrors( array(  "0"=>$textError ) );
            }
        }
    }

    public function updatePasswordHashMD5($attribute,$params)
    {
        if( !$this->hasErrors() )
        {
            $DBUser = CatalogUsers::fetch( Yii::app()->user->id );
            if( $this->password != $DBUser->password )
            {
                $this->password = md5( $this->password ) ;
            }
        }
    }

    public function passwordHashMD5($attribute,$params)
    {
        if( !$this->hasErrors() )
        {
            $this->password = md5( $this->password ) ;
        }
    }

    public function uploadImage($attribute,$params)
    {
        $this->image = CUploadedFile::getInstance($this,'image');
        if( !$this->hasErrors() && !empty( $this->image ) )
        {
            $fileName = SiteHelper::getImagePath( $this->tableName(), $this->id ).rand( 1000, 99999 ).".jpg";
            $this->image->saveAs( $fileName );
            $this->image = $fileName;
        }
    }


	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'catalogFirms' => array(self::HAS_MANY, 'CatalogFirms', 'user_id'),
			'catalogFirmsBanners' => array(self::HAS_MANY, 'CatalogFirmsBanners', 'user_id'),
			'catalogFirmsComments' => array(self::HAS_MANY, 'CatalogFirmsComments', 'user_id'),
			'catalogFirmsItems' => array(self::HAS_MANY, 'CatalogFirmsItems', 'user_id'),
			'catalogFirmsServices' => array(self::HAS_MANY, 'CatalogFirmsService', 'user_id'),
			'catalogHotels' => array(self::HAS_MANY, 'CatalogHotels', 'user_id'),
			'catalogItems' => array(self::HAS_MANY, 'CatalogItems', 'user_id'),
			'catalogKurorts' => array(self::HAS_MANY, 'CatalogKurorts', 'user_id'),
			'catalogTours' => array(self::HAS_MANY, 'CatalogTours', 'user_id'),
			'type' => array(self::BELONGS_TO, 'CatalogUsersType', 'type_id'),
			'desktop0' => array(self::BELONGS_TO, 'CatalogDesktops', 'desktop'),
			'city' => array(self::BELONGS_TO, 'CatalogCity', 'city_id'),
			'country' => array(self::BELONGS_TO, 'CatalogCountry', 'country_id'),
			'catalogWorks' => array(self::HAS_MANY, 'CatalogWork', 'user_id'),
			'exFavorites' => array(self::HAS_MANY, 'ExFavorites', 'user_id'),
			'notifications' => array(self::HAS_MANY, 'Notifications', 'user_id'),
			'orderRequests' => array(self::HAS_MANY, 'OrderRequest', 'user_id'),
			'subscribeSends' => array(self::HAS_MANY, 'SubscribeSend', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'del' => 'Del',
			'name' => 'Имя',
			'active' => 'Active',
			'password' => 'Пароль',
			'surname' => 'Фамилия',
			'fatchname' => 'Отчество',
			'email' => 'Email',
			'country_id' => 'Страна',
			'city_id' => 'Город',
			'type_id' => 'Тип',
			'image' => 'Фото',
			'country_other' => 'Другая страна',
			'last_visit' => 'Last Visit',
			'phone' => 'Телефон',
			'site' => 'Сайт',
			'quote' => 'Quote',
			'desktop' => 'Desktop',
			'amount' => 'Amount',
			'pos' => 'Pos',
			'pass' => 'Pass',
			'subscribe' => 'Subscribe',
			'icq' => 'Icq',
			'skype' => 'Skype',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('del',$this->del);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('surname',$this->surname,true);
		$criteria->compare('fatchname',$this->fatchname,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('country_other',$this->country_other,true);
		$criteria->compare('last_visit',$this->last_visit);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('site',$this->site,true);
		$criteria->compare('quote',$this->quote,true);
		$criteria->compare('desktop',$this->desktop);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('pos',$this->pos);
		$criteria->compare('pass',$this->pass,true);
		$criteria->compare('subscribe',$this->subscribe);
		$criteria->compare('icq',$this->icq,true);
		$criteria->compare('skype',$this->skype,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function fieldType()
    {
        return array_merge( parent::fieldType(), array( "quote"=>"visual_textarea" ) );
    }

    // описываем событие onRegistration
    public function onRegistration($event, $arrayPrams = array())
    {
        if($this->hasEventHandler('onRegistration'))
            $this->raiseEvent('onRegistration', array( "event"=>$event, "params"=>$arrayPrams ) );
    }

    // описываем событие onRegistrationConfirm
    public function onRegistrationConfirm($event)
    {
        if($this->hasEventHandler('onRegistrationConfirm'))
            $this->raiseEvent('onRegistrationConfirm', $event);
    }

    public function onLogin( $event )
    {
        if($this->hasEventHandler('onLogin'))
            $this->raiseEvent('onLogin', $event);
    }

    public function onLostPassword( $event )
    {
        if($this->hasEventHandler('onLostPassword'))
            $this->raiseEvent('onLostPassword', $event);
    }

    public function onLostPasswordConfirm( $event )
    {
        if($this->hasEventHandler('onLostPasswordConfirm'))
            $this->raiseEvent('onLostPasswordConfirm', $event);
	}
}