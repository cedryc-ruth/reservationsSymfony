<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Locality;

class LocalityController extends AbstractController
{
    /**
     * @Route("/locality", name="locality")
     */
    public function index()
    {
        $repo= $this->getDoctrine()->getRepository(Locality::class);
        
        $localities = $repo->findAll();
        
        return $this->render('locality/index.html.twig', [
            'localities' => $localities,
            'resource' => 'localités',
        ]);
    }
}
