<?php

namespace App\Controller;

use App\Model\Search;
use App\Service\ApiServiceFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class CCMusicSearchController extends AbstractController
{
    public function index(Request $request, ApiServiceFactory $apiServiceFactory)
    {
        $songs = [];

        $form = $this->createFormBuilder(new Search())
            ->add('searchString', TextType::class)
            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $filters = ['tag' => $form->getData()->getSearchString()];
            $apiServices = $this->getParameter('api_services');
            foreach ($apiServices as $serviceName => $serviceId) {
                $songs = array_merge(
                    $songs,
                    $apiServiceFactory->createService($serviceId)->getSongRecords($filters)
                );
            }
        }

        return $this->render('Default/index.html.twig', [
            'form' => $form->createView(),
            'songs' => $songs
        ]);
    }

    public function about()
    {
        return $this->render('Default/about.html.twig');
    }
}
