<?php


namespace Source\Models;

use Source\Core\Session;

class JsonGenerators
{
    public function relatorioOrcamentos(array $comercial): bool
    {
        $json = [];

        /**
         * @var  $key
         * @var Comercial $com
         */

        try {
            foreach ($comercial as $key => $com) {
                /** @var Comercial $com */
                $jsonTemp["projeto"] = $com->COM_IndexProjeto;
                $jsonTemp["consultor"] = $com->consultor()->REC_ApelidoRecurso;
                $jsonTemp["Status Comercial"] = $com->statusComercial();
                $jsonTemp["Data Orcamento"] = decodeDate($com->COM_DataCadastro);
                $jsonTemp["Valor"] = $com->COM_Total;
                $jsonTemp["Palavras"] = $com->somaArquivos();
                $jsonTemp["Idiomas"] = $com->idiomas();
                $jsonTemp["Tipo"] = $com->tipoTraducaoGeral();

                if ($com->COM_DataAprovacao > 0) {
                    $jsonTemp["Data Aprovação"] = decodeDate($com->COM_DataAprovacao);
                } else {
                    $jsonTemp["Data Aprovação"] = "";
                }

                $json[$key] = $jsonTemp;
            }

            $session = new Session();

            $json = json_encode($json);
            $fileName = CONF_FILES_PATH . "/relatorios/" . $session->logado . "_relatorio_orcamentos.json";
            $file = fopen($fileName, "w");
            fwrite($file, $json);
            return true;
        } catch (\Exception $e) {
            return false;
        }

    }

}