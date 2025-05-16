<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alimento extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'categoria', 'quantidade', 'estoque_minimo', 'validade'];

    // Constantes para categorias
    const CATEGORIAS = [
        'frutas' => 'Frutas',
        'legumes' => 'Legumes',
        'carnes' => 'Carnes',
        'laticinios' => 'Laticínios',
        'graos' => 'Grãos',
        'outros' => 'Outros'
    ];

    // Método para verificar se o estoque está baixo
    public function estoqueBaixo()
    {
        return $this->quantidade <= $this->estoque_minimo;
    }

    // Método para verificar se está próximo da validade (7 dias)
    public function validadeProxima()
    {
        if (!$this->validade) {
            return false;
        }
        return now()->diffInDays($this->validade) <= 7;
    }
}
