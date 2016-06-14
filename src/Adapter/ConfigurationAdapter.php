<?php
/**
 * Created by PhpStorm.
 * User: acgrid
 * Date: 2016/6/26
 * Time: 16:21
 */

namespace CampusAppointment\Adapter;

/**
 * Interface ConfigurationAdapter
 * @package CampusAppointment\Adapter
 */
interface ConfigurationAdapter
{
    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key);

    /**
     * @param string $key
     * @param $value
     * @return mixed
     */
    public function update(string $key, $value);

    /**
     * @param string $key
     * @return void
     */
    public function delete(string $key);
}