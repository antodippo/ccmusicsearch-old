<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CCMusicSearchControllerTest extends WebTestCase
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
        $indexRoute = $client->getContainer()->get('router')->generate('index');
        $crawler = $client->request("GET", $indexRoute);

        $form = $crawler->filter('form[name=form]')->form();
        $client->submit($form, array('form[searchString]' => 'test'));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
