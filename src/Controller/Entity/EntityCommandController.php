<?php

/**
 * src/Controller/Entity/EntityCommandController.php
 *
 * @license https://opensource.org/licenses/MIT MIT License
 * @link    https://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */

namespace TDW\ACiencia\Controller\Entity;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use TDW\ACiencia\Controller\Element\ElementBaseCommandController;
use TDW\ACiencia\Entity\Entity;
use TDW\ACiencia\Factory\EntityFactory;
use TDW\ACiencia\Utility\Error;

/**
 * Class EntityCommandController
 */
class EntityCommandController extends ElementBaseCommandController
{
    /** @var string ruta api gestión entityas */
    public const PATH_ENTITIES = '/entities';

    public static function getEntityClassName(): string
    {
        return Entity::class;
    }

    protected static function getFactoryClassName(): string
    {
        return EntityFactory::class;
    }

    public static function getEntityIdName(): string
    {
        return 'entityId';
    }

    public function put(
        ServerRequestInterface $request,
        Response                      $response,
        array                                    $args
    ): Response
    {
        assert($request->getMethod() === 'PUT');
        if (!$this->checkWriterScope($request)) { // 403 => 404 por seguridad
            return Error::createResponse($response, StatusCode::STATUS_NOT_FOUND);
        }

        $req_data = (array)$request->getParsedBody();

        $idName = static::getEntityIdName();
        if ($args[$idName] <= 0 || $args[$idName] > 2147483647) {
            return Error::createResponse($response, StatusCode::STATUS_NOT_FOUND);
        }

        $this->entityManager->beginTransaction();

        /** @var \TDW\ACiencia\Entity\Entity|null $entity */
        $entity = $this->entityManager
            ->getRepository(static::getEntityClassName())
            ->find($args[$idName]);

        if (!$entity instanceof \TDW\ACiencia\Entity\Entity) {
            $this->entityManager->rollback();
            return Error::createResponse($response, StatusCode::STATUS_NOT_FOUND);
        }

        // Validación ETag
        $etag = md5((string)json_encode($entity));
        if (!in_array($etag, $request->getHeader('If-Match'), true)) {
            $this->entityManager->rollback();
            return Error::createResponse($response, StatusCode::STATUS_PRECONDITION_REQUIRED);
        }

        if (isset($req_data['name'])) {
            $entityId = $this->findIdByName(static::getEntityClassName(), $req_data['name']);
            if (($entityId !== 0) && (intval($args[$idName]) !== $entityId)) {
                $this->entityManager->rollback();
                return Error::createResponse($response, StatusCode::STATUS_BAD_REQUEST);
            }
            $entity->setName($req_data['name']);
        }

        $this->updateElement($entity, $req_data);
        //add asociacion
        if (isset($req_data['asociaciones']) && is_array($req_data['asociaciones'])) {
            foreach ($entity->getAsociaciones() as $aExistente) {
                $entity->removeAsociacion($aExistente);
            }

            foreach ($req_data['asociaciones'] as $idAsociacion) {
                $asociacion = $this->entityManager
                    ->getRepository(\TDW\ACiencia\Entity\Asociacion::class)
                    ->find($idAsociacion);

                if ($asociacion !== null) {
                    $entity->addAsociacion($asociacion);
                }
            }
        }

        $this->entityManager->flush();
        $this->entityManager->commit();

        return $response
            ->withStatus(209, 'Content Returned')
            ->withJson($entity);
    }

}
