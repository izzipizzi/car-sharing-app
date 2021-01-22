<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Entity\User;
use CarsType;
use Doctrine\ORM\EntityManagerInterface;
use FilterAdminOrdersType;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use OrdersType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;

use App\Entity\Cars;
use Symfony\Component\String\Slugger\SluggerInterface;

class OrdersController extends AbstractController
{
//    /**
//     * @Route("/cars", name="cars.list", methods={"GET"})
//     *
//     * @param EntityManagerInterface $em
//     * @return Response
//     */
//
//
//    public function list (EntityManagerInterface $em):Response{
////        $query = $em->createQuery('
////        SELECT cars from App:Cars cars WHERE cars.status = :status')->setParameter('status' ,'FREE');
////        $cars =$this->getDoctrine()->getRepository(Cars::class)->findAll();
//
//
//            $cars = $em->getRepository(Cars::class)->findAllCars();
////            $cars->getType()->getTypeName();
//
//            dump($cars);
//        return $this->render('cars/index.html.twig',['cars'=>$cars,]);
//    }

    /**
     * @Route("/order", name="orders.orderCar", methods={"POST"})
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param SluggerInterface $slugger
     * @return Response
     */
    public function orderCar(Request $request,EntityManagerInterface $em,SluggerInterface $slugger){
        $id = intval($request->query->get('id'));
//        dump($this->getUser()->getId());
        $order = new Orders();
        $form = $this->createForm(OrdersType::class,$order);
        $form->handleRequest($request);

        $car = $em->getRepository(Cars::class)->find($id);



        if ($form->isSubmitted()&&$form->isValid()){


            if($car->getStatus() === 'IN_USE'){
                return $this->redirectToRoute('cars.list');
            }
            $tariff = $form->get('tariff_id')->getData()->getPrice();
            $type = $car->getType()->getTypePrice();






            $time_from = $form->get('time_from')->getData();
            $location = $form->get('location')->getData();
            $time_to = $form->get('time_to')->getData();
            $date_from = $form->get('dateFrom')->getData();
            $price = 0;
            $hours = 0;

//            dump($this, $time_from->format('H'));


            if (intval($time_to->format('H')) > intval($time_from->format('H'))){
//                $diff = intval($time_to->format('H')) -  intval($time_from->format('H'));
                $diff  = date_diff($time_to,$time_from);
                $price = ((intval($diff->h) * 60 ) + intval($diff->i))*intval($tariff)*intval($type);
                $hours = intval($time_to->format('H')) -  intval($time_from->format('H'));

//                dump($diff,$price,$tariff,$type);


            }else{

                $time_to->add(new \DateInterval('P1D'));
                $diff  = date_diff($time_to,$time_from);
                $price = ((intval($diff->h) * 60 ) + intval($diff->i))*intval($tariff)*intval($type);
                $hours =( intval($time_to->format('H')) -  intval($time_from->format('H')) +24 );
                dump($diff,$price);


            }
            $em->getRepository(Cars::class)->updateCarStatus($id,'IN_USE');
            $triggerTimeHours = intval($time_to->format('H'))+$hours;
            $triggerTimeMinuts = intval($time_to->format('i'));



            dump($triggerTimeMinuts);
            dump(intval($time_to->format('i')));
            $em->getRepository(Cars::class)->updateCarDateToAndLocation($id,$date_from->add(new \DateInterval('PT'.$hours.'H')),$time_to->add(new \DateInterval('PT0H')),$location);
            $em->getRepository(Cars::class)->setExpiredTrigger($id,$date_from->add(new \DateInterval('PT'.$triggerTimeHours.'H'.$triggerTimeMinuts.'M')));



            $order->setCarId($car);
            $order->setPrice($price);
            $order->setClientId($this->getUser());
            $em->persist($order);
            $em->flush();

            return $this->redirectToRoute('user_orders');
        }
        return $this->render('orders/orderCar.html.twig', [
            'form'=>$form->createView(),
            'car'=>$car,
//            'time_from'=>$time_from,
//            'time_to'=>$time_to,
            'user'=>$this->getUser(),
            'error' => null,
        ]);


    }

    /**
     *
     * @Route ("/user/presonal/orders", name="orders.list")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     */

    public function userOrders (EntityManagerInterface $em,PaginatorInterface $paginator, Request $request):Response{
        $userID = $this->getUser()->getId();

        $dql   = "SELECT o FROM App:Orders o WHERE o.client_id =".$userID;
        $query = $em->createQuery($dql);

        $orders = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );

        return $this->render('orders/userList.html.twig',['orders'=>$orders,]);
    }

    /**
     *
     * @Route ("/admin/panel/orders", name="orders.adminOrders")
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function adminOrders(EntityManagerInterface $em,PaginatorInterface $paginator, Request $request,FilterBuilderUpdaterInterface $query_builder_updater):Response{
//        $query = $em->createQuery('
//        SELECT cars from App:Cars cars WHERE cars.status = :status')->setParameter('status' ,'FREE');
//        $cars =$this->getDoctrine()->getRepository(Cars::class)->findAll();


//            $cars = $em->getRepository(Cars::class)->findAllCars();
//            $cars->getType()->getTypeName();

        $repository = $this->getDoctrine()->getRepository('App:Orders');

        $form = $this->get('form.factory')->create(FilterAdminOrdersType::class);

        if ($request->query->has($form->getName())) {
            // manually bind values from the request
            $form->submit($request->query->get($form->getName()));
            $item_filter_params = $request->get('item_filter');

            // initialize a query builder
            $filterBuilder = $repository->createQueryBuilder('c');

            // build the query from the given form object
            $query_builder_updater->addFilterConditions($form, $filterBuilder);
//            $filterBuilder->setParameter('p_c_type_id',$item_filter_params['type_id']);

            $dql   = $filterBuilder->getQuery();
            $query = $filterBuilder->getQuery();
            $orders = $paginator->paginate(
                $query, /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                6 /*limit per page*/
            );

        }else{
            $dql   = "SELECT c FROM App:Orders c ORDER BY c.id ASC";
//        $dql   = $filterBuilder->getDql();
            $query = $em->createQuery($dql);

            $orders = $paginator->paginate(
                $query, /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                6 /*limit per page*/
            );


        }



        return $this->render('orders/adminOrderList.html.twig',['orders'=>$orders, 'form' => $form->createView()]);
    }




    /**
     * @Route("/user/presonal/orders/{id}", name="orders.orderByID", requirements={"id"="\d+"}, methods={"GET"})
     * @param Orders $order
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function orderByID(Orders $order):Response{
        return $this->render('orders/orderByID.html.twig',['order'=>$order]);
    }

}
