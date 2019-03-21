<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SubCategoryRepository;

class GetArticles 
{

    private $repository;

    public function __construct(SubCategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function get(int $category, string $dates, string $edition)
    {
        $curl = curl_init();
        $words = $this->repository->findBy(['category' => $category]);

        $results = [];
        // get data from api for each sub-category
        foreach($words as $subcategory) 
        {
            $url = "https://api.ozae.com/gnw/articles?date=%s&key=f4a5f6832e204f4db1e3977465df9db2&edition=%s&query=%s&hard_limit=10000";
            if($edition == "fr-fr")
                $subc = $subcategory->getLibelle_fr();
            else 
                $subc = $subcategory->getLibelle_en();
            
            $url = sprintf($url, $dates, $edition, $subc);

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            
            array_push($results, json_decode(curl_exec($curl), true));
   
        }
        curl_close($curl);

        return $results;
    }
}
