<?php

/**
 * PHP version 8.1
 *
 * @category Factory
 * @package  TDW\ACiencia\Factory
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://www.etsisi.upm.es ETS de Ingeniería de Sistemas Informáticos
 */

namespace TDW\ACiencia\Factory;

use DateTime;
use InvalidArgumentException;
use TDW\ACiencia\Entity\Asociacion;

/**
 * Class AsociacionFactory
 *
 * @package TDW\ACiencia\Factory
 */
class AsociacionFactory extends ElementFactory
{
    /**
     * Crea una nueva Asociación desde un array asociativo
     *
     * @param array $parsedBody Datos en formato array asociativo
     *
     * @return Asociacion
     */
    public static function createElement(
        string $name,
        ?DateTime $birthDate = null,
        ?DateTime $deathDate = null,
        ?string $imageUrl = null,
        ?string $wikiUrl = null
    ): Asociacion {
        // Puedes modificar este valor por defecto o lanzar excepción si lo prefieres
        $defaultUrl = 'https://url-defecto.org';
        return new Asociacion($name, $defaultUrl, $birthDate, $deathDate, $imageUrl, $wikiUrl);
    }

    /**
     * Crea una Asociación desde el body de la request
     */
    public static function createFromParsedBody(array $parsedBody): Asociacion
    {
        if (!isset($parsedBody['url'])) {
            throw new InvalidArgumentException('Missing required "url" for Asociacion.');
        }

        $birthDate = isset($parsedBody['birthDate']) ? new DateTime($parsedBody['birthDate']) : null;
        $deathDate = isset($parsedBody['deathDate']) ? new DateTime($parsedBody['deathDate']) : null;

        $asociacion = new Asociacion(
            $parsedBody['name'] ?? '',
            $parsedBody['url'],
            $birthDate,
            $deathDate,
            $parsedBody['imageUrl'] ?? null,
            $parsedBody['wikiUrl'] ?? null
        );

        return $asociacion;
    }








}
