<?php
declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Asociacion;
use App\Factory\EntityFactory;
use Faker\Generator;
use Faker\Factory as FakerFactory;
use PHPUnit\Framework\Attributes as TestsAttr;
use PHPUnit\Framework\TestCase;

#[TestsAttr\UsesClass(EntityFactory::class)]
#[TestsAttr\CoversClass(Asociacion::class)]
final class AsociacionTest extends TestCase
{
    private static Generator $faker;

    public static function setUpBeforeClass(): void
    {
        self::$faker = FakerFactory::create('es_ES');
    }

    public function testConstructorYGetters(): void
    {
        $nombre = self::$faker->company;
        $ambito = self::$faker->randomElement(['Local', 'Nacional', 'Internacional']);
        $fecha = self::$faker->date('Y-m-d');
        $email = self::$faker->companyEmail;

        $asociacion = new Asociacion(
            nombre: $nombre,
            ambito: $ambito,
            fechaFundacion: $fecha,
            email: $email
        );

        $this->assertEquals($nombre, $asociacion->getNombre());
        $this->assertEquals($ambito, $asociacion->getAmbito());
        $this->assertEquals($fecha, $asociacion->getFechaFundacion());
        $this->assertEquals($email, $asociacion->getEmail());

        $this->assertNull($asociacion->getId());
    }

    public function testToString(): void
    {
        $asociacion = new Asociacion(
            nombre: self::$faker->company,
            ambito: self::$faker->randomElement(['Local', 'Nacional', 'Internacional']),
            fechaFundacion: self::$faker->date('Y-m-d'),
            email: self::$faker->companyEmail
        );

        $cadena = (string) $asociacion;

        $this->assertStringContainsString($asociacion->getNombre(), $cadena);
        $this->assertStringContainsString($asociacion->getAmbito(), $cadena);
        $this->assertStringContainsString($asociacion->getFechaFundacion(), $cadena);
        $this->assertStringContainsString($asociacion->getEmail(), $cadena);
    }

    public function testJsonSerialize(): void
    {
        $asociacion = new Asociacion(
            nombre: self::$faker->company,
            ambito: self::$faker->randomElement(['Local', 'Nacional', 'Internacional']),
            fechaFundacion: self::$faker->date('Y-m-d'),
            email: self::$faker->companyEmail
        );

        $json = json_encode($asociacion);
        $data = json_decode($json, true);

        $this->assertEquals($asociacion->getNombre(), $data['nombre']);
        $this->assertEquals($asociacion->getAmbito(), $data['ambito']);
        $this->assertEquals($asociacion->getFechaFundacion(), $data['fechaFundacion']);
        $this->assertEquals($asociacion->getEmail(), $data['email']);
    }
}
