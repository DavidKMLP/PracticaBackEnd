<?php

namespace TDW\ACiencia\Entity;

interface WebElementInterface extends ElementInterface
{
    public function getWebUrl(): ?string;

    public function setWebUrl(?string $url): void;
}
