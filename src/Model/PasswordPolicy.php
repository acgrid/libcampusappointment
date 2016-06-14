<?php


namespace CampusAppointment\Model;


interface PasswordPolicy
{
    public function test(string $password);
}