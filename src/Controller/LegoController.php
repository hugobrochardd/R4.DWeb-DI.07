<?php


/* indique où "vit" ce fichier */
namespace App\Controller;


/* indique l'utilisation du bon bundle pour gérer nos routes */

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Lego;
use App\Service\CreditsGenerator;

/* le nom de la classe doit être cohérent avec le nom du fichier */


//Dans votre classe LegoController, vous ajouterez une propriété privé $legos qui sera un tableau d’objets de votre classe Lego. Puis vous ajouterez un constructeur qui chargera le contenu du fichier data.json (voir la fonction php file_get_contents et la constante magique __DIR__ de PHP) et le convertira en tableau d’objets standards (voir la fonction php json_decode). Note : Pour utiliser votre classe Lego, n’oubliez pas d’inclure l’instruction “use” qui indique où elle se trouve.

//Puis vous parcourez votre tableau d’objets standards pour créer autant d’objets Lego que vous ajouterez à votre propriété $legos.



class LegoController extends AbstractController
{
   // L’attribute #[Route] indique ici que l'on associe la route
   // "/" à la méthode home pour que Symfony l'exécute chaque fois
   // que l'on accède à la racine de notre site.

   private array $legos;

   public function __construct()
   {
       $json = file_get_contents(__DIR__ . "../../data.json");
       $legosdata = json_decode($json);

         foreach ($legosdata as $legodata) {
                $lego = new Lego($legodata->id, $legodata->name, $legodata->collection);
                $lego->setDescription($legodata->description);
                $lego->setPrice($legodata->price);
                $lego->setPieces($legodata->pieces);
                $lego->setBoxImage($legodata->images->box);
                $lego->setLegoImage($legodata->images->bg);
                $this->legos[] = $lego;
                //dd($lego);
         }
   }

   #[Route('/', )]
   public function home()
   {
         return $this->render('/lego.html.twig', [
              'legos' => $this->legos
         ]);
   }


    #[Route('/me', )]
    public function me()
    {
        die("I'm the best.");
    }

    #[Route('/{collection}', 'filter_by_collection', requirements: ['collection' => 'Creator|Star Wars|Expert'])]
    public function filter($collection): Response
    {
        $legos = array_filter($this->legos, function ($lego) use ($collection) {
            return $lego->getCollection() === $collection;
        });

        return $this->render('lego.html.twig', [
            'legos' => $legos
        ]);
    }

    #[Route('/credits', 'credits')]
    public function credits(CreditsGenerator $credits): Response
    {
        return new Response($credits->getCredits());
    }


}


