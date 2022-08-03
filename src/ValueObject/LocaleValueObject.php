<?php

namespace App\ValueObject;

use Symfony\Component\Intl\Locales;

class LocaleValueObject
{
    private const SUPPORTED_LOCALES = [
        'en', 'fr', 'es', 'ru', 'ar', 'he'
    ];

    public static function getSupportedLocales(): array
    {
        $locales = [];
        foreach (self::SUPPORTED_LOCALES as $locale) {
           $locales[Locales::getName($locale)] = $locale;
        }

        return $locales;
    }


}