<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Entity\Asociacion;


final class AsociacionTest extends TestCase
{
    public function testConstructorYGetters(): void
    {
        $asociacion = new Asociacion(
            nombre: 'Asociación Científica',
            ambito: 'Nacional',
            fechaFundacion: '1999-10-10',
            email: 'info@cientifica.org'
        );

        $this->assertEquals('Asociación Científica', $asociacion->getNombre());
        $this->assertEquals('Nacional', $asociacion->getAmbito());
        $this->assertEquals('1999-10-10', $asociacion->getFechaFundacion());
        $this->assertEquals('info@cientifica.org', $asociacion->getEmail());

        // Suponiendo que hereda métodos de Element
        $this->assertNull($asociacion->getId()); // si no ha sido persistida aún
    }

    public function testSetters(): void
    {
        $asociacion = new Asociacion(
            nombre: 'Asociación X',
            ambito: 'Local',
            fechaFundacion: '2000-01-01',
            email: 'x@asociacion.org'
        );

        $asociacion->setNombre('Asociación Y');
        $asociacion->setAmbito('Internacional');
        $asociacion->setFechaFundacion('2010-12-31');
        $asociacion->setEmail('y@asociacion.org');

        $this->assertEquals('Asociación Y', $asociacion->getNombre());
        $this->assertEquals('Internacional', $asociacion->getAmbito());
        $this->assertEquals('2010-12-31', $asociacion->getFechaFundacion());
        $this->assertEquals('y@asociacion.org', $asociacion->getEmail());
    }

    public function testToString(): void
    {
        $asociacion = new Asociacion(
            nombre: 'BioAsociación',
            ambito: 'Europeo',
            fechaFundacion: '1985-06-30',
            email: 'contacto@bio.org'
        );

        $cadena = (string) $asociacion;

        $this->assertStringContainsString('BioAsociación', $cadena);
        $this->assertStringContainsString('Europeo', $cadena);
        $this->assertStringContainsString('1985-06-30', $cadena);
        $this->assertStringContainsString('contacto@bio.org', $cadena);
    }

    public function testJsonSerialize(): void
    {
        $asociacion = new Asociacion(
            nombre: 'GeoAsociación',
            ambito: 'Global',
            fechaFundacion: '1970-01-01',
            email: 'geo@asociacion.net'
        );

        $json = json_encode($asociacion);
        $data = json_decode($json, true);

        $this->assertEquals('GeoAsociación', $data['nombre']);
        $this->assertEquals('Global', $data['ambito']);
        $this->assertEquals('1970-01-01', $data['fechaFundacion']);
        $this->assertEquals('geo@asociacion.net', $data['email']);
    }
}
