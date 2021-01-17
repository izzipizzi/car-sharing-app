<?php


namespace App\Controller;


use App\Entity\Tariff;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class TariffController extends AbstractController
{

    /**
     *
     * @Route ("/admin/panel/tariff/add", name="tariff.add")
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param SluggerInterface $slugger
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addTariff(Request $request,EntityManagerInterface $em,SluggerInterface $slugger){



        $tariff = new Tariff();
        $form = $this->createForm(\TariffType::class,$tariff);
        $form->handleRequest($request);


        if ($form->isSubmitted()&&$form->isValid()){

            $em->persist($tariff);
            $em->flush();


            return $this->redirectToRoute('tariff_add');
        }
        return $this->render('admin_panel/add_tariff.html.twig', [
            'form'=>$form->createView(),
            'error' => null,
        ]);

    }

}