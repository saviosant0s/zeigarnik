<?php

namespace App\Http\Controllers;

use App\Models\ArticleRead;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BibliotecaController extends Controller
{
    /**
     * Registro estático dos artigos (conteúdo mora direto nas views Blade,
     * aqui só ficam os metadados: ordem, título e tempo estimado de leitura).
     */
    public const ARTIGOS = [
        'quem-foi-zeigarnik' => [
            'titulo' => 'Quem foi Bluma Zeigarnik',
            'tempo' => 5,
        ],
        'experimento-1927' => [
            'titulo' => 'O Experimento Original (1927)',
            'tempo' => 8,
        ],
        'efeito-na-pratica' => [
            'titulo' => 'O Efeito na prática',
            'tempo' => 6,
        ],
        'rituais-encerramento' => [
            'titulo' => 'Por que rituais de encerramento funcionam',
            'tempo' => 7,
        ],
        'como-usar-sistema' => [
            'titulo' => 'Como usar o Sistema Zeigarnik',
            'tempo' => 4,
        ],
    ];

    public function index(): View
    {
        $lidos = ArticleRead::pluck('read_at', 'article_slug');

        $artigos = collect(self::ARTIGOS)->map(function ($dados, $slug) use ($lidos) {
            return array_merge($dados, [
                'slug' => $slug,
                'lido' => $lidos->has($slug),
            ]);
        })->values();

        return view('biblioteca.index', [
            'artigos' => $artigos,
            'totalLidos' => $lidos->count(),
            'totalArtigos' => count(self::ARTIGOS),
        ]);
    }

    public function show(string $slug): View
    {
        abort_unless(array_key_exists($slug, self::ARTIGOS), 404);

        $slugs = array_keys(self::ARTIGOS);
        $posicao = array_search($slug, $slugs);

        $anterior = $slugs[$posicao - 1] ?? null;
        $proximo = $slugs[$posicao + 1] ?? null;

        $lido = ArticleRead::where('article_slug', $slug)->exists();

        return view("biblioteca.artigos.{$slug}", [
            'slug' => $slug,
            'meta' => self::ARTIGOS[$slug],
            'anterior' => $anterior ? ['slug' => $anterior, 'titulo' => self::ARTIGOS[$anterior]['titulo']] : null,
            'proximo' => $proximo ? ['slug' => $proximo, 'titulo' => self::ARTIGOS[$proximo]['titulo']] : null,
            'lido' => $lido,
        ]);
    }

    public function marcarLido(string $slug): RedirectResponse
    {
        abort_unless(array_key_exists($slug, self::ARTIGOS), 404);

        ArticleRead::updateOrCreate(
            ['article_slug' => $slug],
            ['read_at' => now()]
        );

        return back()->with('status', 'Artigo marcado como lido.');
    }
}
