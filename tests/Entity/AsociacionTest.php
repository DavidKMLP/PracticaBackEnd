<?php

declare(strict_types=1);

namespace TDW\ACiencia\Tests\Entity;

use DateTime;
use PHPUnit\Framework\TestCase;
use TDW\ACiencia\Entity\Asociacion;
use TDW\ACiencia\Entity\Entity;

class AsociacionTest extends TestCase
{
    public function testConstructor(): void
    {
        $name = "Asociación Española de IA";
        $url = "https://asocia-eia.org";
        $birthDate = new DateTime("2000-01-01");

        $asociacion = new Asociacion($name, $url, $birthDate);

        $this->assertSame($name, $asociacion->getName());
        $this->assertSame($url, $asociacion->getWebUrl());
        $this->assertEquals($birthDate, $asociacion->getBirthDate());
        $this->assertCount(0, $asociacion->getEntidades());
    }

    public function testAddAndRemoveEntity(): void
    {
        $asociacion = new Asociacion("Asociación X", "http://asociacion-x.org");
        $entidad = new Entity("Entidad Y");

        $asociacion->addEntity($entidad);
        $this->assertCount(1, $asociacion->getEntidades());
        $this->assertTrue($asociacion->getEntidades()->contains($entidad));

        $asociacion->removeEntity($entidad);
        $this->assertCount(0, $asociacion->getEntidades());
    }

    public function testSetAndGetWebUrl(): void
    {
        $asociacion = new Asociacion("Nombre", "http://original-url.org");
        $asociacion->setWebUrl("http://nueva-url.org");

        $this->assertSame("http://nueva-url.org", $asociacion->getWebUrl());
    }
    public function testJsonSerialize(): void
    {
        $name = "Asociación de Prueba";
        $url = "http://asociacion-prueba.org";
        $birthDate = new DateTime("1999-12-31");

        $asociacion = new Asociacion($name, $url, $birthDate);

        // Simular que tiene una entidad
        $entidad = new Entity("Entidad A");
        $asociacion->addEntity($entidad);

        $json = $asociacion->jsonSerialize();

        $this->assertArrayHasKey('asociacion', $json);
        $this->assertSame($name, $json['asociacion']['name']);
        $this->assertSame($url, $json['asociacion']['url']);
        $this->assertArrayHasKey('entidades', $json['asociacion']);
        $this->assertIsArray($json['asociacion']['entidades']);
    }

}
