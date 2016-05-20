<?php


namespace CampusAppointment\Model;


class RewriteIDException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct("Attempt to overwrite an assigned ID.");
    }

}