<?php

namespace AppBundle\Controller;

use AppBundle\Repository\EmployeeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class EmployeeAPIController extends Controller
{
    /**
     * @Route("/api/employees")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $city = $request->query->get('city');
        $categoryId = $request->query->get('categoryId');

        /** @var EmployeeRepository $employeeRepo */
        $employeeRepo = $this->getDoctrine()->getRepository('AppBundle:Employee');
        $employees = $employeeRepo->findByCategoryAndCity($categoryId, $city);
        $response = new JsonResponse();
        $response->setData($employees);

        return $response;
    }
}