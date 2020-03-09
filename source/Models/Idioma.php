<?php


namespace Source\Models;


use Source\Core\TotalTranslator\DataLayer;

class Idioma extends DataLayer
{
    public function __construct()
    {
        parent::__construct("idiomas", [], "IDI_IdIdioma", false);
    }
}