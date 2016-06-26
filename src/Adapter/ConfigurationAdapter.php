<?php
/**
 * Created by PhpStorm.
 * User: acgrid
 * Date: 2016/6/26
 * Time: 16:21
 */

namespace CampusAppointment\Adapter;


interface ConfigurationAdapter
{
    public function get(string $key);
    public function update(string $key, $value);
    public function delete(string $key);
}