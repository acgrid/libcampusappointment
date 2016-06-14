<?php


namespace CampusAppointment\Model\Preset;
use CampusAppointment\Model\NamedModel;

class Category extends NamedModel
{
    const LABEL = '咨询类别';

    public function hashCode()
    {
        return base64_encode($this->name);
    }

}