<?php

namespace App\Services;

class Table
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

//     +---+---+---+---+---------------+----------+
    // | P | E | L | R | Solução Completa | Descrição |
    // +---+---+---+---+---------------+----------+
    // | F | F | F | F | F              | O sistema não atende a nenhum requisito. |
    // | F | F | F | T | F              | O sistema atende apenas ao requisito de gerar relatórios. |
    // | F | F | T | F | F              | O sistema atende apenas ao requisito de rastreamento de localização. |
    // | F | F | T | T | F              | O sistema atende aos requisitos de rastreamento de localização e geração de relatórios. |
    // | F | T | F | F | F              | O sistema atende apenas ao requisito de atualização de estoque. |
    // | F | T | F | T | F              | O sistema atende aos requisitos de atualização de estoque e geração de relatórios. |
    // | F | T | T | F | F              | O sistema atende aos requisitos de atualização de estoque e rastreamento de localização. |
    // | F | T | T | T | F              | O sistema atende aos requisitos de atualização de estoque, rastreamento de localização e geração de relatórios. |
    // | T | F | F | F | F              | O sistema atende apenas ao requisito de cadastro de produtos. |
    // | T | F | F | T | F              | O sistema atende aos requisitos de cadastro de produtos e geração de relatórios. |
    // | T | F | T | F | F              | O sistema atende aos requisitos de cadastro de produtos e rastreamento de localização. |
    // | T | F | T | T | F              | O sistema atende aos requisitos de cadastro de produtos, rastreamento de localização e geração de relatórios. |
    // | T | T | F | F | F              | O sistema atende aos requisitos de cadastro de produtos e atualização de estoque. |
    // | T | T | F | T | F              | O sistema atende aos requisitos de cadastro de produtos, atualização de estoque e geração de relatórios. |
    // | T | T | T | F | F              | O sistema atende aos requisitos de cadastro de produtos, atualização de estoque e rastreamento de localização. |
    // | T | T | T | T | T              | O sistema atende a todos os requisitos. |
    // +---+---+---+---+---------------+----------+
}
