<?php

namespace App\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class PingController extends FOSRestController
{
    /**
     * @Rest\Get("/ping")
     * @return View
     */
    public function ping(): View
    {
        return View::create(
            ['healthy' => 'true'],
            Response::HTTP_OK
        );
    }
}
