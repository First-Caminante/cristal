<?php

namespace App\Http\Controllers;

use App\Models\Testimonio;
use App\Models\Promocion;
use Illuminate\Http\Request;

use App\Models\Producto;
use App\Models\ProductoCategoria;

class WebController extends Controller
{
    /**
     * Página de inicio
     */
    public function home()
    {
        // Obtener testimonios visibles (máximo 6)
        $testimonios = Testimonio::visible()
            ->recientes()
            ->limit(6)
            ->get();

        // Obtener promoción activa (si hay)
        $promocion = Promocion::activas()->with('fotos')->first();

        // Obtener contenido dinámico del home
        $content = $this->getHomeContent();

        return view('web.home', compact('testimonios', 'promocion', 'content'));
    }

    private function getHomeContent()
    {
        $jsonPath = storage_path('app/home_content.json');
        $content = null;

        if (file_exists($jsonPath)) {
            $content = json_decode(file_get_contents($jsonPath), true);
        }

        // If content is null (empty file) or not an array, use defaults
        if (!is_array($content)) {
            return [
                'hero' => [
                    'title' => 'Industrias Cristal',
                    'text' => 'Cosméticos de calidad premium para tu cuidado personal. Descubre nuestra línea completa de productos para el cabello y la piel.',
                    'image' => 'home/default_hero.jpg',
                ],
                'featured' => [
                    'title' => 'Shampoo Cristal Premium',
                    'description' => 'Nuestro producto más icónico que ha conquistado miles de hogares. Con fórmula enriquecida que nutre profundamente tu cabello, dejándolo suave, brillante y saludable desde la primera aplicación.',
                    'image' => 'home/default_featured.jpg',
                    'benefits' => [
                        'Nutre e hidrata profundamente',
                        'Protección contra el daño diario',
                        'Brillo y suavidad instantáneos'
                    ]
                ]
            ];
        }

        return $content;
    }

    /**
     * Página de productos
     */
    public function productos(Request $request)
    {
        $categoriaSlug = $request->get('categoria', 'todas');

        // Obtener categorías activas para la navegación
        $categorias = ProductoCategoria::active()->get();
        $categoriasValidas = $categorias->pluck('slug')->toArray();

        // Obtener productos filtrados o todos
        $query = Producto::active()->with('categoria');

        if ($categoriaSlug !== 'todas' && in_array($categoriaSlug, $categoriasValidas)) {
            $query->whereHas('categoria', function ($q) use ($categoriaSlug) {
                $q->where('slug', $categoriaSlug);
            });
        }

        $productos = $query->latest()->get();
        $categoria = $categoriaSlug;

        return view('web.productos', compact('categoria', 'categorias', 'productos'));
    }

    /**
     * Página nosotros
     */
    public function nosotros()
    {
        return view('web.nosotros');
    }

    /**
     * Página valores
     */
    public function valores()
    {
        return view('web.valores');
    }

    /**
     * Página contacto
     */
    public function contacto()
    {
        return view('web.contacto');
    }
}
