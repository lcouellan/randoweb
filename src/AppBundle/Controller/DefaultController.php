<?php
/**
 * Created by PhpStorm.
 * User: Lenaic
 * Date: 25/04/2016
 * Time: 16:29
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use DOMDocument;

class DefaultController extends Controller
{
    /**
     * @Route("/",name="index")
     */
    public function showIndex()
    {
        $randonnees = $this->getDoctrine()
            ->getRepository('AppBundle:Randonnee')
            ->findAll();
        $templating = $this->container->get('templating');
        $html = $templating->render('map/show.html.twig',
            [
                'randonnees'=>$randonnees
            ]
            );
        return new Response($html);
    }

    /**
     * @Route("/aPropos")
     */
    public function aPropos()
    {
        $templating = $this->container->get('templating');
        $html = $templating->render('aPropos.html.twig');
        return new Response($html);
    }

    /**
     * @Route("/displayMarkers")
     */
    public function displayMarkers()
    {
        // Start XML file, create parent node
        $domtree = new DOMDocument('1.0', 'UTF-8');
        $markers = $domtree->createElement("markers");
        $markers = $domtree->appendChild($markers);

        $em = $this->getDoctrine()->getManager();
        $randonnees = $em->getRepository('AppBundle:Randonnee')
            ->findAll();
        // Select all the rows in the markers table
        foreach ($randonnees as $element) {
            $marker = $domtree->createElement("marker");
            $id = $domtree->createAttribute('id');
            $id->value = $element->getId();
            $marker->appendChild($id);
            $name = $domtree->createAttribute('name');
            $name->value = $element->getName();
            $marker->appendChild($name);
            $lat = $domtree->createAttribute('lat');
            $lat->value = $element->getLatitude();
            $marker->appendChild($lat);
            $lng = $domtree->createAttribute('lng');
            $lng->value = $element->getLongitude();
            $marker->appendChild($lng);
            $markers->appendChild($marker);
        }
        header("Content-type: text/xml");
        $html = $domtree->saveXML();
        $response = new Response($html);
        $response->headers->set('Content-Type', 'xml');
        return $response;
    }

    /**
     * @Route("traces/{file}")
     */
    public function displayTrace($file)
    {
        $dir = $this->getWebDirectory();
        $xml = file_get_contents($dir."traces/".$file);
        echo $xml;
        
        $response = new Response(xml);
        return $response;
    }


    public function getWebDirectory()
    {
        return dirname(__DIR__). '/../../web/';
    }
}