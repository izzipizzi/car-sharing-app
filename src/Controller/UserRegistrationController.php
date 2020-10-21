<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserRegistrationController extends AbstractController
{
    private $encoder;

    /**
     * @Route("/signup", name="user_registration")
     * @param UserPasswordEncoderInterface $encoder
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createUser(UserPasswordEncoderInterface $encoder,Request $request,EntityManagerInterface $em)
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }
        $user = new User();
        $user->setRoles(['ROLE_USER']);
        $form = $this->createForm(\UserType::class,$user);


        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $user= $form->getData();
//            $encoder = $this->get('security.encoder_factory')->getEncoder($user);
//            $encodedPassword = $encoder->encodePassword($form->get('password'));
            $user->setPassword($encoder->encodePassword($user, $form->get('password')->getData()));
            $em->persist($user);
            $em->flush();


            return $this->redirectToRoute('login');
        }
        return $this->render('user_registration/index.html.twig', [
            'form'=>$form->createView(),
        ]);
    }
}
