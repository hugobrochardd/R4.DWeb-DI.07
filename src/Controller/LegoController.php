<?php


/* indique où "vit" ce fichier */
namespace App\Controller;


/* indique l'utilisation du bon bundle pour gérer nos routes */

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Lego;
use App\Service\CreditsGenerator;
use App\Service\DatabaseInterface;
use App\Repository\LegoCollectionRepository;
use App\Entity\LegoCollection;

/* le nom de la classe doit être cohérent avec le nom du fichier */


//Dans votre classe LegoController, vous ajouterez une propriété privé $legos qui sera un tableau d’objets de votre classe Lego. Puis vous ajouterez un constructeur qui chargera le contenu du fichier data.json (voir la fonction php file_get_contents et la constante magique __DIR__ de PHP) et le convertira en tableau d’objets standards (voir la fonction php json_decode). Note : Pour utiliser votre classe Lego, n’oubliez pas d’inclure l’instruction “use” qui indique où elle se trouve.

//Puis vous parcourez votre tableau d’objets standards pour créer autant d’objets Lego que vous ajouterez à votre propriété $legos.



class LegoController extends AbstractController
{
   // L’attribute #[Route] indique ici que l'on associe la route
   // "/" à la méthode home pour que Symfony l'exécute chaque fois
   // que l'on accède à la racine de notre site.





    #[Route('/me', )]
    public function me()
    {
        die("I'm the best.");
    }
   
    /*
    #[Route('/{collection}', 'filter_by_collection', requirements: ['collection' => 'Creator Expert|Star Wars|Creator|Harry Potter'])]
    public function filter(EntityManagerInterface $database, string $collection): Response
    {
        $legos = $database->getRepository(Lego::class)->findBy(['collection' => $collection]);
        return $this->render('lego.html.twig', [
            'legos' => $legos
        ]);
    }
    */

    #[Route('/credits', 'credits')]
    public function credits(CreditsGenerator $credits): Response
    {
        return new Response($credits->getCredits());
    }

    #[Route('/')]
    public function home(EntityManagerInterface $database): Response
    {
        $legos = $database->getRepository(Lego::class)->findAll();
        $collections = $database->getRepository(LegoCollection::class)->findAll();
        return $this->render('lego.html.twig', [
            'legos' => $legos,
            'collections' => $collections
        ]);
    }

    #[Route('/test/{name}', 'test')]
    public function test(LegoCollection $collection): Response
    {
        dd($collection);
    }

    

    #[Route('/{name}', 'filter_by_collection', requirements: ['name' => 'Creator Expert|Star Wars|Creator|Harry Potter'])]
    public function filterByCollection(LegoCollection $collection, LegoCollectionRepository $collectionRepository): Response
    {
        $legos = $collection->getCollection();
        $collections = $collectionRepository->findAll();
        return $this->render('lego.html.twig', [
            'legos' => $legos,
            'collections' => $collections
        ]);
    }
}







