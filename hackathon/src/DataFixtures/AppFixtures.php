<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\SubCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public const CATEGORIES = ["EAU", "AIR", "SOL"];

    public function load(ObjectManager $manager)
    {
        $cats = [];
        foreach (self::CATEGORIES as $category) 
        {
            $cat = (new Category())->setLibelle($category);
            $manager->persist($cat);
            array_push($cats, $cat);
        }

        $EauSubCategories = 
        [
            "fr" => ['déchets', 'pétrole', 'chimique', 'toxique', 'nucléaire', 'plastique', 'pêche'],
            "en" => ['garbage', 'petrol', 'chemical', 'toxic', 'nuclear', 'plastic', 'fishing']
        ];

        foreach($EauSubCategories["fr"] as $key => $val)
        {
            $subcat = new SubCategory();
            $subcat->setLibelle_fr($val);
            $subcat->setLibelle_en($EauSubCategories["en"][$key]);
            $subcat->setCategory($cats[0]);
            $manager->persist($subcat);
        }
        

        $AirSubCategories = 
        [
            "fr" => ['CO2', 'atmosphère', 'ozone', 'carbone', 'charbon', 'gaz'],
            "en" => ['CO2', 'atmosphere', 'ozone', 'carbon', 'charcoal', 'gaz']
        ];

        foreach($AirSubCategories["fr"] as $key => $val)
        {
            $subcat = new SubCategory();
            $subcat->setLibelle_fr($val);
            $subcat->setLibelle_en($AirSubCategories["en"][$key]);
            $subcat->setCategory($cats[1]);
            $manager->persist($subcat);
        }

        $manager->flush();
        
        $SolSubCategories = 
        [
            "fr" => ['déchets', 'déforestation', 'charbon', 'nucléaire', 'plastique', 'chasse', 'recyclage','sécheresse'],
            "en" => ['garbage', 'deforestation', 'charcoal', 'nuclear', 'plastic', 'hunting', 'recycling', 'dryness']
        ];

        foreach($SolSubCategories["fr"] as $key => $val)
        {
            $subcat = new SubCategory();
            $subcat->setLibelle_fr($val);
            $subcat->setLibelle_en($SolSubCategories["en"][$key]);
            $subcat->setCategory($cats[2]);
            $manager->persist($subcat);
        }

        $manager->flush();
    }
}
