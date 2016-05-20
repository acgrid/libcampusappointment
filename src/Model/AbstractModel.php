<?php


namespace CampusAppointment\Model;


class AbstractModel implements PersistentModel
{
    const PRIMARY_KEY = 'id';
    protected static $reads = [];
    protected static $writes = [];

    public function __get($name){
        $function = 'get' . ucfirst($name);
        if(is_callable([$this, $function])){
            return call_user_func([$this, $function]);
        }elseif(in_array($name, ['reads', 'writes']) || in_array($name, static::$reads)){
            return $this->$name;
        }else{
            throw new BadFieldException($name);
        }
    }

    public function __set($name, $value){
        $function = 'set' . ucfirst($name);
        if(is_callable([$this, $function])){
            call_user_func([$this, $function], $value);
        }elseif(isset($this->$name) && in_array($name,static::$writes)){
            $this->$name = $value;
        }else{
            throw new BadFieldException($name);
        }
        return $this;
    }

    public function setId($id){
        if(isset($this->{static::PRIMARY_KEY})) throw new RewriteIDException();
        $this->{static::PRIMARY_KEY} = intval($id);
        return $this;
    }
}