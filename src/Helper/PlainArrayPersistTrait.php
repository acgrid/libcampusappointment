<?php
/**
 * Created by PhpStorm.
 * User: acgrid
 * Date: 2016/6/26
 * Time: 15:04
 */

namespace CampusAppointment\Helper;


use CampusAppointment\Model\BadFieldException;
use CampusAppointment\Model\AbstractModel;

trait PlainArrayPersistTrait
{
    protected $defaultKeys = [];
    protected $objectSetters = [];
    protected $arrayGetters = [];

    public function requireKey(string $key, callable $setObject = null, callable $setArray = null)
    {
        $this->objectSetters[$key] = $setObject;
        $this->arrayGetters[$key] = $setArray;
        return $this;
    }

    public function optionalKey(string $key, $default, callable $setObject = null, callable $setArray = null)
    {
        $this->defaultKeys[$key] = $default;
        return $this->requireKey($key, $setObject, $setArray);
    }

    protected function setObject(array &$array, object $object)
    {
        foreach($this->objectSetters as $key => $setter) {
            if(array_key_exists($key, $array)){
                $value = $array[$key];
            }elseif(array_key_exists($key, $this->defaultKeys)){
                $value = $this->defaultKeys[$key];
            }else{
                throw new BadFieldException("Missing required database field $key.");
            }
            if($setter) call_user_func($setter, $object, $value, $array);
        }
        return $object;
    }

    protected function setArray(AbstractModel $object): array
    {
        $array = $object->jsonSerialize();
        foreach($this->arrayGetters as $key => $getter){
            try{
                $array[$key] = $getter ? call_user_func($getter, $object) : $object->$key;
            }catch(BadFieldException $e){
                if(isset($this->defaultKeys[$key])){
                    $array[$key] = $this->defaultKeys[$key];
                }else{
                    throw $e;
                }
            }
        }
        return $array;
    }
}