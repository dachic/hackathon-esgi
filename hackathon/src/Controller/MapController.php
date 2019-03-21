<?php

namespace App\Controller;

use App\Service\GetArticles;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SubCategoryRepository;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Console\Input\ArrayInput;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MapController extends AbstractController
{
    const COUNTRIES = ["Autriche" => "Austria","Belgique" => "Belgium","Bulgarie" => "Bulgaria","Croatie" => "Croatia","Chypre" => "Cyprus","République Tchèque" => "Czech Republic","Danemark" => "Denmark","Estonie" => "Estonia","Finlande" => "Finland","France" => "France","Allemagne" =>"Germany","Grèce" => "Greece","Hongrie" => "Hungary","Irlande" => "Ireland","Italie" => "Italy","Lettonie" => "Latvia", "Lituanie" => "Lithuania", "Luxembourg" => "Luxembourg", "Malte" => "Malta", "Pays-Bas" => "Netherlands", "Pologne" => "Poland", "Portugal" => "Portugal", "Roumanie" => "Romania", "Slovaquie" => "Slovak Republic", "Slovénie" => "Slovenia", "Espagne" => "Spain", "Suède" => "Sweden","Royaume-Uni" => "United Kingdom"];

    private $countries_en = 
    ["Austria" => ["score" => 0 , "articles" => []], "Belgium" => ["score" => 0 , "articles" => []],
       "Bulgaria" => ["score" => 0 , "articles" => []],"Croatia" => ["score" => 0 , "articles" => []],
       "Cyprus" => ["score" => 0 , "articles" => []], "Czech Republic" => ["score" => 0 , "articles" => []],
       "Denmark" => ["score" => 0 , "articles" => []], "Estonia" => ["score" => 0 , "articles" => []], "Finland" => ["score" => 0 ,
           "articles" => []], "France" => ["score" => 0 , "articles" => []], "Germany" => ["score" => 0 , "articles" => []],
       "Greece" => ["score" => 0 , "articles" => []], "Hungary" => ["score" => 0 , "articles" => []], "Ireland" => ["score" => 0 , "articles" =>
           []], "Italy" => ["score" => 0 , "articles" => []], "Latvia" => ["score" => 0 , "articles" =>
           []], "Lithuania" => ["score" => 0 , "articles" => []], "Luxembourg" => ["score" => 0 , "articles" =>
           []], "Malta" => ["score" => 0 , "articles" => []],"Netherlands" => ["score" => 0 , "articles" => []], "Poland" => ["score" => 0 , "articles" => []],
       "Portugal" => ["score" => 0 , "articles" => []], "Romania" => ["score" => 0 , "articles" => []], "Slovak Republic" => ["score" => 0 , "articles" => []],
       "Slovenia" => ["score" => 0 , "articles" => []],"Spain" => ["score" => 0 , "articles" => []], "Sweden" => ["score" => 0 , "articles" => []],
       "United Kingdom" => ["score" => 0 , "articles" => []]];

    /**
     * @Route("/articles/year/{date}/category/{id}", name="default")
    */
    public function index($date, $id, KernelInterface $kernel): Response
    {
        //Avoid 504 Requestion Timeout error 
        set_time_limit(0);
        $cache = new FilesystemCache();
        // $cache->clear();
        //if there are no files in cache rerun the command to launch service
        if (!$cache->has('articles'.$id))
        {
            $application = new Application($kernel);
            $application->setAutoExit(false);
            
            $input = new ArrayInput([
               'command' => 'app:GetData',
               'date' => $date,
               'category' => $id
            ]);
         
            $output = new NullOutput();
            $application->run($input, $output);

        }

        $articles = $cache->get('articles'.$id);
        $articles = self::filterById($articles);
        $articlesByCountry = self::filterByCountry($articles);
        $articlesCount = self::countByCountry($articlesByCountry);

        return new JsonResponse($articles);
        
    }

    protected function filterById(array $results)
    { 
        //Remove doublons 
        foreach($results as $key => $cat)
        {
            
            //Remove empty articles
            if($cat["metadata"]["count"] == 0)
            {
                unset($results[$key]);
            }

            // $test = array_unique($cat);
            // foreach($cat['articles'] as $key => $value)
            // {
            // }
        }
        
        return $results;
    }

    protected function filterByCountry($articles)
    {
        // $results = []
        foreach($articles as $art) 
        {
            foreach($art["articles"] as $x => $element)
            {
                foreach(self::COUNTRIES as $key => $value)
                {
                    if ( (strpos($element["name"],$key) !== false) || (strpos($element["name"],$value) !== false))
                    {
                        $results[$element["id"]] = [$value => $element];
                    }
                }
            }
        }
        return $results;
    }

    protected function countByCountry($articles)
    {
        foreach($articles as $key => $value)
        {
            foreach($this->countries_en as $pays => $cpt)
            {
                
                if(key($value) == $pays)
                {   //update country's points
                    $this->countries_en[$pays]["score"] = $this->countries_en[$pays]["score"]+1;
                    array_push($this->countries_en[$pays]["articles"], $value[key($value)]);
                }
            }
        }

        self::tri($this->countries_en);
    }

    protected function tri(&$tableau) 
    {
        $tableau2 = [];
        foreach($tableau as $key =>$pays)
        {
            $taille = count($pays['articles'])-1; 
            for($i = 0; $i < $taille; $i++) 
            { 
                for($j = $taille-1; $j >= $i; $j--) 
                { 
                    if($pays['articles'][$j+1]["social_score"] > $pays['articles'][$j]["social_score"]) 
                    {
                        $temp = $pays['articles'][$j+1]; 
                        $pays['articles'][$j+1] = $pays['articles'][$j]; 
                        $pays['articles'][$j] = $temp; 
                    }
                } 
                $tableau[$key]["articles"] = $pays['articles'];
            } 
        }
        return $tableau;
    }
    /**
     * @Route("/show", name="show")
    */
    public function show()
    {
        return $this->render('index.html.twig');
    }
}
