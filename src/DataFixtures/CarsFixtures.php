<?php

namespace App\DataFixtures;

use App\Entity\Cars;
use App\Entity\CarTypes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CarsFixtures extends Fixture
{
    private $encoder;

    private $em;

    private $car_type ;

    public function __construct(UserPasswordEncoderInterface $encoder, EntityManagerInterface $entityManager)
    {
        $this->encoder = $encoder;
        $this->em = $entityManager;
    }

    public function load(\Doctrine\Persistence\ObjectManager $manager)
    {
        $car_type = new CarTypes();
        $carsData = [
            0 => [
                'name' => 'Audi',
                'model' => 'A6',
                'color' => 'Red',
                'year' => 2008,
                'status' => 'FREE',
                'photo' =>'../images/cars/audi-a6.jpg',
                'dateTo' =>new \DateTime('now'),
                'time_to' => new \DateTime('now'),
                'location' => 'Дрогобич офіс',
                'type' =>$car_type

        ],
            1 => [
                'name' => 'Toyota',
                'model' => 'Land Cruiser',
                'color' => 'Black',
                'year' => 2018,
                'status' => 'FREE',
                'photo' =>'../images/cars/toyota_land-cruiser-200.jpg',
                'dateTo' => new \DateTime('now'),
                'time_to' => new \DateTime('now'),
                'location' => 'Дрогобич офіс',
                'type' => $car_type

            ],
            2 => [
                'name' => 'Audi',
                'model' => 'TT',
                'color' => 'Red',
                'year' => 2015,
                'status' => 'IN_USE',
                'photo' =>'../images/cars/audi_tt.jpg',
                'dateTo' => new \DateTime('now'),
                'time_to' => new \DateTime('now'),
                'location' => 'Дрогобич офіс',
                'type' => $car_type

            ],
            3 => [
                'name' => 'Volkswagen',
                'model' => 'Passat B6',
                'color' => 'Black',
                'year' => 2018,
                'status' => 'FREE',
                'photo' =>'../images/cars/passat.jpeg',
                'dateTo' => new \DateTime('now'),
                'time_to' => new \DateTime('now'),
                'location' => 'Дрогобич офіс',
                'type' => $car_type

            ],
            4 => [
                'name' => 'BMW',
                'model' => 'M5',
                'color' => 'Blue',
                'year' => 2012,
                'status' => 'FREE',
                'photo' =>'../images/cars/bmw_m5_6.jpg',
                'dateTo' => new \DateTime('now'),
                'time_to' => new \DateTime('now'),
                'location' => 'Дрогобич офіс',
                'type' => $car_type

            ],
        ];

        foreach ($carsData as $car) {
            $newCar = new Cars();
            $newCar->setName($car['name']);
            $newCar->setModel($car['model']);
            $newCar->setColor($car['color']);
            $newCar->setYear($car['year']);
            $newCar->setStatus($car['status']);
            $newCar->setPhoto($car['photo']);
            $newCar->setDateTo($car['dateTo']);
            $newCar->setTimeTo($car['time_to']);
            $newCar->setLocation($car['location']);
//            $newCar->setType($car['type']);
            $this->em->persist($newCar);
        }

        $this->em->flush();
    }
}