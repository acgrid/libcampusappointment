<?php


namespace CampusAppointment\Helper;


use CampusAppointment\Adapter\ConfigurationAdapter;
use CampusAppointment\DataSource\ZoneInterface;
use CampusAppointment\Model\Preset\Zone;
use CampusAppointment\State\AbstractState;
use CampusAppointment\State\PendingState;

class Configuration
{
    const ALLOW_CONFLICT = 'ALLOW_CONFLICT';
    const DEFAULT_ZONE = 'DEFAULT_ZONE';
    const PROVIDE_WEEKS = 'PROVIDE_WEEKS';
    const INITIAL_STATUS = 'INITIAL_STATUS';

    protected $adapter;
    protected $zone;

    /**
     * Configuration constructor.
     * @param ConfigurationAdapter $adapter
     * @param ZoneInterface $zoneInterface
     */
    public function __construct(ConfigurationAdapter $adapter, ZoneInterface $zoneInterface)
    {
        $this->adapter = $adapter;
        $this->zone = $zoneInterface;
    }

    public function isAllowConflict()
    {
        return $this->adapter->get(static::ALLOW_CONFLICT) ?? false;
    }

    public function setAllowConflict(bool $value)
    {
        $this->adapter->update(static::ALLOW_CONFLICT, $value);
        return $this;
    }

    public function getDefaultZone()
    {
        return $this->zone->get($this->adapter->get(static::DEFAULT_ZONE));
    }

    public function setDefaultZone(Zone $zone)
    {
        $this->adapter->update(static::DEFAULT_ZONE, $zone->id);
        return $this;
    }

    public function getProvideWeeks()
    {
        return $this->adapter->get(static::PROVIDE_WEEKS) ?? 2;
    }

    public function setProvideWeeks(int $weeks)
    {
        $this->adapter->update(static::PROVIDE_WEEKS, $weeks);
        return $this;
    }

    public function getInitialStatus()
    {
        return call_user_func([$this->adapter->get(static::INITIAL_STATUS) ?? PendingState::class, 'getInstance']);
    }

    public function setInitialStatus(AbstractState $status)
    {
        $this->adapter->update(static::INITIAL_STATUS, get_class($status));
        return $this;
    }
}