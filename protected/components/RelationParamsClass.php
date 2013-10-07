<?php
/**
 * User: Игорь
 * Date: 27.09.12
 * Тип данных - параметры для SQL запросса
 */
class RelationParamsClass
{
    private $leftClass = null;
    private $rightClass = null;
    private $leftField = null;
    private $rightField = 'id';
    private $leftId = 0;
    private $rightId = 0;

    static function CreateParams()
    {
        return new RelationParamsClass();
    }

    public function __construct()
    {
        return $this;
    }

    public function setLeftClass( $value )
    {
        $this->leftClass = $value;
        return $this;
    }

    public function getLeftClass( )
    {
        return $this->leftClass;
    }

    public function setRightClass( $value )
    {
        $this->rightClass = $value;
        return $this;
    }

    public function getRightClass( )
    {
        return $this->rightClass;
    }

    public function setLeftField( $value )
    {
        $this->leftField = $value;
        return $this;
    }

    public function getLeftField( )
    {
        return $this->leftField;
    }

    public function setRightField( $value )
    {
        $this->rightField = $value;
        return $this;
    }

    public function getRightField( )
    {
        return $this->rightField;
    }

    public function setLeftId( $value )
    {
        $this->leftId = $value;
        return $this;
    }

    public function getLeftId( )
    {
        return $this->leftId;
    }

    public function setRightId( $value )
    {
        $this->rightId = $value;
        return $this;
    }

    public function getRightId( )
    {
        return $this->rightId;
    }
}
