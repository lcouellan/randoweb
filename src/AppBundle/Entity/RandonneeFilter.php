<?php
/**
 * Created by PhpStorm.
 * User: Lenaic
 * Date: 09/05/2016
 * Time: 14:13
 */

namespace AppBundle\Entity;


class RandonneeFilter
{
    protected $name;
    protected $distanceMin;
    protected $distanceMax;
    protected $timeMin;
    protected $timeMax;
    protected $difficulty;




    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    
    /**
     * @return mixed
     */
    public function getDistanceMin()
    {
        return $this->distanceMin;
    }

    /**
     * @param mixed $distanceMin
     */
    public function setDistanceMin($distanceMin)
    {
        $this->distanceMin = $distanceMin;
    }

    /**
     * @return mixed
     */
    public function getDistanceMax()
    {
        return $this->distanceMax;
    }

    /**
     * @param mixed $distanceMax
     */
    public function setDistanceMax($distanceMax)
    {
        $this->distanceMax = $distanceMax;
    }

    /**
     * @return mixed
     */
    public function getTimeMin()
    {
        return $this->timeMin;
    }

    /**
     * @param mixed $timeMin
     */
    public function setTimeMin($timeMin)
    {
        $this->timeMin = $timeMin;
    }

    /**
     * @return mixed
     */
    public function getTimeMax()
    {
        return $this->timeMax;
    }

    /**
     * @param mixed $timeMax
     */
    public function setTimeMax($timeMax)
    {
        $this->timeMax = $timeMax;
    }


    /**
     * @return mixed
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * @param mixed $difficulty
     */
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;
    }



}