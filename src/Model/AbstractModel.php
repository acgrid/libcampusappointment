<?php


namespace CampusAppointment\Model;

/**
 * Class AbstractModel
 * @package CampusAppointment\Model
 */
abstract class AbstractModel implements PersistentModel, \JsonSerializable
{
    const PRIMARY_KEY = 'id';
    const LABEL = '抽象业务类';
    protected static $readable = [];
    protected static $writable = [];

    public function __get($name)
    {
        $function = "get{$name}";
        if(is_callable([$this, $function])){
            return call_user_func([$this, $function]);
        }elseif($name === 'readable' || $name === 'writable' || in_array($name, static::$readable)){
            return $this->$name;
        }else{
            throw new BadFieldException($name);
        }
    }

    public function __set($name, $value)
    {
        $function = "set{$name}";
        if(is_callable([$this, $function])){
            call_user_func([$this, $function], $value);
        }elseif(in_array($name, static::$writable)){
            $this->$name = $value;
        }else{
            throw new BadFieldException($name);
        }
        return $this;
    }

    public function __unset($name)
    {
        if($name == 'id'){
            unset($this->{static::PRIMARY_KEY});
            return;
        }
        if(in_array($name, static::$writable)) unset($this->$name);
    }

    function __isset($name)
    {
        return isset($this->$name);
    }

    public function setId($id)
    {
        if(isset($this->{static::PRIMARY_KEY})) throw new RewriteIDException();
        $this->{static::PRIMARY_KEY} = $id;
        return $this;
    }

    public function jsonSerialize()
    {
        static $methods;
        if(!is_array($methods) || !isset($methods[static::class])){
            $methods[static::class] = (new \ReflectionClass(static::class))->getMethods(\ReflectionMethod::IS_PUBLIC);
            foreach($methods[static::class] as $index => $method){
                /** @var \ReflectionMethod $method */
                if(stripos($method->name, 'get') !== 0) unset($methods[static::class][$index]);
            }
        }
        $array = [];
        foreach (static::$readable as $item){
            $array[$item] = $this->$item;
        }
        foreach($methods[static::class] as $method){
            $array[substr($method->name, 3)] = $method->invoke($this);
        }
        return $array;
    }
}