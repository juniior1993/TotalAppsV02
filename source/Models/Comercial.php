<?php

/**
 * Comercial use a BD remote, TotalTranslator.com
 */

namespace Source\Models;


use DateTime;
use PDO;
use Source\Core\TotalTranslator\ConnectTotal;
use Source\Core\TotalTranslator\DataLayer;
use Source\Models\Arquivos\ArquivosNew;
use Source\Models\Arquivos\OrcamentosNew;
use Source\Models\Arquivos\Projetos;

class Comercial extends DataLayer
{
    /** @var array|null ?array $projetos */
    private ?array $projetos;

    /** @var array|null $arquivosNew */
    private ?array $arquivosNew;

    /** @var OrcamentosNew $orcamentoNew */
    private OrcamentosNew $orcamentoNew;

    private string $idsComercial;

    public function __construct()
    {
        parent::__construct("comercial", [], "COM_IdComercial", false);

    }

    private function projeto()
    {
        if (!isset($this->projetos)) {
            try {
                $this->projetos = (new Projetos())->find(
                    "PRO_IdComercial = :idComercial AND PRO_DataExclusao = :data",
                    "idComercial={$this->COM_IdComercial}&data=0"
                )->fetch(true);

            } catch (\Exception $e) {
                var_dump($e);
                die();
            }

            //var_dump($this->projetos);
        }
    }

    private function arquivosNew()
    {
        if (!isset($this->arquivosNew)) {
            $this->arquivosNew = (new ArquivosNew())->find("OARQ_IdOrcamento = :idOrcamento", "idOrcamento={$this->COM_IdOrcamento}")->fetch(true);
        }
    }

    private function orcamentoNew()
    {
        if (!isset($this->orcamentoNew)) {
            $this->orcamentoNew = (new OrcamentosNew())->find("OORC_IdOrcamento = :idOrcamento", "idOrcamento={$this->COM_IdOrcamento}")->fetch();
        }

    }

    public function findByCustomParameters(
        string $dataIni,
        string $dataFinal = null,
        string $consultor = null,
        string $aprovado = null,
        string $valor = null,
        string $idiomaDe = null,
        string $idiomaPara = null,
        string $juramentada = null
    )
    {

        $query = "
            SELECT COM_IdComercial FROM comercial
            LEFT JOIN projetos ON projetos.PRO_IdComercial = comercial.COM_IdComercial
            LEFT JOIN tt_orc_arquivos ON tt_orc_arquivos.OARQ_IdOrcamento = comercial.COM_IdOrcamento
            WHERE TRUE
            AND COM_DataCadastro >= CONCAT(UNIX_TIMESTAMP('{$dataIni}'), '000')
        ";

        if ($dataFinal) {
            $query .= " AND COM_DataCadastro <= CONCAT(UNIX_TIMESTAMP('{$dataFinal}'), '000') ";
        }
        if ($consultor) {
            $query .= " AND COM_IdConsultor IN ({$consultor}) ";
        }
        if ($aprovado) {
            $query .= " AND COM_StatusComercial = 2 ";
        }
        if ($valor) {
            $query .= " AND COM_Total LIKE '%{$valor}%' ";
        }
        if ($idiomaDe) {
            $query .= " AND PRO_IdIdiomaOrig = {$idiomaDe} ";
        }
        if ($idiomaPara) {
            $query .= " AND PRO_IdIdiomaDest = {$idiomaPara} ";
        }
        if ($juramentada) {
            $query .= " AND PRO_Tipo = {$juramentada} ";
        }
        $query .= " GROUP BY COM_IdComercial ";

        $result = ConnectTotal::getInstance()->query($query)->fetchAll(PDO::FETCH_COLUMN, 0);

        if ($result) {
            $this->idsComercial = implode(", ", $result);
        }

    }

    public function findAll(): ?DataLayer
    {
        if (isset($this->idsComercial)) {
            return parent::find(
                "COM_IdComercial IN ($this->idsComercial)"
            );
        }
        return null;

    }

    public function consultor(): Recursos
    {
        return (new Recursos())->find("REC_IdRecurso = :idConsultor", "idConsultor={$this->COM_IdConsultor}")->fetch();
    }

    public function dataCadastro(): string
    {
        try {
            return decodeDate($this->COM_DataCadastro);
        } catch (\Exception $e) {
            return "Sem data";
        }
    }
    public function dataAprovacao(): string
    {
        if($this->COM_DataAprovacao){
            try {
                return decodeDate($this->COM_DataAprovacao);
            } catch (\Exception $e) {
                return "Sem data";
            }
        }
        return "";

    }


    public function somaArquivos(): string
    {
        $totalDePalavras = 0;

        if ($this->COM_IdOrcamento) {
            $this->arquivosNew();
            if (is_array($this->arquivosNew)) {
                foreach ($this->arquivosNew as $arquivoNew) {
                    $totalDePalavras += $arquivoNew->OARQ_Palavras;
                }
                return $totalDePalavras;
            } else {
                return 0;
            }

        }

        $this->projeto();
        if ($this->projetos) {
            foreach ($this->projetos as $projeto) {
                $totalDePalavras += $projeto->PRO_Palavras;
            }
            return $totalDePalavras;
        }
        return 0;

    }

    public function statusComercial(): string
    {
        switch ($this->COM_StatusComercial) {
            case 1:
                return "Proposta";
                break;
            case 2:
                return "Aprovado";
                break;
            case 3:
                return "Recusada";
                break;
            case 4:
                return "Cancelado";
                break;
            default:
                return "Status não encontrado";
        }
    }

    public function idiomas(): array
    {
        if ($this->COM_IdOrcamento) {
            $this->orcamentoNew();
            return $this->orcamentoNew->idiomasPrincipais();
        }

        $this->projeto();
        if (isset($this->projetos[0])) {
            return $this->projetos[0]->idiomasPrincipais();
        }
        return ["idiomaDe" => "", "idiomaPara" => ""];

    }

    public function tipoTraducaoGeral(): string
    {
        if ($this->COM_IdOrcamento) {
            $this->orcamentoNew();
            return $this->orcamentoNew->OORC_Juramentado = 1 ? "Juramentado" : "Simples";
        }

        $this->projeto();
        if (isset($this->projetos[0])) {
            return $this->projetos[0]->PRO_Tipo = 1 ? "Simples" : "Juramentada";
        }
        return "Nao detectavel";

    }
    
    
    /**
     * SECTION TO CHARTS
     */
    public function resumoStatusComercial()
    {
        
    }

}