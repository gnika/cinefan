<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomepageControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();//simule le navigateur
        $container = $client->getContainer();
        $crawler = $client->request('GET', '/fr/');//récupère le DOM de la page


        $this->assertEquals(200, $client->getResponse()->getStatusCode());//le statut est bien à 200
        $this->assertContains('Welcome to Cinefan', $crawler->filter('.container h1')->text());//le h1 contiens le bon titre
        $this->assertCount(1, $crawler->filter('h1'));//il n'y a qu'un seul h1 dans la page
        $this->assertTrue($crawler->filter(".col-xs-3")->count() === 1);//il n'y a qu'un .col-xs-3 dans la page

        $link = $crawler->selectLink('LOGIN')->link();

        $crawler = $client->click($link);//récupère le DOM de la page LOGIN
        $this->assertEquals(200, $client->getResponse()->getStatusCode());//le statut est bien à 200, donc le lien existe
        $this->assertCount(3, $crawler->filter('input'));//combien d'input dans la page
        //ajax pas testable par phpunit
    }
}
