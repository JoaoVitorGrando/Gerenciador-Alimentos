<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Alimento extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'quantidade', 'validade', 'categoria', 'estoque_minimo'];

    protected $casts = [
        'validade' => 'date',
    ];

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
        
        $hoje = Carbon::now();
        $validade = Carbon::parse($this->validade);
        
        // Verifica se a validade está no futuro e dentro dos próximos 7 dias
        return $validade->isFuture() && $validade->diffInDays($hoje) <= 7;
    }

    public static function comValidadeProxima()
    {
        $hoje = Carbon::now();
        $seteDias = $hoje->copy()->addDays(7);
        
        return self::whereNotNull('validade')
            ->where('validade', '>', $hoje)
            ->where('validade', '<=', $seteDias)
            ->get();
    }

    public static function comEstoqueBaixo()
    {
        return self::whereRaw('quantidade <= estoque_minimo')->get();
    }

    // Método para verificar se está vencido
    public function vencido()
    {
        if (!$this->validade) {
            return false;
        }
        
        return Carbon::parse($this->validade)->isPast();
    }

    // Método para obter o status da validade
    public function statusValidade()
    {
        if (!$this->validade) {
            return 'sem-validade';
        }

        if ($this->vencido()) {
            return 'vencido';
        }

        if ($this->validadeProxima()) {
            return 'proximo';
        }

        return 'valido';
    }
}
