<?php

namespace CCMusicSearchBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAbout()
    {
        $client = static::createClient();
        $client->request('GET', '/about');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testIndexForm()
    {
        $client = parent::createClient();
        $indexRoute = $client->getContainer()->get('router')->generate('homepage');
        $crawler = $client->request("GET", $indexRoute);

        $form = $crawler->filter("form[name=search]")->form();
        $client->submit($form, array('search[tag]' => 'test'));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }

}
