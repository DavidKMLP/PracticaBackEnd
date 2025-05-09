<?php

/**
 * src/Controller/Asociacion/AsociacionRelationsController.php
 *
 * @license https://opensource.org/licenses/MIT MIT License
 * @link    https://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */

namespace TDW\ACiencia\Controller\Asociacion;

use Doctrine\ORM;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response;
use TDW\ACiencia\Controller\Element\ElementRelationsBaseController;
use TDW\ACiencia\Controller\Entity\EntityQueryController;
use TDW\ACiencia\Entity\Asociacion;
use Slim\Routing\RouteContext;
use TDW\ACiencia\Entity\Entity;


/**
 * Class AsociacionRelationsController
 */
final class AsociacionRelationsController extends ElementRelationsBaseController
{
    public static function getEntityClassName(): string
    {
        return AsociacionQueryController::getEntityClassName();
    }

    public static function getEntitiesTag(): string
    {
        return AsociacionQueryController::getEntitiesTag();
    }

    public static function getEntityIdName(): string
    {
        return AsociacionQueryController::getEntityIdName();
    }

    /**
     * Summary: GET /asociaciones/{asociacionId}/entities
     *
     * @param Request $request
     * @param Response $response
     * @param array<string,mixed> $args
     *
     * @return Response
     */
    public function getEntities(Request $request, Response $response, array $args): Response
    {
        $asociacionId = $args[self::getEntityIdName()] ?? 0;
        if ($asociacionId <= 0 || $asociacionId > 2147483647) {
            return $this->getElements($request, $response, null, EntityQueryController::getEntitiesTag(), []);
        }

        /** @var Asociacion|null $asociacion */
        $asociacion = $this->entityManager
            ->getRepository(self::getEntityClassName())
            ->find($asociacionId);

        $entities = $asociacion?->getEntidades()->getValues() ?? [];

        return $this->getElements($request, $response, $asociacion, EntityQueryController::getEntitiesTag(), $entities);
    }

    /**
     * PUT /asociaciones/{asociacionId}/entities/add/{entityId}
     * PUT /asociaciones/{asociacionId}/entities/rem/{entityId}
     *
     * @param Request $request
     * @param Response $response
     * @param array<string,mixed> $args
     *
     * @return Response
     * @throws ORM\Exception\ORMException
     */

    public function options(Request $request, Response $response, array $args = []): Response
    {
        $routeContext = RouteContext::fromRequest($request);
        $routingResults = $routeContext->getRoutingResults();
        $methods = $routingResults->getAllowedMethods();

        return $response
            ->withStatus(204)
            ->withHeader('Allow', implode(',', $methods));
    }


    public function operationEntity(Request $request, Response $response, array $args): Response
    {
        return $this->operationRelatedElements($request, $response, $args, Entity::class);
    }



}
