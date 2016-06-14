<?php


namespace CampusAppointment\Model;


use CampusAppointment\DataSource\CategoryInterface;
use CampusAppointment\DataSource\ScheduleInterface;
use CampusAppointment\DataSource\VisitorInterface;
use CampusAppointment\State\AbandonedState;
use CampusAppointment\State\AbstractState;
use CampusAppointment\State\CancelledState;
use CampusAppointment\State\ConfirmedState;
use CampusAppointment\State\PendingState;

/**
 * Class Appointment
 * @package CampusAppointment\Model
 * @property-read int $id
 * @property-read Schedule $schedule
 * @property-read \DateTimeImmutable $date
 * @property-read Visitor $visitor
 * @property-read array $categories
 * @property-read \DateTimeImmutable $created
 * @property-read AbstractState $state
 * @property-read array $changes
 */
class Appointment extends AbstractModel
{
    const LABEL = '预约记录';
    /**
     * @var int
     */
    protected $id;
    /**
     * @var Schedule
     */
    protected $schedule;
    /**
     * @var \DateTimeImmutable
     */
    protected $date;
    /**
     * @var Visitor|int
     */
    protected $visitor;
    /**
     * @var array
     */
    protected $categories;
    /**
     * @var \DateTimeImmutable
     */
    protected $created;
    /**
     * @var AbstractState
     */
    protected $state;
    /**
     * @var array
     */
    protected $changes;
    
    protected static $readable = ['date', 'created'];

    protected $scheduleDB;
    protected $visitorDB;
    protected $categoryDB;
    protected $changesDB;

    public function __construct(ScheduleInterface $scheduleInterface, VisitorInterface $visitorInterface, CategoryInterface $categoryInterface)
    {
        $this->scheduleDB = $scheduleInterface;
        $this->visitorDB = $visitorInterface;
        $this->categoryDB = $categoryInterface;
    }

    /**
     * @return Schedule|int
     */
    public function getSchedule()
    {
        return $this->schedule;
    }

    /**
     * @return Visitor|int
     */
    public function getVisitor()
    {
        return $this->visitor;
    }

    /**
     * @return array
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @return AbstractState
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return array
     */
    public function getChanges()
    {
        return $this->changes;
    }

    /**
     * @param Schedule $schedule
     * @return $this
     */
    public function setSchedule(Schedule $schedule)
    {
        $this->schedule = $schedule;
        return $this;
    }

    /**
     * @param \DateTimeImmutable $date
     * @return $this
     */
    public function setDate(\DateTimeImmutable $date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @param Visitor $visitor
     * @return $this
     */
    public function setVisitor(Visitor $visitor)
    {
        $this->visitor = $visitor;
        return $this;
    }

    /**
     * @param array $categories
     * @return $this
     */
    public function setCategories(array $categories)
    {
        $this->categories = $categories;
        return $this;
    }

    /**
     * @param \DateTimeImmutable $created
     * @return $this
     */
    public function setCreated(\DateTimeImmutable $created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @param array $changes
     * @return $this
     */
    public function setChanges(array $changes)
    {
        $this->changes = $changes;
        return $this;
    }
    
    public function setPending()
    {
        $this->state = PendingState::getInstance();
        return $this;
    }

    public function setConfirmed()
    {
        $this->state = ConfirmedState::getInstance();
        return $this;
    }

    public function setCancelled()
    {
        $this->state = CancelledState::getInstance();
        return $this;
    }

    public function setAbandoned()
    {
        $this->state = AbandonedState::getInstance();
        return $this;
    }

    public function change(Schedule $schedule = null, \DateTimeInterface $newDate = null)
    {
        if($this->state->change($this)){
            if(isset($schedule)) $this->schedule = $schedule;
            if(isset($newDate)) $this->date = $newDate;
        }
        return $this;
    }
    
    public function confirm()
    {
        if($this->state->confirm($this)) $this->setConfirmed();
        return $this;
    }
    
    public function cancel()
    {
        if($this->state->cancel($this)) $this->setCancelled();
        return $this;
    }
    
    public function abandon()
    {
        if($this->state->abandon($this)) $this->setAbandoned();
        return $this;
    }

}