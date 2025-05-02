<?php

namespace TDW\ACiencia\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use TDW\ACiencia\Entity\Asociacion;
use TDW\ACiencia\Entity\Entity;
use JsonException;

final class AsociacionController
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function index(Request $request, Response $response): Response
    {
        $asociaciones = $this->entityManager
            ->getRepository(Asociacion::class)
            ->findAll();

        $data = array_map(fn($a) => $a->jsonSerialize(), $asociaciones);
        $response->getBody()->write(json_encode($data, JSON_PRETTY_PRINT));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function show(Request $request, Response $response, array $args): Response
    {
        $asociacion = $this->entityManager
            ->getRepository(Asociacion::class)
            ->find((int) $args['id']);

        if ($asociacion === null) {
            return $response->withStatus(404);
        }

        $response->getBody()->write(json_encode($asociacion->jsonSerialize(), JSON_PRETTY_PRINT));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function create(Request $request, Response $response): Response
{
    try {
        $data = json_decode($request->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        if (!isset($data['nombre']) || !isset($data['url'])) {
            throw new \InvalidArgumentException('Faltan campos obligatorios: nombre y/o url');
        }

        $asociacion = new Asociacion();
        $asociacion->setNombre($data['nombre']);
        $asociacion->setUrl($data['url']);

        $this->entityManager->persist($asociacion);
        $this->entityManager->flush();

        $response->getBody()->write(json_encode($asociacion->jsonSerialize(), JSON_PRETTY_PRINT));
        return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
    } catch (\Throwable $e) {
        $error = [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ];
        $response->getBody()->write(json_encode($error, JSON_PRETTY_PRINT));
        return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
    }
}


    public function delete(Request $request, Response $response, array $args): Response
    {
        $asociacion = $this->entityManager
            ->getRepository(Asociacion::class)
            ->find((int) $args['id']);

        if ($asociacion === null) {
            return $response->withStatus(404);
        }

        $this->entityManager->remove($asociacion);
        $this->entityManager->flush();

        return $response->withStatus(204);
    }
}
