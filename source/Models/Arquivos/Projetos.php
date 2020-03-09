<?php


namespace Source\Models\Arquivos;


use Source\Core\TotalTranslator\DataLayer;
use Source\Models\Idioma;

class Projetos extends DataLayer
{
    public function __construct()
    {
        parent::__construct("projetos", [], "PRO_IdProjeto", false);
    }

    public function idiomasPrincipais(): array
    {
        $idiomaDe =  (new Idioma())->find("IDI_IdIdioma = :idiomaDe", "idiomaDe={$this->PRO_IdIdiomaOrig}")->fetch()->IDI_Idioma;
        $idiomaPara =  (new Idioma())->find("IDI_IdIdioma = :idiomaPara", "idiomaPara={$this->PRO_IdIdiomaDest}")->fetch()->IDI_Idioma;
        return ["idiomaDe" => $idiomaDe, "idiomaPara" => $idiomaPara];
    }
}