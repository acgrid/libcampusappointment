<?php


namespace CampusAppointment\Model;


class BadFieldException extends \RuntimeException
{
    public $fieldName;
    public function __construct($field){
        parent::__construct("Access to unknown field $field.");
        $this->fieldName = $field;
    }
}