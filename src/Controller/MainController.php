<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /*** On crée une route avec les annotations suivantes
     * et la méthode doit avoir un nom unique dans la classe
     * ici par exemple la route est / et le nom est homepage
     * **/
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        // on va chercher le fichier twig présent dans template/main/index.html.twig
        // pour afficher son contenu, TWIG est un moteur de template
        // On affecte à cette template une variable controller_name avec comme valeur 'MainController'
        //
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /** On crée une seconde route avec l'url /about-us et comme nom about-us */

    #[Route('/about-us', name: 'about-us')]
    public function aboutUs(): Response
    {
        return $this->render('main/about-us.html.twig', [
        ]);
    }
}
