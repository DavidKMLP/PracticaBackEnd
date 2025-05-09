<?php

/**
 * src/Controller/Asociacion/AsociacionQueryController.php
 *
 * @license https://opensource.org/licenses/MIT MIT License
 * @link    https://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */

namespace TDW\ACiencia\Controller\Asociacion;

use TDW\ACiencia\Controller\Element\ElementBaseQueryController;
use TDW\ACiencia\Entity\Asociacion;
use Psr\Http\Message\ServerRequestInterface as Request;
use Fig\Http\Message\StatusCodeInterface as StatusCode;
use Slim\Http\Response;
use TDW\ACiencia\Utility\Error;
/**
 * Class AsociacionQueryController
 */
class AsociacionQueryController extends ElementBaseQueryController
{
    public const PATH_ASOCIACIONES = '/asociaciones';
    public static function getEntityClassName(): string
    {
        return Asociacion::class;
    }
    
    public static function getEntityIdName(): string
    {
        return 'asociacionId';
    }

    public static function getEntitiesTag(): string
    {
        return 'asociaciones';
    }

    public function getByNombre(Request $request, Response $response, array $args): Response
    {
        $nombre = $args['nombre'] ?? null;

        if (null === $nombre) {
            return Error::createResponse($response, StatusCode::STATUS_BAD_REQUEST);
        }

        /** @var \TDW\ACiencia\Entity\Asociacion|null $asociacion */
        $asociacion = $this->entityManager
            ->getRepository(static::getEntityClassName())
            ->findOneBy([ 'name' => $nombre ]);

        if (null === $asociacion) {
            return Error::createResponse($response, StatusCode::STATUS_NOT_FOUND);
        }

        $etag = md5((string) json_encode($asociacion));
        if (in_array($etag, $request->getHeader('If-None-Match'), true)) {
            return $response->withStatus(StatusCode::STATUS_NOT_MODIFIED);
        }

        return $response
            ->withAddedHeader('ETag', $etag)
            ->withAddedHeader('Cache-Control', 'private')
            ->withJson($asociacion);
    }




}
