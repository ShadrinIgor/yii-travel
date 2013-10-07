<?php
/**
 * User: Игорь
 * Date: 27.09.12
 * Тип данных - параметры для SQL запросса
 */
class DBQueryParamsClass
{
    private $_conditions;
    private $_fields;
    private $_where = "";
    private $_params = array();
    private $_orderBy;
    private $_orderType = 'ASC';
    private $_page = null;
    private $_group;
    private $_cache = 1000; //
    private $_limit = 10;  // Если надо будет вывести все записи то необходимо выставить -1

    static function CreateParams()
    {
        $obj = new DBQueryParamsClass();
        return $obj;
    }

    public function __construct()
    {
        return $this;
    }


    public function setGroup( $value )
    {
        $this->_group = $value;
        return $this;
    }

    public function getGroup( )
    {
        return $this->_group;
    }

    public function setConditions( $value )
    {
        $this->_conditions = $value;
        return $this;
    }

    public function getConditions( )
    {
        return $this->_conditions;
    }

    public function setWhere( $value )
    {
        $this->_where = $value;
        return $this;
    }

    public function getWhere( )
    {
        return $this->_where;
    }

    public function setCache( $value )
    {
        $this->_cache = $value;
        return $this;
    }

    public function getCache( )
    {
        return $this->_cache;
    }

    public function setFields( $value )
    {
        $value = trim( $value );
        if( empty( $value ) )$value="*";
        $this->_fields = $value;
        return $this;
    }

    public function getFields( )
    {
        return $this->_fields;
    }

    public function setParams( $value )
    {
        $this->_params = $value;
        return $this;
    }

    public function getParams( )
    {
        return $this->_params;
    }

    public function setOrderBy( $value )
    {
        $this->_orderBy = $value;
        return $this;
    }

    public function getOrderBy( )
    {
        return $this->_orderBy;
    }
    public function setOrderType( $value )
    {
        $this->_orderType = $value;
        return $this;
    }

    public function getOrderType( )
    {
        return $this->_orderType;
    }
    public function setPage( $value )
    {
        $this->_page = $value;
        return $this;
    }

    public function getPage( )
    {
        return $this->_page;
    }
    public function setLimit( $value )
    {
        $this->_limit = $value;
        return $this;
    }

    public function getLimit( )
    {
        return $this->_limit;
    }
}
