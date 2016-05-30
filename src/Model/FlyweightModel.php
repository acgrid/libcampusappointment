<?php


namespace CampusAppointment\Model;


interface FlyweightModel extends PersistentModel
{
    public function hashCode();
}