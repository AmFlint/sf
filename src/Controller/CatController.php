<?php

namespace App\Controller;

use App\Entity\Cat;
use App\Repository\CatRepository;
use Doctrine\ORM\ORMException;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\ConstraintViolationList;

class CatController extends FOSRestController
{
    /**
     * @var CatRepository $catRepository
     */
    private $catRepository;

    /**
     * CatController constructor.
     * @param CatRepository $catRepository
     */
    public function __construct(CatRepository $catRepository){
        $this->catRepository = $catRepository;
    }

    /**
     * @Rest\Get("/cat")
     * @param Request $request
     * @return View
     */
    public function list(Request $request): View
    {
        // TODO: Add pagination
        $cats = $this->catRepository->findAll();
        // get Exportable attributes for each cat Entity
        $exportableCats = [];
        foreach ($cats as $cat) {
            $exportableCats[] = $cat->getExportableAttributes();
        }

        return View::create(
            $exportableCats,
            Response::HTTP_OK
        );
    }

    /**
     * Get informations on a single cat according to given cat id
     * @Rest\Get("/cat/{catId}")
     * @Rest\View(StatusCode = 200)
     * @param int $catId
     * @throws NotFoundHttpException
     * @return array
     */
    public function details(int $catId)
    {
        $cat = $this->catRepository->find($catId);
        if (empty($cat)) {
            throw new NotFoundHttpException('Cat Not Found');
        }

        return $cat->getExportableAttributes();
    }

    /**
     * Route to create a Cat resource in Database
     * @Rest\Post("/cat")
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("cat", converter="fos_rest.request_body")
     * @param Cat $cat
     * @param ConstraintViolationList $violations
     * @return array
     */
    public function create(Cat $cat, ConstraintViolationList $violations): array
    {
        if (count($violations)) {
            throw new BadRequestHttpException($violations);
        }


        return $cat->getExportableAttributes();
    }

    /**
     * Delete a cat resource from database
     * @Rest\Delete("/cat/{catId}")
     * @Rest\View(StatusCode = 200)
     * @param int $catId
     * @throws InternalErrorException
     * @throws NotFoundHttpException
     * @return array
     */
    public function delete(int $catId)
    {
        $cat = $this->catRepository->find($catId);
        // Cat not found
        if (empty($cat)) {
            throw new NotFoundHttpException('Cat Not found');
        }

        // Try to remove cat and get Found cat entity
        try {
            $cat = $this->catRepository->findByIdAndDelete($catId);
        } catch (ORMException $e) { // In case can't access database
            throw new InternalErrorException();
        }

        // If cat was not found, throw not found exception
        if (empty($cat)) {
            throw new NotFoundHttpException('Cat not found');
        }

        // Cat found and deleted properly, return attributes of deleted entity
        return $cat->getExportableAttributes();
    }
}
