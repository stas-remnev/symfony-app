<?php

namespace App\Controller;

use App\Repository\ConferenceRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use Twig\Environment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Routing\Annotation\Route;

class RestController extends AbstractFOSRestController
{
    private $twig;

    public function __construct(Environment $twig, EntityManagerInterface $entityManager)
    {
        $this->twig = $twig;
        $this->entityManager = $entityManager;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Rest\Get("/conferences", name="get_conferences")
     * @View(serializerGroups={"conference"})
     */
    public function getConferences(ConferenceRepository $conferenceRepository)
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        
        $serializer = new Serializer($normalizers, $encoders);

        $conferences = $conferenceRepository->findAll();

        $jsonContent = $serializer->serialize($conferences, 'json', ['groups' => ['conreferences']]);

        return new Response();

    }
}
