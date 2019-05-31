<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\FormError;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        if($this->getUser()->getId()!==$user->getId()) {
            return $this->redirectToRoute('home');
        }
        
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        if($this->getUser()->getId()!==$user->getId()) {
            return $this->redirectToRoute('home');
        }
        
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $oldPassword = $form->get('password')->getData();
            $newPassword = $form->get('newPassword')->getData();
            $confPassword = $form->get('confPassword')->getData();
            
            //L'ancien mot de passe a été fourni
            if($oldPassword!='') {                
                //L'ancien mot de passe correspond
                if($passwordEncoder->isPasswordValid($user, $oldPassword)) {
                    if(!empty($newPassword)) {
                        //Le nouveau mot de passe est confirmé
                        if($newPassword==$confPassword) {
                            //Crypter le nouveau mot de passe
                            $user->setPassword(
                                $passwordEncoder->encodePassword(
                                    $user,
                                    $form->get('newPassword')->getData()
                                )
                            );

                            $manager = $this->getDoctrine()->getManager();
                            $manager->persist($user);
                            $manager->flush();

                            return $this->redirectToRoute('user_index', [
                                'id' => $user->getId(),
                            ]);
                        } else {
                            $form->addError(new FormError('Les deux mots de passe ne correspondent pas!'));
                        }
                    } else {
                        $form->addError(new FormError('Le mot de passe ne peut être vide!'));
                    }
                } else {
                    $form->addError(new FormError('Le mot de passe fourni n\'est pas valide!'));
                }
            } else {
                $form->addError(new FormError('Veuillez fournir l\'ancien mot de passe!'));
            }
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
