<?php

namespace Whisnet\IrcBotBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('WhisnetIrcBotBundle:Default:index.html.twig', array('name' => $name));
    }
}
