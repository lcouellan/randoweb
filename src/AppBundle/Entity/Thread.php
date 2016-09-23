<?php
/**
 * Created by PhpStorm.
 * User: Lenaic
 * Date: 10/05/2016
 * Time: 22:47
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Entity\Thread as BaseThread;


/**
 * @ORM\Entity
 * @ORM\Table(name="thread")
 */
class Thread extends BaseThread
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    
}