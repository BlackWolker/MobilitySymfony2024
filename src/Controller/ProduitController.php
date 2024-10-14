<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProduitController extends AbstractController
{
    #[Route('/produit', name: 'produit_index')]
    public function index(ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {
        //dd ($produitRepository->findAll);

        return $this->render('produit/index.html.twig', [
            'lesProduits' => $produitRepository->findAll(),
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    #[Route('/produit/categ/{id}', name: 'produit_indexCat')]
    public function indexCat($id, ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {
        return $this->render('produit/index.html.twig', [
            //'lesProduits' => $produitRepository->findBy(['uneCategorie' => $id]),
            'lesProduits' => $produitRepository->findByCategorie($id),
            'categories' => $categorieRepository->findAll(),
        ]);
    }
}
