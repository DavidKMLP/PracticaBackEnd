<?php

use PHPUnit\Framework\TestCase;
use App\Entity\Asociacion;
use App\Controller\AsociacionCommandController;
use App\Controller\AsociacionQueryController;
use App\Controller\ElementBaseCommandController;
use App\Controller\ElementBaseQueryController;
use PHPUnit\Framework\Attributes as TestsAttr;

#[TestsAttr\CoversClass(AsociacionCommandController::class)]
#[TestsAttr\CoversClass(AsociacionQueryController::class)]
#[TestsAttr\CoversClass(ElementBaseCommandController::class)]
#[TestsAttr\CoversClass(ElementBaseQueryController::class)]
class AsociacionControllerTest extends BaseTestCase
{
    private int $id;

    protected function setUp(): void
    {
        parent::setUp();

        $data = [
            'nombre' => 'Asociacion de Prueba',
            'siglas' => 'ADP'
        ];

        $response = $this->runApp('POST', '/asociaciones', $data);
        $body = json_decode((string) $response->getBody(), true);
        $this->id = $body['id'];


        protected function tearDown(): void
    {
        if (isset($this->id)) {
            $this->runApp('DELETE', '/asociaciones/' . $this->id);
        }
        parent::tearDown();
    }
    }

    /** @test */
    public function testPostAsociacion(): void
    {
        $data = [
            'nombre' => 'Nueva Asociacion',
            'siglas' => 'NAP'
        ];

        $response = $this->runApp('POST', '/asociaciones', $data);
        $this->assertEquals(201, $response->getStatusCode());

        $body = json_decode((string) $response->getBody(), true);
        $this->assertEquals($data['nombre'], $body['nombre']);
        $this->assertEquals($data['siglas'], $body['siglas']);
    }

    /** @test */
    public function testGetAllAsociaciones(): void
    {
        $response = $this->runApp('GET', '/asociaciones');
        $this->assertEquals(200, $response->getStatusCode());

        $body = json_decode((string) $response->getBody(), true);
        $this->assertIsArray($body);
        $this->assertNotEmpty($body);
    }

    /** @test */
    public function testGetAsociacionById(): void
    {
        $response = $this->runApp('GET', '/asociaciones/' . $this->id);
        $this->assertEquals(200, $response->getStatusCode());

        $body = json_decode((string) $response->getBody(), true);
        $this->assertEquals('Asociacion de Prueba', $body['nombre']);
        $this->assertEquals('ADP', $body['siglas']);
    }

    /** @test */
    public function testPutAsociacion(): void
    {
        $data = [
            'nombre' => 'Asociacion Modificada',
            'siglas' => 'ADM'
        ];

        $response = $this->runApp('PUT', '/asociaciones/' . $this->id, $data);
        $this->assertEquals(200, $response->getStatusCode());

        $body = json_decode((string) $response->getBody(), true);
        $this->assertEquals($data['nombre'], $body['nombre']);
        $this->assertEquals($data['siglas'], $body['siglas']);
    }

    /** @test */
    public function testDeleteAsociacion(): void
    {
        $response = $this->runApp('DELETE', '/asociaciones/' . $this->id);
        $this->assertEquals(204, $response->getStatusCode());

        $getResponse = $this->runApp('GET', '/asociaciones/' . $this->id);
        $this->assertEquals(404, $getResponse->getStatusCode());
    }
}
