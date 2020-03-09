<?php


namespace Source\Models;


use Source\Core\TotalTranslator\DataLayer;

class IdiomaNew extends DataLayer
{
    public function __construct()
    {
        parent::__construct("tt_orc_idiomas", [], "OIDI_IdIdioma", false);
    }


}