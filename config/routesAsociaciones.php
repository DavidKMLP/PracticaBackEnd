<?php

use Slim\App;
use TDW\ACiencia\Controller\Asociacion\AsociacionCommandController;
use TDW\ACiencia\Controller\Asociacion\AsociacionQueryController;
use TDW\ACiencia\Controller\Asociacion\AsociacionRelationsController;
use TDW\ACiencia\Middleware\JwtMiddleware;

return function (App $app): void {
    $app->group($_ENV['RUTA_API'] . AsociacionQueryController::PATH_ASOCIACIONES, function (\Slim\Routing\RouteCollectorProxy $group): void {

        // GET /asociaciones
        $group->get(
            '',
            AsociacionQueryController::class . ':cget'
        )->setName('tdw_asociaciones_cget');

        // GET /asociaciones/{asociacionId}
        $group->get(
            '/{asociacionId:[0-9]+}',
            AsociacionQueryController::class . ':get'
        )->setName('tdw_asociaciones_get');

        // GET /asociaciones/nombre/{nombre}
        $group->get(
            '/nombre/{nombre}',
            AsociacionQueryController::class . ':getByNombre'
        )->setName('tdw_asociaciones_get_nombre');

        // POST /asociaciones
        $group->post(
            '',
            AsociacionCommandController::class . ':post'
        )->setName('tdw_asociaciones_post')
            ->add(JwtMiddleware::class);

        // PUT /asociaciones/{asociacionId}
        $group->put(
            '/{asociacionId:[0-9]+}',
            AsociacionCommandController::class . ':put'
        )->setName('tdw_asociaciones_put')
            ->add(JwtMiddleware::class);

        // DELETE /asociaciones/{asociacionId}
        $group->delete(
            '/{asociacionId:[0-9]+}',
            AsociacionCommandController::class . ':delete'
        )->setName('tdw_asociaciones_delete')
            ->add(JwtMiddleware::class);

        // GET /asociaciones/{asociacionId}/entities
        $group->get(
            '/{asociacionId:[0-9]+}/entities',
            AsociacionRelationsController::class . ':getEntities'
        )->setName('tdw_asociaciones_entities_get');

        // PUT /asociaciones/{asociacionId}/entities/{entityId}
        $group->put(
            '/{asociacionId:[0-9]+}/entities/{entityId:[0-9]+}',
            AsociacionRelationsController::class . ':putEntity'
        )->setName('tdw_asociaciones_entities_put')
            ->add(JwtMiddleware::class);

        // DELETE /asociaciones/{asociacionId}/entities/{entityId}
        $group->delete(
            '/{asociacionId:[0-9]+}/entities/{entityId:[0-9]+}',
            AsociacionRelationsController::class . ':deleteEntity'
        )->setName('tdw_asociaciones_entities_delete')
            ->add(JwtMiddleware::class);

        // OPTIONS
        $group->options(
            '',
            AsociacionQueryController::class . ':options'
        )->setName('tdw_asociaciones_options');

        $group->options(
            '/{asociacionId:[0-9]+}',
            AsociacionQueryController::class . ':options'
        )->setName('tdw_asociaciones_options_id');

        $group->options(
            '/nombre/{nombre}',
            AsociacionQueryController::class . ':options'
        )->setName('tdw_asociaciones_options_nombre');

        $group->options(
            '/{id:[0-9]+}/{elementType}',
            AsociacionRelationsController::class . ':options'
        )->setName('tdw_asociaciones_elements_options');

        $group->options(
            '/{asociacionId:[0-9]+}/entities',
            AsociacionRelationsController::class . ':options'
        )->setName('tdw_asociaciones_entities_options');

        $group->options(
            '/{asociacionId:[0-9]+}/entities/{entityId:[0-9]+}',
            AsociacionRelationsController::class . ':optionsEntity'
        )->setName('tdw_asociaciones_entities_options_entity');

        $group->options(
            '/{asociacionId:[0-9]+}/{elementType}/{operationType}/{elementId:[0-9]+}',
            AsociacionRelationsController::class . ':optionsRelation'
        )->setName('tdw_asociaciones_elements_options_relation');

    });
};
