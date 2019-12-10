<?php

// src/Service/MessageGenerator.php
namespace App\Service;

class Slugify
{
    public function generate(string $input) : string
    {
        setlocale(LC_CTYPE, 'fr_FR');
        $input = iconv('UTF-8', 'ASCII//TRANSLIT', $input);
        $input = preg_replace('/\W/', ' ', $input);
        $input = preg_replace('(\s+)', '-', strtolower(trim($input)));

        return $input;
    }
}
