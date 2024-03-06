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
    
    #[Route('/{collection}', 'filter_by_collection', requirements: ['collection' => 'Creator Expert|Star Wars|Creator|Harry Potter'])]
    public function filter(DatabaseInterface $database, string $collection): Response
    {
        $legos = $database->getLegoByCollection($collection);
        return $this->render('lego.html.twig', [
            'legos' => $legos
        ]);
    }
    

    #[Route('/credits', 'credits')]
    public function credits(CreditsGenerator $credits): Response
    {
        return new Response($credits->getCredits());
    }

    #[Route('/')]
    public function database(DatabaseInterface $database): Response
    {
        $legos = $database->getAllLegoSets();
        return $this->render('lego.html.twig', [
            'legos' => $legos
        ]);
    }

    #[Route('/test', 'test')]

    public function test(EntityManagerInterface $entityManager): Response
    {
        $l = new Lego(1234);
        $l->setName("un beau Lego");
        $l->setCollection("Lego espace");
        $l->setDescription("Un lego de l'espace");
        $l->setPrice(99.99);
        $l->setPieces(1000);
        $l->setBoxImage("https://www.lego.com/cdn/cs/set/assets/blt3e3f3d2d3d3d3d3d/10283.jpg?fit=bounds&format=jpg&quality=80&width=1600&height=1600&dpr=1");
        $l->setLegoImage("https://www.lego.com/cdn/cs/set/assets/blt3e3f3d2d3d3d3d3d/10283.jpg?fit=bounds&format=jpg&quality=80&width=1600&height=1600&dpr=1");
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($l);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$l->getId());
    }




}


