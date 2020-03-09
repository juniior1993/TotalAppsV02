<?php


namespace Source\Models\Arquivos;


use Source\Core\TotalTranslator\DataLayer;

class ArquivosNew extends DataLayer
{
    public function __construct()
    {
        parent::__construct("tt_orc_arquivos", [], "OARQ_IdOrcamento", false);
    }

}