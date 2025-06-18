<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategorieRepository;

final class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index(CategorieRepository $categorieRepository): Response
    {

        $categorie = $categorieRepository->findBy(['active' => 1]);

        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
            'categorie' => $categorie
        ]);
    }

#[Route('/categorie/{id}', name: 'app_sous-categorie')]
public function show(int $id, CategorieRepository $categorieRepository): Response
{
    $categorie = $categorieRepository->find($id);

    if (!$categorie) {
        return $this->redirectToRoute('app_categorie');
    }

    $souscat = $categorie->getSousCategories()->filter(function($sousCategorie) {
        return $sousCategorie->isActive();
    });
    $autresCategories = $categorieRepository->findBy(['active' => 1]);


    return $this->render('categorie/indexSousCategorie.html.twig', [
        'categorie' => $categorie,
        'souscat' => $souscat,
        'autresCategories' => $autresCategories
    ]);

}
}