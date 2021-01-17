<?php


namespace App\Controller;


use App\Entity\CarTypes;
use App\Entity\Tariff;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class CarTypesController extends AbstractController
{

    /**
     *
     * @Route ("/admin/panel/car_type/add", name="car_type.add")
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param SluggerInterface $slugger
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addCarType(Request $request,EntityManagerInterface $em,SluggerInterface $slugger){



        $type = new CarTypes();
        $form = $this->createForm(\CarTypesType::class,$type);
        $form->handleRequest($request);


        if ($form->isSubmitted()&&$form->isValid()){

            $em->persist($type);
            $em->flush();


            return $this->redirectToRoute('car_type.add');
        }
        return $this->render('admin_panel/add_car_type.html.twig', [
            'form'=>$form->createView(),
            'error' => null,
        ]);

    }

}