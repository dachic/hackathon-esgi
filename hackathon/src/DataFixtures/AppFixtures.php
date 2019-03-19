<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\SubCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public const CATEGORIES = ["EAU", "AIR", "TERRE"];

    public function load(ObjectManager $manager)
    {
        $cats = [];
        foreach (self::CATEGORIES as $category) 
        {
            $cat = (new Category())->setLibelle($category);
            $manager->persist($cat);
            array_push($cats, $cat);
        }

        $subCategoriesLibelles = 
        [
            0 => ['déchets', 'pétrole', 'chimique'],
            1 => ['usines', 'transports', 'habitations'],
            2 => ['déforestation','organique','pesticide']
        ];


        foreach($cats as $x => $category)
        {
            foreach($subCategoriesLibelles as $y => $value)
            {
                if($x == $y){
                    $subcat = new SubCategory();
                    $subcat->setLibelle($value[0]);
                    $subcat->setCategory($category);
                    $manager->persist($subcat);

                    $subcat = new SubCategory();
                    $subcat->setLibelle($value[1]);
                    $subcat->setCategory($category);
                    $manager->persist($subcat);

                    $subcat = new SubCategory();
                    $subcat->setLibelle($value[2]);
                    $subcat->setCategory($category);
                    $manager->persist($subcat);
                }
            
            }
        }
        $manager->flush();
    }
}
