<?php

namespace App\Controller;

use App\Entity\User;
use CarsType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;

use App\Entity\Cars;
use Symfony\Component\String\Slugger\SluggerInterface;

class CarsController extends AbstractController
{
    /**
     * @Route("/cars", name="cars.list", methods={"GET"})
     *
     * @param EntityManagerInterface $em
     * @return Response
     */


    public function list (EntityManagerInterface $em):Response{
//        $query = $em->createQuery('
//        SELECT cars from App:Cars cars WHERE cars.status = :status')->setParameter('status' ,'FREE');
//        $cars =$this->getDoctrine()->getRepository(Cars::class)->findAll();


            $cars = $em->getRepository(Cars::class)->findAllCars();
//            $cars->getType()->getTypeName();

            dump($cars);
        return $this->render('cars/index.html.twig',['cars'=>$cars,]);
    }

    /**
     * @Route("/cars/{id}", name="cars.carByID", requirements={"id"="\d+"}, methods={"GET"})
     * @param Cars $car
     * @return Response
     */
    public function carByID(Cars $car):Response{
       return $this->render('cars/carByID.html.twig',['car'=>$car]);
    }
/**
     * @Route("/admin/panel/cars/update/{id}", name="cars.updateCarByID", requirements={"id"="\d+"})
     * @param Cars $car
     * @return Response
     */
    public function updateCarByID(Cars $car):Response{
       return $this->render('cars/updateCarByID.html.twig',['car'=>$car]);
    }

    /**
     *
     * @Route ("/admin/panel/cars/add", name="cars.add")
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param SluggerInterface $slugger
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addCar(Request $request,EntityManagerInterface $em,SluggerInterface $slugger){



        $car = new Cars();
        $form = $this->createForm(CarsType::class,$car);
        $form->handleRequest($request);


        if ($form->isSubmitted()&&$form->isValid()){
            $car_photo =$form->get('photo')->getData();
            if ($car_photo){
                $original_filename=pathinfo($car_photo->getClientOriginalName(),PATHINFO_FILENAME);
                $safe_filename = $slugger->slug($original_filename);
                $new_filename =$safe_filename.'-'.uniqid().'.'.$car_photo->guessExtension();

                try {
                    $car_photo->move($this->getParameter('car_photos'),$new_filename);

                }catch (FileException $exception){
                    return $this->render('cars/add.html.twig', [
                        'error' => 'Something happend while uploading file',
                        'form'=>$form->createView(),
                    ]);
                }

                $car->setPhoto('/images/cars/'.$new_filename);
            }


            $car->setStatus('FREE');
            $em->persist($car);
            $em->flush();


            return $this->redirectToRoute('cars_add');
        }
        return $this->render('cars/add.html.twig', [
            'form'=>$form->createView(),
            'error' => null,
        ]);

    }

    /**
     *
     * @Route ("/admin/panel/cars/update", name="cars.update")
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param SluggerInterface $slugger
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */

  public function updateCar(EntityManagerInterface $em):Response{
      $cars = $em->getRepository(Cars::class)->findAllCars();
      return $this->render('cars/updateList.html.twig',['cars'=>$cars]);


  }
}
