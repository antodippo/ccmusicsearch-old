<?php

namespace App\Controller;

use App\Model\Search;
use App\Service\SearchPerformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class CCMusicSearchController extends AbstractController
{
    public function index(Request $request, SearchPerformer $searchPerformer)
    {
        $form = $this->createFormBuilder(new Search())
            ->add('searchString', TextType::class)
            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        $songs = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $filters = ['tag' => $form->getData()->getSearchString()];
            $songs = $searchPerformer->search($filters);
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
