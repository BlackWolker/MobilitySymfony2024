<?php

namespace App\Controller;

use App\Entity\News;
use App\Form\NewsType;
use App\Repository\NewsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class NewsController extends AbstractController
{
    #[Route('/', name: 'news_index')]
    public function index(NewsRepository $newsRepository): Response
    {
        $lesNews = $newsRepository->findAll();
        ##dd($lesNews);
        return $this->render('news/index.html.twig', [
            'lesNews' => $lesNews,
        ]);
    }

    
    #[Route('/news/gestion', name: 'news_gestion')]
    #[IsGranted('ROLE_ADMIN')]
    public function gestion(NewsRepository $newsRepository): Response
    {
        $lesNews = $newsRepository->findAll();
        ##dd($lesNews);
        return $this->render('news/gestion.html.twig', [
            'lesNews' => $lesNews,
        ]);
    }

    //Formulaire d'Ajout
    #[Route('/news/new', name: 'news_new')]
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $uneNews = new News();
        $form = $this->createForm(NewsType::class, $uneNews);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $doctrine->getManager();
            $entityManager->persist($uneNews);
            $entityManager->flush();
            return $this->redirectToRoute('news_gestion', [], Response::HTTP_SEE_OTHER);
        }

        
        return $this->render('news/new.html.twig', [
            'uneNews' => $uneNews,
            'formNews' => $form->createView()
        ]);
    }

    //Edition
    #[Route('/news/{id}/edit', name: 'news_edit', methods:['GET', 'POST'])]
    public function edit(News $uneNews,Request $request, ManagerRegistry $doctrine): Response
    {
        
        $form = $this->createForm(NewsType::class, $uneNews);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $doctrine->getManager();
            $entityManager->persist($uneNews);
            $entityManager->flush();
            return $this->redirectToRoute('news_gestion', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('news/edit.html.twig', [
            'laNews' => $uneNews,
            'formNews' => $form
        ]);
    }

    //suppression
    #[Route('/news/{id}/delete', name: 'news_delete', methods:['GET', 'POST'])]
    public function delete(News $uneNews,Request $request, ManagerRegistry $doctrine): Response
    {
        
        $form = $this->createForm(NewsType::class, $uneNews);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $doctrine->getManager();
            $entityManager->remove($uneNews);
            $entityManager->flush();
            return $this->redirectToRoute('news_gestion', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('news/delete.html.twig', [
            'laNews' => $uneNews,
            'formNews' => $form
        ]);
    }

    //affichage
    #[Route('/news/{id}', name: 'news_show')]
    public function show($id, NewsRepository $newsRepository): Response
    {
        return $this->render('news/show.html.twig', [
            'leNews' => $newsRepository->findByNews($id),
        ]);
    }
    

    #[Route('/news/update/{id}', name: 'news_update')]
    public function Update($id, NewsRepository $newsRepository): Response
    {
        $lesNews = $newsRepository->findAll();
        return $this->render('news/upadte.html.twig', [
            'lesNews' => $lesNews,
        ]);
    }
}
