<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SearchControllerTest extends WebTestCase
{
    public function testindex()
    {
        /*TEST DE LOGIN*/

        $client = static::createClient();//simule le navigateur
        $container = $client->getContainer();
        $crawler = $client->request('GET', '/fr/search');//récupère le DOM de la page
        $form = $crawler->selectButton('Submit')->form([ //on rempli le formulaire de la page
            'search' => 'ben'
        ]);


        $client->submit($form);


        $this->assertEquals(200, $client->getResponse()->getStatusCode());//le statut est bien à 200
//        $this->assertContains('Welcome to Cinefan', $crawler->filter('.container h1')->text());//le h1 contiens le bon titre
        $this->assertCount(1, $crawler->filter('.table-inverse tr'));

    }
}
