<?php

namespace Acme\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AcmeTestBundle:Default:index.html.twig', array('name' => $name));
    }


    public function test2Action()
    {
        return $this->render('AcmeTestBundle:Default:test2.html.twig');
    }

}
