<?php
/**
 * Created by PhpStorm.
 * User: acgrid
 * Date: 2016/6/25
 * Time: 22:48
 */

namespace CampusAppointment\DataSource;


use CampusAppointment\Adapter\VisitorAdapter;
use CampusAppointment\Model\Preset\Visitor;

abstract class VisitorAbstractSource implements VisitorInterface
{
    protected $adapters = [];

    public function registerAdapter(VisitorAdapter $adapter): VisitorInterface
    {
        $this->adapters[$adapter->getTargetClass()] = $adapter;
        return $this;
    }

    protected function iterateFactory($data)
    {
        foreach($this->adapters as $className => $adapter)
        {
            /** @var VisitorAdapter $adapter */
            if(($rtn = $adapter->tryFactory($data)) instanceof $className) return $rtn;
        }
        return null;
    }

    protected function iteratePersist(Visitor $object)
    {
        $className = get_class($object);
        if(isset($this->adapters[$className])){
            /** @var VisitorAdapter "$this->adapters[$className]" */
            return $this->adapters[$className]->persit($object);
        }
        throw new \RuntimeException("No adapter registered for visitor type $className.");
    }

}