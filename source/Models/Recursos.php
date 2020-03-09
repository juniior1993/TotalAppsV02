<?php


namespace Source\Models;


use Source\Core\TotalTranslator\DataLayer;

class Recursos extends DataLayer
{


    public function __construct()
    {
        parent::__construct('recursos', [], "REC_IdRecurso", false);
    }


}