<?php
/**
 * Created by PhpStorm.
 * User: Lenaic
 * Date: 10/05/2016
 * Time: 22:44
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Entity\Comment as BaseComment;
use FOS\CommentBundle\Model\SignedCommentInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="comment")
 */
class Comment extends BaseComment implements SignedCommentInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * Thread of this comment
     *
     * @var Thread
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Thread")
     */
    protected $thread;

    /**
     * Author of the comment
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @var User
     */
    protected $author;

    /**
     * Sets the author of the Comment
     *
     * @param UserInterface $author
     */
    public function setAuthor(UserInterface $author)
    {
        $this->author = $author;
    }

    /**
     * Gets the author of the Comment
     *
     * @return UserInterface
     */
    public function getAuthor()
    {
        return $this->author;
    }

    public function getAuthorName()
    {
        if (null === $this->getAuthor()) {
            return 'Anonymous';
        }
        return $this->getAuthor()->getUsername();
    }
}