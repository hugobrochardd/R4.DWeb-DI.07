<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Lego;

/* 
Forcément, vous allez avoir besoin d’injecter le même service que dans votre route /test pour insérer vos legos. Petite particularité, on ne peut pas passer un service en paramètre de la méthode execute (pas d’autowiring sur cette méthode). Du coup, passez ce service en paramètre du constructeur et conservez-le en propriété privée de votre classe. Vous pourrez ainsi vous en servir dans la méthode execute() en passant par cette propriété. J'ai un fichier data.json qui contient des données de legos. Je veux que vous insériez ces données dans la base de données. Pour cela, vous pouvez utiliser le code suivant en le modifiant pour effectuer une boucle :

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
*/

#[AsCommand(
    name: 'app:populate-database',
    description: 'Add a short description for your command',
)]
class PopulateDatabaseCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        //arg1 est le chemin vers le fichier json
        if ($arg1) {
            $data = file_get_contents(__DIR__ . '../../../' . $arg1);
            $legodata = json_decode($data);
            $progressBar = $io->createProgressBar(count($legodata));
            $progressBar->start();
            foreach ($legodata as $lego) {
                $l = new Lego(
                    $lego->id
                );
                $l->setName($lego->name);
                $l->setCollection($lego->collection);
                $l->setDescription($lego->description);
                $l->setPrice($lego->price);
                $l->setPieces($lego->pieces);
                $l->setBoxImage($lego->images->box);
                $l->setLegoImage($lego->images->bg);
                $this->entityManager->persist($l);
                $progressBar->advance();
            }
            $this->entityManager->flush();
            $progressBar->finish();
        }

        if ($input->getOption('option1')) {
            // ...
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        



        return Command::SUCCESS;
    }
}
