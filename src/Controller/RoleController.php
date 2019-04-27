<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Role;


class RoleController extends AbstractController
{
    /**
     * @Route("/role", name="role")
     */
    public function index()
    {
        $repo= $this->getDoctrine()->getRepository(Role::class);
        
        $roles = $repo->findAll();
        
        return $this->render('role/index.html.twig', [
            'roles' => $roles,
            'resource' => 'rôles',
        ]);
    }
}
