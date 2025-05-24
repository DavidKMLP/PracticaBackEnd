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
use TDW\ACiencia\Entity\Element;
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
        assert($request->getMethod() === 'PUT');
        if (!$this->checkWriterScope($request)) {
            return Error::createResponse($response, StatusCode::STATUS_NOT_FOUND);
        }

        $req_data = (array) $request->getParsedBody();
        $idName = static::getEntityIdName();

        if ($args[$idName] <= 0 || $args[$idName] > 2147483647) {
            return Error::createResponse($response, StatusCode::STATUS_NOT_FOUND);
        }

        $this->entityManager->beginTransaction();
        /** @var Asociacion|null $element */
        $element = $this->entityManager->getRepository(Asociacion::class)->find($args[$idName]);

        if (!$element instanceof Element) {
            $this->entityManager->rollback();
            return Error::createResponse($response, StatusCode::STATUS_NOT_FOUND);
        }

        $etag = md5((string) json_encode($element));
        if (!in_array($etag, $request->getHeader('If-Match'), true)) {
            $this->entityManager->rollback();
            return Error::createResponse($response, StatusCode::STATUS_PRECONDITION_REQUIRED);
        }

        if (isset($req_data['name'])) {
            $elementId = $this->findIdByName(Asociacion::class, $req_data['name']);
            if (($elementId !== 0) && (intval($args[$idName]) !== $elementId)) {
                $this->entityManager->rollback();
                return Error::createResponse($response, StatusCode::STATUS_BAD_REQUEST);
            }
            $element->setName($req_data['name']);
        }

        $this->updateElement($element, $req_data);
        $this->entityManager->flush();
        $this->entityManager->commit();

        return $response
            ->withStatus(209, 'Content Returned')
            ->withJson(['asociacion' => $element]);
    }

    private function updateElement(Asociacion $a, array $data): void
    {
        foreach ($data as $attr => $datum) {
            switch ($attr) {
                case 'birthDate':
                    $date = \DateTime::createFromFormat('!Y-m-d', $datum);
                    if ($date instanceof \DateTime) {
                        $a->setBirthDate($date);
                    }
                    break;
                case 'deathDate':
                    $date = \DateTime::createFromFormat('!Y-m-d', $datum);
                    if ($date instanceof \DateTime) {
                        $a->setDeathDate($date);
                    }
                    break;
                case 'imageUrl':
                    $a->setImageUrl($datum);
                    break;
                case 'wikiUrl':
                    $a->setWikiUrl($datum);
                    break;
                case 'url':
                    $a->setWebUrl($datum);
                    break;
            }
        }
    }

}
