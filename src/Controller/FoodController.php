<?php

namespace App\Controller;

use App\Entity\Food;
use App\Repository\FoodRepository;
use Doctrine\ORM\ORMException;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\ConstraintViolationList;

class FoodController extends FOSRestController
{
    /**
     * @var FoodRepository - Access/Manage food resource in DB
     */
    private $foodRepository;

    /**
     * FoodController constructor.
     * @param FoodRepository $foodRepository
     */
    public function __construct(FoodRepository $foodRepository)
    {
        $this->foodRepository = $foodRepository;
    }

    /**
     * List food entities from database
     * @Rest\Get("/food")
     * @Rest\View(StatusCode = 200)
     */
    public function index(): array
    {
        $foodEntities = $this->foodRepository->findAll();
        $exportFood = [];

        foreach ($foodEntities as $foodEntity) {
            $exportFood[] = $foodEntity->getExportableAttributes();
        }

        return $exportFood;
    }

    /**
     * @Rest\Get("/food/{foodId}")
     * @Rest\View(StatusCode = 200)
     * @param int $foodId
     * @return array
     */
    public function details(int $foodId): array
    {
        $food = $this->foodRepository->find($foodId);

        if (empty($food)) {
            throw new NotFoundHttpException('Food not found');
        }

        return $food->getExportableAttributes();
    }

    /**
     * @Rest\Delete("/food/{foodId}")
     * @Rest\View(StatusCode = 200)
     * @param int $foodId
     * @return array
     * @throws InternalErrorException
     * @throws NotFoundHttpException
     */
    public function delete(int $foodId): array
    {
        try {
            $food = $this->foodRepository->findByIdAndDelete($foodId);
        } catch (ORMException $e) {
            throw new InternalErrorException('Error while connecting to Database');
        }

        if (empty($food)) {
            throw new NotFoundHttpException('Food Not found');
        }

        return $food->getExportableAttributes();
    }

    /**
     * @Rest\Post("/food")
     * @Rest\View(StatusCode = 201)
     * @param Food $food
     * @param ConstraintViolationList $violations
     * @return array
     * @ParamConverter("food", converter="fos_rest.request_body")
     * @throws InternalErrorException
     */
    public function create(Food $food, ConstraintViolationList $violations): array
    {
        if (count($violations)) {
            throw new BadRequestHttpException($violations);
        }

        try {
            $exportFood = $this->foodRepository->save($food);
        } catch (ORMException $exception) {
            throw new InternalErrorException('Error while connecting to database');
        }

        return $exportFood->getExportableAttributes();
    }

    /**
     * @Rest\Patch("/food/{foodId}")
     * @Rest\View(StatusCode = 200)
     * @ParamConverter("food", converter="fos_rest.request_body")
     * @param Food $food
     * @return array
     */
    public function update(Food $food): array
    {

        return $food->getExportableAttributes();
    }
}
