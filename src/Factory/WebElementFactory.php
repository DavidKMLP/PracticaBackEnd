<?php

namespace TDW\ACiencia\Factory;

use DateTime;
use TDW\ACiencia\Entity\WebElementInterface;

abstract class WebElementFactory
{
    public static function createElement(
        string $name,
        string $url,
        ?DateTime $birthDate = null,
        ?DateTime $deathDate = null,
        ?string $imageUrl = null,
        ?string $wikiUrl = null
    ): WebElementInterface {
        throw new \RuntimeException('This method must be implemented by subclasses.');
    }

    public static function updateElement(WebElementInterface $element, array $parsedBody): void
    {
        if (isset($parsedBody['url'])) {
            $element->setWebUrl($parsedBody['url']);
        }
    }
}
