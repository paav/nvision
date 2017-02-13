<?php

namespace AppBundle\Controller;

use AppBundle\Enum\EmployeeCategory;
use AppBundle\Form\EmployeeFileType;
use AppBundle\Form\InputDataType;
use AppBundle\Model\EmployeeFile;
use AppBundle\Base\InputData;
use AppBundle\Repository\EmployeeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     * @param Request $request
     * @return Response|RedirectResponse
     */
    public function indexAction(Request $request)
    {
        /** @var EmployeeRepository $employeeRepo */
        $employeeRepo = $this->getDoctrine()->getRepository('AppBundle:Employee');
        $cities = $employeeRepo->findCitiesSplitByCategories([
            EmployeeCategory::RegionalNetworkRepairing,
            EmployeeCategory::ClientService,
            EmployeeCategory::ClientServiceHeads
        ]);

        return $this->render('default/index.html.twig', compact('cities'));
    }

    /**
     * @Route("/uploads", name="uploads")
     * @param Request $request
     * @return Response|RedirectResponse
     */
    public function uploadsAction(Request $request)
    {
        $inputData = new InputData();
        $form = $this->createForm(InputDataType::class, $inputData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employees = $inputData->toArrayOfEmployees();
            $employeeStore = $this->get('employee_store');
            $employeeStore->bulkInsert($employees);

            return $this->redirect($this->generateUrl('home'));
        }

        $fileForm = $form->createView();

        return $this->render('default/upload_create.html.twig', compact('fileForm'));
    }
}
