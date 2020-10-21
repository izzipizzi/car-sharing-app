<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    private $em;

    public function __construct(UserPasswordEncoderInterface $encoder, EntityManagerInterface $entityManager)
    {
        $this->encoder = $encoder;
        $this->em = $entityManager;
    }

    public function load(\Doctrine\Persistence\ObjectManager $manager)
    {
        $usersData = [
              0 => [
                  'name' => 'andrii',
                  'surname' => 'kirchei',
                  'password' => 123456,
                  'phone' => '0988581107',
                  'city' => 'Drohobych',
                  'street' => 'Stryiska',
                  'house' => 11,
                  'flat' => 9,
                  'email' => 'user@gmail.com',
                  'role' => ['ROLE_USER'],
              ]
        ];

        foreach ($usersData as $user) {
            $newUser = new User();
            $newUser->setName($user['name']);
            $newUser->setSurname($user['surname']);
            $newUser->setPhone($user['phone']);
            $newUser->setCity($user['city']);
            $newUser->setStreet($user['street']);
            $newUser->setHouse($user['house']);
            $newUser->setFlat($user['flat']);
            $newUser->setEmail($user['email']);
            $newUser->setPassword($this->encoder->encodePassword($newUser, $user['password']));
            $newUser->setRoles($user['role']);
            $this->em->persist($newUser);
        }

        $this->em->flush();
    }
}