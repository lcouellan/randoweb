<?php
/**
 * Created by PhpStorm.
 * User: Lenaic
 * Date: 12/04/2016
 * Time: 17:47
 */

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="randonnee")
 */
class Randonnee
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $name;
    /**
     * @ORM\Column(type="float")
     */
    private $latitude;
    /**
     * @ORM\Column(type="float")
     */
    private $longitude;

    /**
     * @ORM\Column(type="float")
     */
    private $distance;

    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('facile', 'moyen', 'difficile')")
     */
    private $difficulty;

    /**
     * @ORM\Column(type="integer")
     */
    private $time;

    /**
     * @Assert\Image(
     *     mimeTypes = {"image/jpeg", "image/png","image/jpg", "image/gif"},
     *     mimeTypesMessage = "Seuls les fichiers images sont autorisés"
     * )
     * @ORM\Column(type="string")
     */
    private $image;

    /**
     * @Assert\File( mimeTypes = {"application/xml"}, mimeTypesMessage = "Seuls les fichiers au format GPX sont autorisés")
     * @ORM\Column(type="string")
     */
    private $trace;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $author;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

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
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }
    /**
     * @return mixed
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param mixed $distance
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time)
    {
        $this->time = $time;
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

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }


    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getTrace()
    {
        return $this->trace;
    }

    /**
     * @param mixed $trace
     */
    public function setTrace($trace)
    {
        $this->trace = $trace;
    }



}