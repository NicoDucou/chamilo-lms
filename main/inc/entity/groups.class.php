<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @license see /license.txt
 * @author autogenerated
 */
class Groups extends \Entity
{
    /**
     * @return \Entity\Repository\GroupsRepository
     */
     public static function repository(){
        return \Entity\Repository\GroupsRepository::instance();
    }

    /**
     * @return \Entity\Groups
     */
     public static function create(){
        return new self();
    }

    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $description
     */
    protected $description;

    /**
     * @var string $picture_uri
     */
    protected $picture_uri;

    /**
     * @var string $url
     */
    protected $url;

    /**
     * @var integer $visibility
     */
    protected $visibility;

    /**
     * @var string $updated_on
     */
    protected $updated_on;

    /**
     * @var string $created_on
     */
    protected $created_on;


    /**
     * Get id
     *
     * @return integer 
     */
    public function get_id()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $value
     * @return Groups
     */
    public function set_name($value)
    {
        $this->name = $value;
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function get_name()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $value
     * @return Groups
     */
    public function set_description($value)
    {
        $this->description = $value;
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function get_description()
    {
        return $this->description;
    }

    /**
     * Set picture_uri
     *
     * @param string $value
     * @return Groups
     */
    public function set_picture_uri($value)
    {
        $this->picture_uri = $value;
        return $this;
    }

    /**
     * Get picture_uri
     *
     * @return string 
     */
    public function get_picture_uri()
    {
        return $this->picture_uri;
    }

    /**
     * Set url
     *
     * @param string $value
     * @return Groups
     */
    public function set_url($value)
    {
        $this->url = $value;
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function get_url()
    {
        return $this->url;
    }

    /**
     * Set visibility
     *
     * @param integer $value
     * @return Groups
     */
    public function set_visibility($value)
    {
        $this->visibility = $value;
        return $this;
    }

    /**
     * Get visibility
     *
     * @return integer 
     */
    public function get_visibility()
    {
        return $this->visibility;
    }

    /**
     * Set updated_on
     *
     * @param string $value
     * @return Groups
     */
    public function set_updated_on($value)
    {
        $this->updated_on = $value;
        return $this;
    }

    /**
     * Get updated_on
     *
     * @return string 
     */
    public function get_updated_on()
    {
        return $this->updated_on;
    }

    /**
     * Set created_on
     *
     * @param string $value
     * @return Groups
     */
    public function set_created_on($value)
    {
        $this->created_on = $value;
        return $this;
    }

    /**
     * Get created_on
     *
     * @return string 
     */
    public function get_created_on()
    {
        return $this->created_on;
    }
}