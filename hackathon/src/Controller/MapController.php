<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\GetData;


class MapController extends AbstractController
{
    /**
     * @Route("/map", name="default")
    */
    public function index(GetData $data): Response
    {
        $test = $data->get("pollution déchets");
        dd($test);
        // return $this->render('index.html.twig');
    }
}
