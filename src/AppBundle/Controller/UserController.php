<?php
/**
 * Created by PhpStorm.
 * User: Lenaic
 * Date: 04/05/2016
 * Time: 16:23
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends  Controller
{

    /**
     * @Route("user/{username}")
     */
    public function showAction($username)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:User')->findBy(
            array('username' => $username), // Critere
            array('username' => 'desc'),        // Tri
            1,                              // Limite
            0                               // Offset
        );

        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find User entity.');
        }
        $randonnees = $this->showRando($entity[0]->getId());
        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $entity[0],
            'randonnees' => $randonnees
        ));
    }

    public function showRando($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            "SELECT r FROM AppBundle:Randonnee r
JOIN AppBundle:User u WITH r.author = u.id
WHERE u.id= :id"
        )->setParameter('id',$id);
        $entities = $query->getResult();
        //var_dump($entities);
        return $entities;
    }
}