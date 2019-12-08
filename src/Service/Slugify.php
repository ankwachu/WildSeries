<?php

// src/Service/MessageGenerator.php
namespace App\Service;

class Slugify
{
    public function generate(string $input) : string
    {
        $input = str_replace('-', ' ', $input);
        $input = strtolower($input);
        $input = preg_replace('/--+/', '-', $input);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $input);
    }
}
