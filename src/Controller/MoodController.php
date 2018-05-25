<?php

namespace App\Controller;

use App\Entity\Mood;
use App\Form\MoodType;
use App\Repository\MoodRepository;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoodController extends FOSRestController
{
    private $moodRepotory;


    public function __construct(MoodRepository $moodRepository)
    {
        $this->moodRepotory = $moodRepository;
    }

    /**
     * @Rest\Get("/mood")
     * @Rest\View(StatusCode = 200)
     */
    public function list()
    {
        $moods = $this->moodRepotory->findAll();

        $exportableMoods = [];

        foreach ($moods as $mood) {
           $exportableMoods =  $mood->getExportableAttributes();
        }

        return $exportableMoods;
    }

    /**
     * @param $moodId
     */
    public function findById($moodId) {

    }

}
