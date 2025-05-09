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
use TDW\ACiencia\Entity\WebURLInterface;

/**
 * Class AsociacionFactory
 *
 * @package TDW\ACiencia\Factory
 */
class AsociacionFactory extends WebElementFactory
{
    protected static array $parsedBody = [];

    /**
     * Crea una nueva Asociación desde un array asociativo
     *
     * @param array $parsedBody Datos en formato array asociativo
     *
     * @return Asociacion
     */
    public static function createElement(
        string    $name,
        string    $url,
        ?DateTime $birthDate = null,
        ?DateTime $deathDate = null,
        ?string   $imageUrl = null,
        ?string   $wikiUrl = null
    ): Asociacion
    {
        $asociacion = new Asociacion($name, $url, $birthDate, $deathDate, $imageUrl, $wikiUrl);
        return $asociacion;
    }
}
