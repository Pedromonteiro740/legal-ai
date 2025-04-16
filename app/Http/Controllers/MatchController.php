<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MatchController extends Controller
{
    private $fakeProfiles = [
        [
            'nome' => 'Dra. Ana Silva',
            'cargo' => 'Advogada Digital Sênior',
            'area' => 'Direito Digital',
            'localizacao' => 'São Paulo',
            'descricao' => 'Especialista em LGPD e compliance digital com 10 anos de experiência',
            'tags' => ['LGPD', 'Compliance', 'Proteção de Dados'],
            'peso' => [
                'Direito Digital' => 0.85,
                'São Paulo' => 0.90,
                'Regulatório' => 0.75
            ]
        ],
        [
            'nome' => 'Carlos Oliveira',
            'cargo' => 'Consultor em PI',
            'area' => 'Propriedade Intelectual',
            'localizacao' => 'Rio de Janeiro',
            'descricao' => '15 anos atuando em marcas e patentes internacionais',
            'tags' => ['Marcas', 'Patentes', 'Direito Autoral'],
            'peso' => [
                'Propriedade Intelectual' => 0.95,
                'Rio de Janeiro' => 0.85,
                'Contratos' => 0.65
            ]
        ],
        [
            'nome' => 'Mariana Costa',
            'cargo' => 'Especialista em Compliance',
            'area' => 'Regulatório',
            'localizacao' => 'Brasília',
            'descricao' => 'Consultoria em conformidade regulatória para fintechs',
            'tags' => ['Fintechs', 'Regulação', 'Auditoria'],
            'peso' => [
                'Regulatório' => 0.92,
                'Brasília' => 0.95,
                'Direito Digital' => 0.60
            ]
        ],
        [
            'nome' => 'Fernando Gomes',
            'cargo' => 'Advogado Trabalhista',
            'area' => 'Direito do Trabalho',
            'localizacao' => 'Belo Horizonte',
            'descricao' => 'Atuação em direito coletivo e negociações sindicais',
            'tags' => ['CLT', 'Sindicatos', 'Negociações'],
            'peso' => [
                'Direito do Trabalho' => 0.88,
                'Belo Horizonte' => 0.80,
                'Contratos' => 0.70
            ]
        ],
        [
            'nome' => 'Juliana Santos',
            'cargo' => 'Especialista em Contratos',
            'area' => 'Contratos',
            'localizacao' => 'São Paulo',
            'descricao' => 'Redação e revisão de contratos internacionais',
            'tags' => ['NDA', 'Contratos', 'Internacional'],
            'peso' => [
                'Contratos' => 0.93,
                'São Paulo' => 0.85,
                'Propriedade Intelectual' => 0.68
            ]
        ],
        [
            'nome' => 'Ricardo Almeida',
            'cargo' => 'Consultor Tributário',
            'area' => 'Tributário',
            'localizacao' => 'Curitiba',
            'descricao' => 'Planejamento tributário para empresas de tecnologia',
            'tags' => ['Impostos', 'Auditoria', 'Consultoria'],
            'peso' => [
                'Tributário' => 0.91,
                'Curitiba' => 0.78,
                'Regulatório' => 0.72
            ]
        ],
        [
            'nome' => 'Patrícia Lima',
            'cargo' => 'Advogada Empresarial',
            'area' => 'Societário',
            'localizacao' => 'Porto Alegre',
            'descricao' => 'Fusões e aquisições de empresas de médio porte',
            'tags' => ['Fusões', 'Aquisições', 'Due Diligence'],
            'peso' => [
                'Societário' => 0.89,
                'Porto Alegre' => 0.82,
                'Contratos' => 0.77
            ]
        ],
        [
            'nome' => 'Roberto Nunes',
            'cargo' => 'Especialista em Dados',
            'area' => 'Direito Digital',
            'localizacao' => 'São Paulo',
            'descricao' => 'Implementação de programas de governança de dados',
            'tags' => ['Big Data', 'LGPD', 'Governança'],
            'peso' => [
                'Direito Digital' => 0.94,
                'São Paulo' => 0.91,
                'Regulatório' => 0.81
            ]
        ],
        [
            'nome' => 'Amanda Costa',
            'cargo' => 'Consultora Internacional',
            'area' => 'Contratos',
            'localizacao' => 'Brasília',
            'descricao' => 'Contratos comerciais internacionais e arbitragem',
            'tags' => ['Arbitragem', 'Comércio', 'Exportação'],
            'peso' => [
                'Contratos' => 0.90,
                'Brasília' => 0.87,
                'Societário' => 0.69
            ]
        ],
        [
            'nome' => 'Lucas Rocha',
            'cargo' => 'Advogado Criminalista',
            'area' => 'Direito Penal',
            'localizacao' => 'Rio de Janeiro',
            'descricao' => 'Defesa em crimes de colarinho branco',
            'tags' => ['Defesa', 'Processo Penal', 'Investigação'],
            'peso' => [
                'Direito Penal' => 0.92,
                'Rio de Janeiro' => 0.84,
                'Compliance' => 0.63
            ]
        ]
    ];

    public function showForm()
    {
        $areas = array_unique(array_column($this->fakeProfiles, 'area'));
        return view('welcome', compact('areas'));
    }

    public function findMatches(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'area' => 'required|string',
            'localizacao' => 'required|string|max:50'
        ]);

        $matches = collect($this->fakeProfiles)
            ->map(function ($profile) use ($validated) {
                return $this->calculateMatchScore($profile, $validated);
            })
            ->sortByDesc('afinidade')
            ->take(3)
            ->values();

        return back()->with([
            'matches' => $matches,
            'formData' => $validated
        ]);
    }

    private function calculateMatchScore($profile, $userInput)
    {
        $baseScore = 0;
        
        // Calcula similaridade da área
        $areaScore = $profile['peso'][$userInput['area']] ?? 0;
        $baseScore += $areaScore * 45;

        // Calcula similaridade da localização
        $locationScore = Str::contains($profile['localizacao'], $userInput['localizacao'])
            ? ($profile['peso'][$userInput['localizacao']] ?? 0.7)
            : 0.3;
        $baseScore += $locationScore * 35;

        // Fator de diversificação (evita resultados repetidos)
        $diversificationFactor = (rand(70, 100) / 100) * 20;

        // Combinação dos scores
        $totalScore = min($baseScore + $diversificationFactor, 99);

        return array_merge($profile, [
            'afinidade' => round($totalScore),
            'match_factors' => [
                'Área' => round($areaScore * 100, 1).'%',
                'Localização' => round($locationScore * 100, 1).'%',
                'Diversificação' => round($diversificationFactor, 1).'%'
            ]
        ]);
    }
}