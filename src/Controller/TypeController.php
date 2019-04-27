<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Type;


class TypeController extends AbstractController
{
    /**
     * @Route("/type", name="type")
     */
    public function index()
    {
        $repo= $this->getDoctrine()->getRepository(Type::class);
        
        $types = $repo->findAll();
        
        return $this->render('type/index.html.twig', [
            'types' => $types,
            'resource' => 'types',
        ]);
    }
}
