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
<<<<<<< HEAD
        $repo= $this->getDoctrine()->getRepository(Locality::class);
=======
        $repo = $this->getDoctrine()->getRepository(Locality::class);
>>>>>>> 797bfd4403c1d9fa587670caef02e908b31bf4f3
        
        $localities = $repo->findAll();
        
        return $this->render('locality/index.html.twig', [
            'localities' => $localities,
            'resource' => 'localités',
        ]);
    }
}
