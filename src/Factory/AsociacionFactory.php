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
    public function createElement(array $parsedBody): Asociacion
    {
        $name = $parsedBody['name'] ?? '';
        $birthDate = isset($parsedBody['birthDate']) ? new DateTime($parsedBody['birthDate']) : null;
        $deathDate = isset($parsedBody['deathDate']) ? new DateTime($parsedBody['deathDate']) : null;
        $imageUrl = $parsedBody['imageUrl'] ?? null;
        $wikiUrl = $parsedBody['wikiUrl'] ?? null;
        $url = $parsedBody['url'] ?? '';

        $asociacion = new Asociacion($name, $url, $birthDate, $deathDate, $imageUrl, $wikiUrl);

        return $asociacion;
    }

    /**
     * Actualiza una Asociación a partir del contenido del cuerpo de la petición
     *
     * @param Asociacion $element    Asociación a modificar
     * @param array      $parsedBody Datos en formato array asociativo
     */
    public function updateElement(object $element, array $parsedBody): void
    {
        assert($element instanceof Asociacion);

        if (isset($parsedBody['name'])) {
            $element->setName($parsedBody['name']);
        }
        if (isset($parsedBody['url'])) {
            $element->setUrl($parsedBody['url']);
        }

        $this->setDates($element, $parsedBody);

        if (isset($parsedBody['imageUrl'])) {
            $element->setImageUrl($parsedBody['imageUrl']);
        }
        if (isset($parsedBody['wikiUrl'])) {
            $element->setWikiUrl($parsedBody['wikiUrl']);
        }
    }

}
