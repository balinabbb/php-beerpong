<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

class DefaultController extends Controller
{
    /**
     * @Route("/me", name="profile")
     */
    public function meAction(Request $request, UserInterface $user)
    {
        $this->denyAccessUnlessGranted('ROLE_READ', null, 'Unable to access this page!');
        return new Response('Hello '.$user->getUsername());
    }
}
