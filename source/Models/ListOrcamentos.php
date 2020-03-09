<?php


namespace Source\Models;


class ListOrcamentos
{

    private array $listOrcamentos;

    private array $resumoStatusComercial;

    public function __construct(array $listOrcamentos)
    {
        $this->listOrcamentos = $listOrcamentos;
    }

    public function listOrcamentos(): ?array
    {
        if (!is_array($this->listOrcamentos)) {
            return null;
        }
        return $this->listOrcamentos;
    }

    public function resumoStatusComercial()
    {
        if (!is_array($this->listOrcamentos)) {
            return null;
        }

        /** @var Comercial $orcamento */
        foreach ($this->listOrcamentos as $orcamento) {
            if (!isset($this->resumoStatusComercial[$orcamento->statusComercial()])) {
                $this->resumoStatusComercial[$orcamento->statusComercial()] = 1;
            } else {
                $this->resumoStatusComercial[$orcamento->statusComercial()] += 1;
            }
        }

        return $this->resumoStatusComercial;
    }


}