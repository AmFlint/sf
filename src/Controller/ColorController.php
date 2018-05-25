<?php

namespace App\Controller;

use App\Entity\Color;
use App\Repository\ColorRepository;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;

class ColorController extends FOSRestController
{
    private $colorRepository;

    public function __construct(ColorRepository $colorRepository)
    {
        $this->colorRepository = $colorRepository;
    }

    /**
     * @Rest\Get("/colors")
     * @Rest\View(StatusCode = 200)
     * @return array
     */
    public function index(): array
    {
        $colors = $this->colorRepository->findAll();
        $exportColors = [];

        foreach ($colors as $color) {
            $exportColors[] = $color->getExportableAttributes();
        }

        return $exportColors;
    }

    /**
     * @Rest\Get("/colors/{colorId}")
     * @Rest\View(StatusCode = 200)
     * @param int $colorId
     * @return array
     */
    public function details(int $colorId): array
    {
        $color = $this->colorRepository->find($colorId);

        if (empty($color)) {
            throw new NotFoundHttpException('Color not found');
        }

        return $color->getExportableAttributes();
    }

    /**
     * @Rest\Delete("/colors/{colorId}")
     * @Rest\View(StatusCode = 200)
     * @param int $colorId
     * @return array
     */
    public function delete(int $colorId): array
    {

    }

    /**
     * @Rest\Patch("/colors/{colorId}")
     * @Rest\View(StatusCode = 200)
     * @return array
     */
    public function update(): array
    {

    }

    /**
     * @Rest\Post("/colors")
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("color", converter="fos_rest.request_body")
     * @param Color $color
     * @param ConstraintViolationList $violations
     * @return array
     */
    public function create(Color $color, ConstraintViolationList $violations): array
    {
        if (count($violations)) {
            throw new BadRequestHttpException($violations);
        }


        return $color->getExportableAttributes();
    }
}
