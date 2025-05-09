<?php

namespace TDW\Test\ACiencia\Controller\Asociacion;

use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Attributes as TestsAttr;
use TDW\ACiencia\Controller\Asociacion\AsociacionQueryController;
use TDW\ACiencia\Controller\Asociacion\AsociacionRelationsController;
use TDW\ACiencia\Controller\Element\ElementRelationsBaseController;
use TDW\ACiencia\Entity\{Asociacion, Entity};
use TDW\ACiencia\Factory\EntityFactory;
use TDW\ACiencia\Utility\DoctrineConnector;
use TDW\ACiencia\Utility\Utils;
use TDW\Test\ACiencia\Controller\BaseTestCase;

#[TestsAttr\CoversClass(AsociacionRelationsController::class)]
#[TestsAttr\CoversClass(ElementRelationsBaseController::class)]
final class AsociacionRelationsControllerTest extends BaseTestCase
{


    protected static ?EntityManagerInterface $entityManager;

    /** @var array<string,mixed> Admin data */
    protected static array $writer;

    /** @var array<string,mixed> reader user data */
    protected static array $reader;
    private static Asociacion $asociacion;
    /** @var string Path para la gestión de entityas */
    protected const RUTA_API = '/api/v1/entities';

    private static Entity $entity;
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        //User writer
        self::$writer = [
            'username' => (string) getenv('ADMIN_USER_NAME'),
            'email'    => (string) getenv('ADMIN_USER_EMAIL'),
            'password' => (string) getenv('ADMIN_USER_PASSWD'),
        ];
        self::$writer['id'] = Utils::loadUserData(
            username: (string) self::$writer['username'],
            email: (string) self::$writer['email'],
            password: (string) self::$writer['password'],
            isWriter: true
        );
        //Reader
        self::$reader = [
            'username' => self::$faker->userName(),
            'email'    => self::$faker->email(),
            'password' => self::$faker->password(),
        ];
        self::$reader['id'] = Utils::loadUserData(
            username: self::$reader['username'],
            email: self::$reader['email'],
            password: self::$reader['password'],
            isWriter: false
        );

        // create and insert fixtures
        $entityName = substr(self::$faker->company(), 0, 80);
        self::assertNotEmpty($entityName);
        self::$entity  = EntityFactory::createElement($entityName);

        self::$entityManager = DoctrineConnector::getEntityManager();
        self::$entityManager->persist(self::$entity);
        self::$entityManager->flush();
    }

    public function testGetEntitiesTag(): void
    {
        self::assertSame(
            AsociacionQueryController::getEntitiesTag(),
            AsociacionRelationsController::getEntitiesTag()
        );
    }
    public function testOptionsRelationship204(): void
    {
        $response = $this->runApp(
            'OPTIONS',
            self::RUTA_API . '/' . self::$entity->getId() . '/persons'
        );
        self::assertSame(204, $response->getStatusCode());
        self::assertNotEmpty($response->getHeader('Allow'));
        self::assertEmpty($response->getBody()->getContents());

        $response = $this->runApp(
            'OPTIONS',
            self::RUTA_API . '/' . self::$entity->getId()
            . '/persons/add/' . self::$person->getId()
        );
        self::assertSame(204, $response->getStatusCode());
        self::assertNotEmpty($response->getHeader('Allow'));
        self::assertEmpty($response->getBody()->getContents());
    }

}
