<?php


namespace CampusAppointment\DataSource;


interface GenderInterface extends FlyweightSource
{
    public function get(string $identifier);
}