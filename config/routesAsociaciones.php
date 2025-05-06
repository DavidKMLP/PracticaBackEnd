<?php

/**
 * Routes for Asociacion
 *
 * @license https://opensource.org/licenses/MIT MIT License
 * @link    https://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */

use Slim\App;
use TDW\ACiencia\Controller\AsociacionCommandController;
use TDW\ACiencia\Controller\AsociacionQueryController;
use TDW\ACiencia\Controller\AsociacionRelationsController;

return function (App $app): void {
    $app->group('/asociaciones', function (\Slim\Routing\RouteCollectorProxy $group): void {

        /**
         * ########################################################
         * GET /asociaciones
         * GET /asociaciones/{id}
         * GET /asociaciones/nombre/{nombre}
         * ########################################################
         */
        $group->get(
            '',
            AsociacionQueryController::class . ':cget'
        )->setName('tdw_asociaciones_cget');

        $group->get(
            '/{id:[0-9]+}',
            AsociacionQueryController::class . ':get'
        )->setName('tdw_asociaciones_get');

        $group->get(
            '/nombre/{nombre}',
            AsociacionQueryController::class . ':getByNombre'
        )->setName('tdw_asociaciones_get_nombre');

        /**
         * ########################################################
         * POST /asociaciones
         * PUT /asociaciones/{id}
         * DELETE /asociaciones/{id}
         * ########################################################
         */
        $group->post(
            '',
            AsociacionCommandController::class . ':post'
        )->setName('tdw_asociaciones_post');

        $group->put(
            '/{id:[0-9]+}',
            AsociacionCommandController::class . ':put'
        )->setName('tdw_asociaciones_put');

        $group->delete(
            '/{id:[0-9]+}',
            AsociacionCommandController::class . ':delete'
        )->setName('tdw_asociaciones_delete');

        /**
         * ########################################################
         * GET /asociaciones/{id}/entities
         * PUT /asociaciones/{id}/entities/{entityId}
         * DELETE /asociaciones/{id}/entities/{entityId}
         * ########################################################
         */
        $group->get(
            '/{id:[0-9]+}/entities',
            AsociacionRelationsController::class . ':getEntities'
        )->setName('tdw_asociaciones_entities_cget');

        $group->put(
            '/{id:[0-9]+}/entities/{entityId:[0-9]+}',
            AsociacionRelationsController::class . ':putEntity'
        )->setName('tdw_asociaciones_entities_put');

        $group->delete(
            '/{id:[0-9]+}/entities/{entityId:[0-9]+}',
            AsociacionRelationsController::class . ':deleteEntity'
        )->setName('tdw_asociaciones_entities_delete');

        /**
         * ########################################################
         * OPTIONS /asociaciones
         * OPTIONS /asociaciones/{id}
         * OPTIONS /asociaciones/nombre/{nombre}
         * OPTIONS /asociaciones/{id}/entities
         * OPTIONS /asociaciones/{id}/entities/{entityId}
         * ########################################################
         */
        $group->options(
            '',
            AsociacionCommandController::class . ':options'
        )->setName('tdw_asociaciones_options');

        $group->options(
            '/{id:[0-9]+}',
            AsociacionCommandController::class . ':options'
        )->setName('tdw_asociaciones_options_id');

        $group->options(
            '/nombre/{nombre}',
            AsociacionCommandController::class . ':options'
        )->setName('tdw_asociaciones_options_nombre');

        $group->options(
            '/{id:[0-9]+}/entities',
            AsociacionRelationsController::class . ':options'
        )->setName('tdw_asociaciones_entities_options');

        $group->options(
            '/{id:[0-9]+}/entities/{entityId:[0-9]+}',
            AsociacionRelationsController::class . ':optionsEntity'
        )->setName('tdw_asociaciones_entities_options_entity');
    });
};
