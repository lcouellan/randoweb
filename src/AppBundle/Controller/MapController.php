<?php
/**
 * Created by PhpStorm.
 * User: Lénaïc
 * Date: 08/03/2016
 * Time: 17:00
 */
namespace AppBundle\Controller;

use AppBundle\Entity\Randonnee;
use AppBundle\Entity\RandonneeFilter;
use AppBundle\Form\RandonneeForm;
use AppBundle\Form\RandonneeFilterForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


class MapController extends Controller
{
    /**
     * @Route("/map/new")
     */
    public function newAction(Request $request)
    {
        $randonnee = new Randonnee();
        $form = $this->createForm(RandonneeForm::class,$randonnee);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $usr= $this->get('security.token_storage')->getToken()->getUser();
            $randonnee->setAuthor($usr->getId());



            $file = $randonnee->getImage();
            $imgName = md5(uniqid()).'.'.$file->guessExtension();
            $imgDir = $this->container->getParameter('kernel.root_dir').'/../web/images/randonnees';
            $file->move($imgDir, $imgName);
            $randonnee->setImage($imgName);


            $file = $randonnee->getTrace();
            $traceName = md5(uniqid()).'.'."gpx";
            $traceDir = $this->container->getParameter('kernel.root_dir').'/../web/traces';
            $file->move($traceDir, $traceName);
            $randonnee->setTrace($traceName);

            $feed = file_get_contents($traceDir."/".$traceName);
            $xml = simplexml_load_string($feed);
            $track = $xml->trk->trkseg->trkpt[0];
            $lat = $track->attributes()->lat;
            $long =$track->attributes()->lon;
            $randonnee->setLatitude($lat);
            $randonnee->setLongitude($long);

            
            $em->persist($randonnee);
            $em->flush();
            return $this->redirectToRoute('index',array());
        }



        $templating = $this->container->get('templating');
        $html = $templating->render('map/new.html.twig',array(
            'form'=>$form->createView()
        ));
        return new Response($html);
    }

    /**
     * @Route("map/{randoId}")
     */
    public function showRandonnee($randoId,Request $request)
    {
        $randonnee = $this->getDoctrine()
            ->getRepository('AppBundle:Randonnee')
            ->find($randoId);
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            "SELECT u FROM AppBundle:User u
JOIN AppBundle:Randonnee r WITH r.author = u.id
WHERE r.id= :id"
        )->setParameter('id',$randoId);
        $users = $query->getArrayResult();

        if (!$randonnee) {
            throw $this->createNotFoundException('Désolé, la randonnée n\' a pas pu être trouvée !');
        }

        /* Commentaires */
        $thread = $this->container->get('fos_comment.manager.thread')->findThreadBy(['permalink'=>$request->getUri()]);
        if (null === $thread) {
            $thread = $this->container->get('fos_comment.manager.thread')->createThread();
            $thread->setPermalink($request->getUri());

            // Add the thread
            $this->container->get('fos_comment.manager.thread')->saveThread($thread);
        }
        $comments = $this->container->get('fos_comment.manager.comment')->findCommentTreeByThread($thread);



        $templating = $this->container->get('templating');
        $html = $templating->render('map/rando.html.twig',[
                'randonnee'=>$randonnee,
                'user'=>$users[0],
                'comments' => $comments,
                'thread' => $thread
            ]);
        return new Response($html);
    }
    /**
     * @Route("search")
     */
    public function showAllRandonnee(Request $request)
    {
        $randonnee = new RandonneeFilter();
        $form = $this->createForm(RandonneeFilterForm::class,$randonnee);
        $form->handleRequest($request);
        $entities="";
        if ($form->isValid()) {
            $parameters = $this->toArray($form->getData());
            $em = $this->getDoctrine()->getManager();
            if($parameters["difficulty"] == 'toutes'){
                $difficulty = "AND r.difficulty !=";
            }else{
                $difficulty = "AND r.difficulty =";
            }
            $query = $em->createQuery(
                "SELECT r
    FROM AppBundle:Randonnee r
    WHERE r.name like concat('%',:nom,'%')".$difficulty.":difficulty
    AND r.time BETWEEN :minT and :maxT
    AND r.distance BETWEEN :minD and :maxD"
            )->setParameters($parameters);
            $entities = $query->getResult();
        }


        $templating = $this->container->get('templating');
        $html = $templating->render('map/showAll.html.twig',array(
            'form'=>$form->createView(),
            'randonnees'=>$entities
        ));
        return new Response($html);
    }

    public function toArray(RandonneeFilter $object){
        $array = array();
        if($object->getName()!= null){
            $array['nom'] = $object->getName();
        }else{
            $array['nom'] = '';
        }
        $array['difficulty'] = $object->getDifficulty();
        if($object->getTimeMin()!= null){
            $array['minT'] = $object->getTimeMin();
        }else{
            $array['minT'] = 0;
        }
        if($object->getTimeMax() != null){
            $array['maxT'] = $object->getTimeMax();
        }else{
            $array['maxT'] = 999;
        }
        if($object->getDistanceMin() != null){
            $array['minD'] = $object->getDistanceMin();
        }else{
            $array['minD'] = 0;
        }
        if($object->getDistanceMax()!= null){
            $array['maxD'] = $object->getDistanceMax();
        }else{
            $array['maxD'] = 999;
        }

        return $array;
    }


    /**
     * @Route("json/{search}")
     */
    public function getAllRandonneesJSON($search)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            "SELECT r
    FROM AppBundle:Randonnee r
    WHERE r.name like concat('%',:nom,'%')"
        )->setParameters(['nom'=>$search]);
        $randonnees = $query->getArrayResult();
        return new JsonResponse($randonnees);
    }
    

    
}