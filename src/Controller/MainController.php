<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\throwException;

class MainController extends AbstractController
{
    /*** On crée une route avec les annotations suivantes
     * et la méthode doit avoir un nom unique dans la classe
     * ici par exemple la route est / et le nom est homepage
     * **/
    #[Route('/', name: 'homepage')]
    public function index(AnnonceRepository $annonceRepository): Response
    {
        // on va chercher le fichier twig présent dans template/main/index.html.twig
        // pour afficher son contenu, TWIG est un moteur de template
        // On affecte à cette template une variable controller_name avec comme valeur 'MainController'
        //
        /** récupère des éléments avec en argumebt :
         * where en tableau ,
         order by en tableay
         limit
         et offset *
         */
        $annonces = $annonceRepository->findBy([
            'enable' => true
        ],
            ['createAt' => 'DESC'],
            3,
            0
        );

        /*** récupère tous les éléments de l'entité **/
        //$annonces = $annonceRepository->findAll();

        return $this->render('main/index.html.twig', [
            'annonces' => $annonces,
        ]);
    }

    /** On crée une seconde route avec l'url /about-us et comme nom about-us */

    #[Route('/about-us', name: 'about-us')]
    public function aboutUs(): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return new Response('Vous n\'avez pas les droits');
        }

        return $this->render('main/about-us.html.twig', [
            'page'=> 'About us'
        ]);
    }

    #[Route('/admin', name: 'admin')]
    public function admin(): Response
    {
        return $this->render('main/about-us.html.twig', [
            'page' => 'Admin'
        ]);
    }

    #[Route('/detail/{annonce}', name: 'detail')]
    public function annonceDetail(Annonce $annonce/*, AnnonceRepository $annonceRepository*/): Response
    {
        if (!$annonce) {
            throw $this->createNotFoundException('L\'annonce n\'a pas été trouvée');
        }
        /**** permet de récupérer un élément par l'id **/
        // $annonce = $annonceRepository->find(5);
        /**** permet de récupérer un élément par conditions avec les arguments que findBy() **/
        // $annonce = $annonceRepository->findOneBy(['slug' =>  'annonce-1'], []);



        return $this->render('main/detail.html.twig',
        [
            'annonce' => $annonce
        ]
        );
    }

    #[Route('/api', name: 'api')]
    public function api(AnnonceRepository $annonceRepository, Request $request): Response
    {
        $limit = 3;
        $page = $request->query->get('page') ?: 0;
        $sortBy  = $request->query->get('sortby') ?: 'createAt';
        $sort  = $request->query->get('sort') ?: 'desc';

        $tmpannonces = $annonceRepository->findBy([
            'enable' => true
        ],
            [$sortBy => $sort],
            $limit,
            $page * $limit
        );

        $annonces = [];

        foreach ($tmpannonces as $annonce) {
            $annonces[] = [
                'title' => $annonce->getTitle(),
                'createAt' => $annonce->getCreateAt(),
                'category' => $annonce->getCategory()?->getName(),
            ];
        }

        return $this->json($annonces);

    }

}
