<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConnectionController extends AbstractController
{
    /**
     * @Route("/connection", name="connection")
     */
    public function index(): Response
    {  
        $em = $this->getDoctrine()->getManager();
			$em->getConnection()->connect();
			$connected = $em->getConnection()->isConnected();
        return $this->render('connection/index.html.twig', [
            'connected' => $connected,
        ]);
    }
}
