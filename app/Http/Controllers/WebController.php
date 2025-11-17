<?php

namespace App\Http\Controllers;

use App\Models\Testimonio;
use App\Models\Promocion;
use Illuminate\Http\Request;

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

        return view('web.home', compact('testimonios', 'promocion'));
    }

    /**
     * Página de productos
     */
    public function productos(Request $request)
    {
        $categoria = $request->get('categoria', 'todas');

        $categoriasValidas = [
            'shampoos',
            'acondicionadores',
            'cremas',
            'tratamientos',
            'linea-natural',
            'linea-infantil'
        ];

        return view('web.productos', compact('categoria', 'categoriasValidas'));
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
