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

        // GET: All associations
        $group->get(
            '',
            AsociacionQueryController::class . ':cget'
        )->setName('tdw_asociaciones_cget');

        // GET: Single association by ID
        $group->get(
            '/{id:[0-9]+}',
            AsociacionQueryController::class . ':get'
        )->setName('tdw_asociaciones_get');

        // GET: Association by name
        $group->get(
            '/nombre/{nombre}',
            AsociacionQueryController::class . ':getByName'
        )->setName('tdw_asociaciones_get_nombre');

        // POST: Create association
        $group->post(
            '',
            AsociacionCommandController::class . ':post'
        )->setName('tdw_asociaciones_post');

        // PUT: Update association
        $group->put(
            '/{id:[0-9]+}',
            AsociacionCommandController::class . ':put'
        )->setName('tdw_asociaciones_put');

        // DELETE: Delete association
        $group->delete(
            '/{id:[0-9]+}',
            AsociacionCommandController::class . ':delete'
        )->setName('tdw_asociaciones_delete');

        // GET: Association entities
        $group->get(
            '/{id:[0-9]+}/entities',
            AsociacionRelationsController::class . ':getEntities'
        )->setName('tdw_asociaciones_entities_cget');

        // PUT: Add entity to association
        $group->put(
            '/{id:[0-9]+}/entities/{entityId:[0-9]+}',
            AsociacionRelationsController::class . ':putEntity'
        )->setName('tdw_asociaciones_entities_put');

        // DELETE: Remove entity from association
        $group->delete(
            '/{id:[0-9]+}/entities/{entityId:[0-9]+}',
            AsociacionRelationsController::class . ':deleteEntity'
        )->setName('tdw_asociaciones_entities_delete');

        // OPTIONS: Association by ID
        $group->options(
            '/{id:[0-9]+}',
            AsociacionCommandController::class . ':options'
        )->setName('tdw_asociaciones_options_id');

        // OPTIONS: Association by name
        $group->options(
            '/nombre/{nombre}',
            AsociacionCommandController::class . ':options'
        )->setName('tdw_asociaciones_options_nombre');

        // OPTIONS: Association entities
        $group->options(
            '/{id:[0-9]+}/entities',
            AsociacionRelationsController::class . ':options'
        )->setName('tdw_asociaciones_entities_options');

        // OPTIONS: Specific entity from association
        $group->options(
            '/{id:[0-9]+}/entities/{entityId:[0-9]+}',
            AsociacionRelationsController::class . ':optionsEntity'
        )->setName('tdw_asociaciones_entities_options_entity');
    });

    // OPTIONS: Global /asociaciones (fuera del grupo para que se capture correctamente)
    $app->options(
        '/asociaciones',
        AsociacionCommandController::class . ':options'
    )->setName('tdw_asociaciones_options');
};
