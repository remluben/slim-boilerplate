<?php namespace App\Components\Config;

/**
 * Class for retrieving and setting configuration values
 *
 * @author Benjamin Ulmer
 * @link http://github.com/remluben/slim-boilerplate
 */
class Config
{
    /**
     * @var array
     */
    private $data = array();

    /**
     * @param array $data
     */
    public function __construct($data = array())
    {
        $this->data = $data;
    }

    /**
     * Returns the requested configuration value or the provided default value
     * if not found.
     *
     * Access nested configuration values by using the dot notation, i.e. name.firstname
     * retrieves the value from array('name' => array('firstname' => 'Bob'))
     *
     * @param string $key
     * @param mixed  $default [optional]
     *
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        return array_get($this->data, $key, $default);
    }

    /**
     * Sets a configuration value
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function set($key, $value)
    {
        array_set($this->data, $key, $value);

        return $this;
    }

    /**
     * Returns the array of all configuration values
     *
     * @return array
     */
    public function all()
    {
        return $this->data;
    }
} 