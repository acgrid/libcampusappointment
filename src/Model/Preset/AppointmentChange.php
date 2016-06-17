<?php


namespace CampusAppointment\Model\Preset;


use CampusAppointment\Model\AbstractModel;
use CampusAppointment\State\AbstractState;

/**
 * Class AppointmentChange
 * @package CampusAppointment\Model
 * @property int $id
 * @property \DateTimeImmutable $datetime
 * @property string $ip
 * @property AbstractState $state
 * @property string $user
 * @property string $previous
 * @property string $changed
 */
class AppointmentChange extends AbstractModel
{
    const LABEL = '预约变更';

    /**
     * @var int
     */
    protected $id;
    /**
     * @var \DateTimeImmutable
     */
    protected $datetime;
    /**
     * @var string
     */
    protected $ip;
    /**
     * @var AbstractState
     */
    protected $state;
    /**
     * @var string
     */
    protected $user;
    /**
     * @var string
     */
    protected $previous;
    /**
     * @var string
     */
    protected $changed;

    protected static $readable = ['id', 'datetime', 'ip', 'state', 'user', 'previous', 'changed'];
    protected static $writable = ['previous', 'changed'];

    /**
     * @param \DateTimeInterface $datetime
     * @return AppointmentChange
     */
    public function setDatetime(\DateTimeInterface $datetime)
    {
        $this->datetime = $datetime instanceof \DateTime ? \DateTimeImmutable::createFromMutable($datetime) : $datetime;
        return $this;
    }

    /**
     * @param string $ip
     * @return AppointmentChange
     */
    public function setIp(string $ip)
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @param AbstractState $state
     * @return AppointmentChange
     */
    public function setState(AbstractState $state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @param string $user
     * @return AppointmentChange
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param string $previous
     * @return AppointmentChange
     */
    public function setPrevious(string $previous)
    {
        $this->previous = $previous;
        return $this;
    }

    /**
     * @param string $changed
     * @return AppointmentChange
     */
    public function setChanged(string $changed)
    {
        $this->changed = $changed;
        return $this;
    }

}