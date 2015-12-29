<?php

namespace CCMusicSearchBundle\Controller;

use CCMusicSearchBundle\Type\SearchType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $searchForm = $this->createForm(new SearchType());
        $searchForm->handleRequest($request);
        $songs = array();

        if ($searchForm->isValid()) {
            $filters = array('tag' => $searchForm->get('tag')->getData());
            $apiServices = $this->getParameter('api_services');
            foreach ($apiServices as $serviceName => $serviceId) {
                $songs = array_merge($songs, $this->get($serviceId)->getSongRecords($filters));
            }
        }

        return array(
            'form' => $searchForm->createView(),
            'songs' => $songs
        );
    }

    /**
     * @Route("/about", name="about")
     * @Template()
     */
    public function aboutAction(Request $request)
    {
        return array();
    }
}
