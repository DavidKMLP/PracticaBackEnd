<?php

/**
 * src/Controller/Asociacion/AsociacionCommandController.php
 *
 * @license https://opensource.org/licenses/MIT MIT License
 * @link    https://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */
namespace TDW\ACiencia\Controller\Asociacion;

use TDW\ACiencia\Controller\Element\ElementBaseCommandController;
use TDW\ACiencia\Entity\Asociacion;
use TDW\ACiencia\Factory\AsociacionFactory;

/**
 * Class AsociacionCommandController
 */
class AsociacionCommandController extends ElementBaseCommandController
{
    /** @var string ruta api gestión asociaciones  */
    public const PATH_ASOCIACIONES = '/asociaciones';

    public static function getEntityClassName(): string
    {
        return Asociacion::class;
    }

    protected static function getFactoryClassName(): string
    {
        return AsociacionFactory::class;
    }

    public static function getEntityIdName(): string
    {
        return 'asociacionId';
    }

    /**
     * Crea una nueva entidad Asociacion desde los datos del cuerpo de la petición.
     *
     * @param array $data Datos del cuerpo de la petición
     * @return object Nueva entidad Asociacion
     */
    protected static function createElement(array $data): object
    {
        return AsociacionFactory::create($data);
    }
}
