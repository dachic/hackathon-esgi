<?php

namespace App\Commande\Script;

use App\Service\GetArticles;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputArgument;

use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class Run extends ContainerAwareCommand
{
    private $em; 

    public function __construct(?string $name = null, EntityManagerInterface $em) { 
      parent::__construct($name); 
      $this->em = $em;
    } 
    protected function configure()
    {
        $this
            ->setName('app:GetData')
            ->setDescription('Commande permettant d\'appeler le service qui ')
            ->addArgument('date', InputArgument::REQUIRED, "")
            ->addArgument('category', InputArgument::REQUIRED, "");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $repository = $this->em->getRepository('App:SubCategory');
        $data = new GetArticles($repository);

        $fr = $data->get($input->getArgument('category'),$input->getArgument('date'), "fr-fr");
        $en = $data->get($input->getArgument('category'),$input->getArgument('date'), "en-gb");
        $results = array_merge($fr, $en);
        
        //put in cache the results
        $cache = new FilesystemCache();
        if (!$cache->has('articles'.$input->getArgument('category'))) 
        {
            $cache->set('articles'.$input->getArgument('category'), $results, 86400);
        }
        
        $output->writeln([
          print_r($results)
        ]);
    }
}
