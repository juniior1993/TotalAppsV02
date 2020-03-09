<?php


namespace Source\Models\Arquivos;


use Source\Core\TotalTranslator\DataLayer;
use Source\Models\IdiomaNew;

class OrcamentosNew extends DataLayer
{
    public function __construct()
    {
        parent::__construct("tt_orc_orcamentos", [], "OORC_IdOrcamento", true);
    }

    public function idiomasPrincipais(): array
    {
        $idiomaDe =  (new IdiomaNew())->find("OIDI_IdIdioma = :idiomaDe", "idiomaDe={$this->OORC_IdIdiomaOrig}")->fetch()->OIDI_Idioma;
        $idiomaPara =  (new IdiomaNew())->find("OIDI_IdIdioma = :idiomaPara", "idiomaPara={$this->OORC_IdIdiomaDest}")->fetch()->OIDI_Idioma;
        return ["idiomaDe" => $idiomaDe, "idiomaPara" => $idiomaPara];
    }
}