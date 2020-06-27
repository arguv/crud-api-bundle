<?php

namespace Arguv\CrudApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Arguv\CrudApiBundle\Entity\Product;

//use Arguv\CrudApiBundle\Controller\ProductControllerTrait;

class CrudApiController extends Controller
{

    use ProductControllerTrait;

    /**
     * @Route("/arguv/list")
     * @return JsonResponse
     */
    public function indexAction()
    {
        try {
            $response = $this->getEntityRepository()->findAllProducts();

            return new JsonResponse(array('result' => 'success', 'description' => 'Get All Records', 'code' => 200, 'data' => $response));
        } catch (\Exception $e) {
            return new JsonResponse(array('result' => 'error', 'description' => $e->getMessage(), 'code' => $e->getCode(), 'data' => []));
        }
    }

    /**
     * @Route("/arguv/list/{id}")
     * @param $id
     * @return JsonResponse
     */
    public function singleAction($id)
    {
        try {
            $response = $this->getEntityRepository()->findProduct($id);

            return new JsonResponse(array('result' => 'success', 'description' => 'Get Single Record', 'code' => 200, 'data' => $response));
        } catch (\Exception $e) {
            return new JsonResponse(array('result' => 'error', 'description' => $e->getMessage(), 'code' => $e->getCode(), 'data' => []));
        }
    }

    /**
     * @Route("/arguv/create")
     * @param Request $request
     * @return JsonResponse
     */
    public function createAction(Request $request)
    {
        try {
            $entity = $this->getProductManager()->createNewEntity();
            $data = json_decode($request->getContent(), true);
            $this->getProductManager()->insertEntity($entity, $data);

            return new JsonResponse(array('result' => 'success', 'description' => 'Create New Record', 'code' => 200, 'data' => 'Record created successfully'));

        } catch (\Exception $e) {
            return new JsonResponse(array('result' => 'error', 'description' => $e->getMessage(), 'code' => $e->getCode(), 'data' => []));
        }
    }

    /**
     * @Route("/arguv/update/{id}")
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function updateAction(Request $request, $id)
    {
        try {
            $entity = $this->getEntityRepository()->find($id);
            if (!$entity instanceof Product) {
                return new JsonResponse('No product found in the database with the given id - ' . $id);
            }

            $data = json_decode($request->getContent(), true);
            $this->getProductManager()->updateEntity($entity, $data);

            return new JsonResponse(array('result' => 'success', 'description' => 'Update exist Record', 'code' => 200, 'data' => 'Record updated successfully'));

        } catch (\Exception $e) {
            return new JsonResponse(array('result' => 'error', 'description' => $e->getMessage(), 'code' => $e->getCode(), 'data' => []));
        }
    }

    /**
     * @Route("/arguv/delete/{id}")
     * @param $id
     * @return JsonResponse
     */
    public function deleteAction($id)
    {
        try {
            $entity = $this->getEntityRepository()->find($id);
            if (!$entity instanceof Product) {
                return new JsonResponse('No product found in the database with the given id - ' . $id);
            }

            $this->getProductManager()->deleteEntity($entity);

            return new JsonResponse(array('result' => 'success', 'description' => 'Delete Exist Record', 'code' => 200, 'data' => 'Record deleted successfully'));

        } catch (\Exception $e) {
            return new JsonResponse(array('result' => 'error', 'description' => $e->getMessage(), 'code' => $e->getCode(), 'data' => []));
        }
    }
}