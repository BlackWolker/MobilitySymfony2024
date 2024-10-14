<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'panier_index')]
    public function index(SessionInterface $session,ProduitRepository $prodRepo): Response
    {
        $panier = $session->get('panier',[]);
        $panierAvecDonnees =[];

        foreach($panier as $id => $quantite){
            $panierAvecDonnees[] = ['produit' => $prodRepo->find($id),
                                    'qte' => $quantite];
        }

        return $this->render('panier/index.html.twig', [
            'items' => $panierAvecDonnees,
        ]);
    }

    #[Route('/panier/add/{id}', name: 'panier_add')]
    public function add($id, SessionInterface $session): Response
    {
        $panier = $session->get('panier',[]);
        if (!empty($panier[$id]))
            $panier[$id]++;
        
        else
            $panier[$id] = 1;
            $session->set('panier',$panier);
            $this->addFlash('panier', 'Produit ajouté au panier');
            return $this->redirectToRoute('produit_index', [], Response::HTTP_SEE_OTHER);
            $session->set('nbproduitpanier', $this->nbProdPanier($session));
        
            dd($panier);
    }
    
    public function nbProdPanier(SessionInterface $session)
    {
        $panier = $session->get('panier',[]);
        $total = 0;
        foreach($panier as $id => $quantite)
        {
            $total = $total + $quantite;
        }
        return $total;
    }
}
