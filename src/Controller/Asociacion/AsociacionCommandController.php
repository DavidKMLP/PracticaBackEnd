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
use DateTime;
use Fig\Http\Message\StatusCodeInterface as StatusCode;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response;
use TDW\ACiencia\Utility\Error;
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

    public function post(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        if (!isset($data['name']) || !isset($data['url'])) {
            return Error::createResponse($response, StatusCode::STATUS_UNPROCESSABLE_ENTITY, 'Missing name or url');
        }

        $element = AsociacionFactory::createElement(
            $data['name'],
            $data['url'],
            isset($data['birthDate']) ? new DateTime($data['birthDate']) : null,
            isset($data['deathDate']) ? new DateTime($data['deathDate']) : null,
            $data['imageUrl'] ?? null,
            $data['wikiUrl'] ?? null
        );

        $this->entityManager->persist($element);
        $this->entityManager->flush();

        return $response->withJson(['asociacion' => $element], StatusCode::STATUS_CREATED);
    }
    public function put(Request $request, Response $response, array $args): Response
    {
        $element = $this->entityManager->find(Asociacion::class, (int) $args['asociacionId']);
        if (!$element) {
            return Error::createResponse($response, StatusCode::STATUS_NOT_FOUND);
        }

        $data = $request->getParsedBody();
        AsociacionFactory::updateElement($element, $data);

        $this->entityManager->flush();

        return $response->withJson(['asociacion' => $element], StatusCode::STATUS_OK);
    }
}
