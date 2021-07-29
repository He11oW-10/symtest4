<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use App\Entity\Cars;
use App\Repository\ProductRepository;

class CarsController extends AbstractController
{


    public function addcar(string $modeltest, string $pricetest):Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $newcar=new Cars();
        $newcar->setModel($modeltest);
        $newcar->setPrice($pricetest);
        $entityManager->persist($newcar);
        $entityManager->flush();

        return new Response('Saved new product with id '.$newcar->getId());
    }

    public function listcar():Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repo =  $entityManager->createQuery('SELECT c from App\Entity\Cars c')->getArrayResult();
     
        $response=new Response(json_encode($repo));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function getcarbyID(string $inputid):Response
    {
        $result = $this->getDoctrine()
        ->getRepository(Cars::class)
        ->find($inputid);

        if (!$result) {
            throw $this->createNotFoundException(
                'No product found for id '.$inputid
            );
        }
        $resp=new Response();
        $resp->setContent(json_encode(['model'=>$result->getModel(), 'price'=>$result->getPrice()]));
        return $resp;    

    }
}
