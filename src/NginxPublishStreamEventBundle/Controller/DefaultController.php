<?php

namespace NginxPublishStreamEventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('NginxPublishStreamEventBundle:Default:index.html.twig', array('name' => $name));
    }
}
