<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductoCategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductoCategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = ProductoCategoria::withCount('productos')
            ->latest()
            ->paginate(10);
        return view('admin.categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:producto_categorias,nombre',
        ]);

        ProductoCategoria::create([
            'nombre' => $request->nombre,
            'slug' => Str::slug($request->nombre),
            'estado' => $request->has('estado') ? true : false,
        ]);

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría creada exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductoCategoria $categoria)
    {
        return view('admin.categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductoCategoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:producto_categorias,nombre,' . $categoria->id,
        ]);

        $categoria->update([
            'nombre' => $request->nombre,
            'slug' => Str::slug($request->nombre),
            'estado' => $request->has('estado') ? true : false,
        ]);

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductoCategoria $categoria)
    {
        if ($categoria->productos()->count() > 0) {
            return back()->with('error', 'No se puede eliminar la categoría porque tiene productos asociados.');
        }

        $categoria->delete();

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría eliminada exitosamente.');
    }
}
