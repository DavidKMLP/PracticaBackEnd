<?php

/**
 * config/routesAsociaciones.php
 *
 * @license https://opensource.org/licenses/MIT MIT License
 * @link    https://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */

use Slim\App;
use Slim\Routing\RouteCollectorProxy as Group;
use TDW\ACiencia\Controller\Asociacion\{
    AsociacionCommandController,
    AsociacionQueryController,
    AsociacionRelationsController
};

/** @var App $app */

$app->group('/api/v1', function (Group $api) {

    $api->group('/asociaciones', function (Group $group) {

        // Comandos: crear, eliminar, actualizar
        $group->post('', AsociacionCommandController::class . ':post');
        $group->delete('/{id:[0-9]+}', AsociacionCommandController::class . ':delete');
        $group->put('/{id:[0-9]+}', AsociacionCommandController::class . ':update');

        // Consultas: listar, obtener por ID, buscar por nombre
        $group->get('', AsociacionQueryController::class . ':cget');
        $group->get('/{id:[0-9]+}', AsociacionQueryController::class . ':show');
        $group->get('/nombre/{nombre}', AsociacionQueryController::class . ':nombreExiste');

        // Relaciones: obtener relacionadas, modificar relación
        $group->get('/{asociacionId}/{elementType}', AsociacionRelationsController::class . ':relatedElements');
        $group->put('/{asociacionId}/{operationType}/{elementId}', AsociacionRelationsController::class . ':setRelation');

    });

});
