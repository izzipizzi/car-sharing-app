<?php

namespace App\DataFixtures;

use App\Entity\Cars;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CarsFixtures extends Fixture
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
        $carsData = [
            0 => [
                'name' => 'Audi',
                'model' => 'A6',
                'color' => 'Red',
                'year' => 2008,
                'status' => 'FREE',
                'photo' =>'../images/cars/audi-a6.jpg'
            ],
            1 => [
                'name' => 'Toyota',
                'model' => 'Land Cruiser',
                'color' => 'Black',
                'year' => 2018,
                'status' => 'FREE',
                'photo' =>'../images/cars/toyota_land-cruiser-200.jpg'

            ],
            2 => [
                'name' => 'Audi',
                'model' => 'TT',
                'color' => 'Red',
                'year' => 2015,
                'status' => 'IN_USE',
                'photo' =>'../images/cars/audi_tt.jpg'

            ],
            3 => [
                'name' => 'Volkswagen',
                'model' => 'Passat B6',
                'color' => 'Black',
                'year' => 2018,
                'status' => 'FREE',
                'photo' =>'../images/cars/passat.jpeg'

            ],
            4 => [
                'name' => 'BMW',
                'model' => 'M5',
                'color' => 'Blue',
                'year' => 2012,
                'status' => 'FREE',
                'photo' =>'../images/cars/bmw_m5_6.jpg'

            ],
        ];

        foreach ($carsData as $car) {
            $newCar = new Cars();
            $newCar->setName($car['name']);
            $newCar->setModel($car['model']);
            $newCar->setColor($car['color']);
            $newCar->setYear($car['year']);
            $newCar->setStatus($car['status']);
            $newCar->setPhot($car['photo']);
            $this->em->persist($newCar);
        }

        $this->em->flush();
    }
}