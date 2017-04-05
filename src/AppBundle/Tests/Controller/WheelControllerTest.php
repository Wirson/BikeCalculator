<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WheelControllerTest extends WebTestCase
{
    public function testCalculate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/calculate');
    }

}
