<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Brand;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/", name="car_")
 */
class adminCarController extends Controller
{
    /**
     * @Route("/{carId}", name="show", requirements={"carId"="\d+"})
     */
    public function show(EntityManagerInterface $entityManager, $carId = null)
    {
        $cars = $entityManager->getRepository(Car::class)->findAll();

        if(!empty($carId)){
            $currentCar = $entityManager->getRepository(Car::class)->find($carId);
            $brand = $entityManager->getRepository(Brand::class)->find($carId);
            return $this->render("car.html.twig",['cars' => $cars, 'currentCar' => $currentCar, 'brand' => $brand] );
        }

        if (empty($currentCar)){
            $currentCar = current($cars);
            return $this->render("car.html.twig",['cars' => $cars, 'currentCar' => $currentCar] );
        }


    }

    /**
     * @Route("/new", methods="POST", name="create")
     */
    public function create(EntityManagerInterface $entityManager,Request $request)
    {

        $brand = $request->get('id_brand');
        if (empty(($brand))) {
            $this->addFlash(
                "warning",
                "L'id de la marque est obligatoire"
            );
            return $this->redirectToRoute('car_show');
        }
        $id_brand = $entityManager->getRepository(Brand::class)->find($brand);

        $motorisation = $request->get('motorisation');
        if (empty(($motorisation))) {
            $this->addFlash(
                "warning",
                "La motorisation est obligatoire"
            );
            return $this->redirectToRoute('car_show');
        }

        $fuel = $request->get('fuel');
        if (empty(($fuel))) {
            $this->addFlash(
                "warning",
                "Le fuel est obligatoire"
            );
            return $this->redirectToRoute('car_show');
        }

        $type = $request->get('type');
        if (empty(($type))) {
            $this->addFlash(
                "warning",
                "Le type est obligatoire"
            );
            return $this->redirectToRoute('car_show');
        }

        $color = $request->get('color');
        if (empty(($color))) {
            $this->addFlash(
                "warning",
                "La couleur est obligatoire"
            );
            return $this->redirectToRoute('car_show');
        }

        $transmission = $request->get('transmission');
        if (empty(($transmission))) {
            $this->addFlash(
                "warning",
                "La transmission est obligatoire"
            );
            return $this->redirectToRoute('car_show');
        }

        $driven = $request->get('driven');
        if (empty(($driven))) {
            $this->addFlash(
                "L'année est obligatoire"
            );
            return $this->redirectToRoute('car_show');
        }

        $car = new Car();
        $car->setIdBrand($id_brand);
        $car->setMotorisation($motorisation);
        $car->setFuel($fuel);
        $car->setType($type);
        $car->setColor($color);
        $car->setTransmission($transmission);
        $car->setDriven($driven);

        try {
            $entityManager->persist($car);
            $entityManager->flush();

            $this->addFlash(
                "success",
                "La voiture - $motorisation - a été créée avec succès"
            );
        }catch (UniqueConstraintViolationException $e){
            $this->addFlash(
                "warning",
                "Impossible de créer deux fois la même voiture -- $motorisation --"
            );
            //return $this->redirectToRoute('listing_show');
        }

        //return new Response("OK");
        return $this->redirectToRoute("car_show");
    }

    /**
     * @Route("/{carId}/delete", name="delete", requirements={"carId"="\d+"})
     */
    public function delete(EntityManagerInterface $entityManager, $carId)
    {
        $cars = $entityManager->getRepository(Car::class)->find($carId);

        if(empty($cars)){
            $this->addFlash(
                "warning",
                "Impossible de supprimer la tâche"
            );
        }else {
            $entityManager->remove($cars);
            $entityManager->flush();

            //$brand = $entityManager->getRepository(Brand::class)->find($carId);
            //$mark = $brand->getName();
            $name = $cars->getMotorisation();

            $this->addFlash(
                "success",
                "La voiture - $name - a été supprimé avec succès"
            );
            return $this->redirectToRoute("car_show");
        }
    }

}