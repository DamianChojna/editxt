<?php

namespace Dch\UtilityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DchUtilityBundle:Default:index.html.twig', array('name' => $name));
    }
}
