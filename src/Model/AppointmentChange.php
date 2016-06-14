<?php


namespace CampusAppointment\Model;


use CampusAppointment\State\AbstractState;

class AppointmentChange extends AbstractModel
{
    const LABEL = '预约变更';
    
    protected $id;
    protected $datetime;
    protected $ip;
    protected $state;
    protected $user;
    protected $previous;
    protected static $readable = ['id', 'datetime', 'ip', 'state', 'user', 'change'];

    public function __construct(int $id, \DateTimeImmutable $datetime, string $ip, AbstractState $state, int $user, $change = '')
    {
        $this->id = $id;
        $this->datetime = $datetime;
        $this->ip = $ip;
        $this->state = $state;
        $this->user = $user;
        $this->previous = '';
    }
}