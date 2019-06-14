<?php

namespace App\Controller;

use App\Entity\Show;
use App\Form\ShowType;
use App\Repository\ShowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Cocur\Slugify\Slugify;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/show")
 */
class ShowController extends AbstractController
{
    /**
     * @Route("/", name="show_index", methods={"GET"})
     */
    public function index(ShowRepository $showRepository): Response
    {
        return $this->render('show/index.html.twig', [
            'shows' => $showRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="show_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NULL, 'Accès interdit');
        
        $show = new Show();
        $form = $this->createForm(ShowType::class, $show);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slugify = new Slugify();
            $show->setSlug($slugify->slugify($show->getTitle()));
            
            if(is_null($show->getCategory())){
                $repoCategory = $this->getDoctrine()->getRepository(Category::class);
                $categorie = $repoCategory->findOneByName('inconnue');
                
                $show->setCategory($categorie);
            }
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($show);
            $entityManager->flush();

            return $this->redirectToRoute('show_index');
        }

        return $this->render('show/new.html.twig', [
            'show' => $show,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show_show", methods={"GET"})
     */
    public function show(Show $show): Response
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Show::class);
        
        $show->author = '';
        
        foreach($show->getTroupe() as $troupe) {
            if($troupe->getType()->getType()=='metteur en scène') {
                $show->author = $troupe->getArtist()->getFirstname()." "
                        .$troupe->getArtist()->getLastname();
                break;
            }
        }
        
        //TODO: $show->author = $repository->findArtistsByType('metteur en scène');
        return $this->render('show/show.html.twig', [
            'show' => $show,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="show_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Show $show): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NULL, 'Accès interdit');
        
        $form = $this->createForm(ShowType::class, $show);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {           
            if(empty($request->request->get('show')['category'])){
                $repoCategory = $this->getDoctrine()->getRepository(Category::class);
                $categorie = $repoCategory->findOneByName('inconnue');
                
                $show->setCategory($categorie);
            }
            
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('show_index', [
                'id' => $show->getId(),
            ]);
        }

        return $this->render('show/edit.html.twig', [
            'show' => $show,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Show $show): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', NULL, 'Accès interdit');
        
        if ($this->isCsrfTokenValid('delete'.$show->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($show);
            $entityManager->flush();
        }

        return $this->redirectToRoute('show_index');
    }
    
    /**
     * @Route("/switchBookable/{id}", name="show_bookable_switch", methods={"POST"})
     */
    public function switchBookable(Request $request, Show $show): Response
    {
        $bookable = $request->request->get('bookable');
        $idShow = $request->get('id');
        
        if($bookable=='No') {
            $show->setBookable(true);
        } elseif($bookable=='Yes') {
            $show->setBookable(false);
        }
        
        $this->getDoctrine()->getManager()->flush();
        
        return new JsonResponse(TRUE);
    }
}
