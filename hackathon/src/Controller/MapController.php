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
        if (!$cache->has('articles'.$id.$date))
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

        // $articles = $cache->get('articles'.$id.$date);
        // $articles = self::filterById($articles);
        // $articlesByCountry = self::filterByCountry($articles);
        // $articlesCount = self::countByCountry($articlesByCountry);

        // return new JsonResponse($articles);
        return new JsonResponse(
        [ 
            "Austria" => [
              "score" => 2,
              "articles" => [
                0 => [
                  "id" => 131083403,
                  "name" => "5 choses à savoir sur l'Autriche, qui prend la présidence de l'Union européenne",
                  "url" => "https://www.nouvelobs.com/monde/20180630.OBS8978/5-choses-a-savoir-sur-l-autriche-qui-prend-la-presidence-de-l-union-europeenne.html",
                  "edition" => "fr-fr",
                  "source" => "",
                  "topics" => 2,
                  "date_first_seen" => "2018-07-01T06:06:57Z",
                  "date_last_seen" => "2018-07-02T13:54:01Z",
                  "show_interval" => "06:03",
                  "article_score" => 20320,
                  "social_score" => 1648,
                  "social_speed_sph" => 0,
                  "img_uri" => "https://media.nouvelobs.com/referentiel/1200x630/16363964.jpg",
                  "sph_on_period" => 0
                ],
                1 => [
                  "id" => 131594485,
                  "name" => "En Autriche, le président iranien plaide pour la sauvegarde de l'accord nucléaire sur Orange Finance",
                  "url" => "https://finance.orange.fr/actualite-eco/article/en-autriche-le-president-iranien-plaide-pour-la-sauvegarde-de-l-accord-nucleaire-CNT0000014DFmw.html",
                  "edition" => "fr-fr",
                  "source" => 2 ,
                  "topics" => 2, 
                  "date_first_seen" => "2018-07-04T18:54:59Z",
                  "date_last_seen" => "2018-07-06T03:54:02Z",
                  "show_interval" => "04:20",
                  "article_score" => 410,
                  "social_score" => 0,
                  "social_speed_sph" => -1,
                  "img_uri" => "http://media1.woopic.com/api/v1/images/493%2Fafp-news%2Ff9e%2Ff51%2F457336473520e1057d548cde41%2Fen-autriche-le-president-iranien-plaide-pour-la-sauvegarde-de-l",
                  "sph_on_period" => 0
                ]
              ]
            ],
            "France" => [
              "score" => 4,
              "articles" => [
                0 => [
                  "id" => 126833816,
                  "name" => "Aisne : un propriétaire déverse les déchets de ses anciens locataires devant leur nouveau logement - France 3 Hauts-de-France",
                  "url" => "https://france3-regions.francetvinfo.fr/hauts-de-france/aisne/aisne-proprietaire-deverse-dechets-ses-anciens-locataires-devant-leur-nouveau-logement-1489775.htm",
                  "edition" => "fr-fr",
                  "source" => 2,
                  "topics" => 2, 
                  "date_first_seen" => "2018-06-06T19:28:08Z",
                  "date_last_seen" => "2018-06-10T07:15:01Z",
                  "show_interval" => "06:38",
                  "article_score" => 126739,
                  "social_score" => 72948,
                  "social_speed_sph" => 5,
                  "img_uri" => "https://france3-regions.francetvinfo.fr/hauts-de-france/sites/regions_france3/files/styles/top_big/public/assets/images/2018/06/06/sans_titre-1_17-3696639.jpg?i",
                  "sph_on_period" => 0
                ],
                1 => [
                  "id" => 144764688,
                  "name" => "France/Monde | Attention : rappel de haricots verts Leclerc à cause d'une plante toxique",
                  "url" => "https://www.ledauphine.com/france-monde/2019/03/08/attention-rappel-de-haricots-verts-leclerc-a-cause-d-une-plante-toxique",
                  "edition" => "fr-fr",
                  "source" => 2, 
                  "topics" => 2, 
                  "date_first_seen" => "2019-03-08T17:25:56Z",
                  "date_last_seen" => "2019-03-09T22:31:00Z",
                  "show_interval" => "05:45",
                  "article_score" => 37066,
                  "social_score" => 43817,
                  "social_speed_sph" => 4,
                  "img_uri" => "https://cdn-s-www.ledauphine.com/images/328704FA-9DBA-4383-9D0E-95B83789616B/FB1200/photo-1552059949.jpg",
                  "sph_on_period" => 0
                ],
                2 => [
                  "id" => 134545547,
                  "name" => "Coquille Saint-Jacques : les pêcheurs normands et anglais s'affrontent en mer ! - France 3 Normandie",
                  "url" => "https://france3-regions.francetvinfo.fr/normandie/calvados/coquille-saint-jacques-pecheurs-normands-anglais-s-affrontent-mer-1531692.html",
                  "edition" => "fr-fr",
                  "source" => 2,
                  "topics" => 2, 
                  "date_first_seen" => "2018-08-28T11:49:08Z",
                  "date_last_seen" => "2018-08-29T17:15:01Z",
                  "show_interval" => "22:12",
                  "article_score" => 291392,
                  "social_score" => 23657,
                  "social_speed_sph" => 0,
                  "img_uri" => "https://france3-regions.francetvinfo.fr/normandie/sites/regions_france3/files/styles/top_big/public/assets/images/2018/08/28/bateau_2_1-3816788.jpg?itok=NWJH0T7 ",
                  "sph_on_period" => 0
                ],
                3 => [
                  "id" => 135217581,
                  "name" => "Antibes : le comédien Samuel Le Bihan présente Chrysalis, un prototype qui transforme le plastique en carburant - France 3 Provence-Alpes-Côte d'Azur",
                  "url" => "https://france3-regions.francetvinfo.fr/provence-alpes-cote-d-azur/alpes-maritimes/antibes/antibes-comedien-samuel-bihan-presente-chrysalis-prototype-qui-transf ",
                  "edition" => "fr-fr",
                  "source" => 2,
                  "topics" => 2, 
                  "date_first_seen" => "2018-09-10T20:39:44Z",
                  "date_last_seen" => "2018-09-11T02:36:01Z",
                  "show_interval" => "04:03",
                  "article_score" => 283,
                  "social_score" => 9554,
                  "social_speed_sph" => 0,
                  "img_uri" => "https://france3-regions.francetvinfo.fr/provence-alpes-cote-d-azur/sites/regions_france3/files/styles/top_big/public/assets/images/2018/09/10/off_earthwake_solu ",
                  "sph_on_period" => 0
                ]
              ]
          ]]);
    }

    protected function filterById(array $results)
    { 
        //Remove doublons 
        foreach($results as $key => $cat)
        {
            
            //Remove empty articles
            if(isset($cat["metadata"]["count"]) && $cat["metadata"]["count"] == 0)
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
