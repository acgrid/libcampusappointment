<?php
/**
 * Created by PhpStorm.
 * User: acgrid
 * Date: 2016/6/26
 * Time: 14:18
 */

namespace CampusAppointmentTest\Model;


use CampusAppointment\Model\Preset\Visitor;

class Student extends Visitor
{
    const LABEL = '学生';
    const IDENTITY = 'S';
    const UNIQUE_LABEL = '学号';
}