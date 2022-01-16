<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class OmnivaExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('emptyString', [$this, 'emptyString']),
        ];
    }

    public function emptyString(?string $name): string
    {

        return $name ? $name . ' ' : '';
    }
}
