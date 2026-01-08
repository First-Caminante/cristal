<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\ProductoCategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::with('categoria')
            ->latest()
            ->paginate(10);
        return view('admin.productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = ProductoCategoria::active()->get();
        return view('admin.productos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'categoria_id' => 'required|exists:producto_categorias,id',
            'nombre' => 'required|string|max:150|unique:productos,nombre',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'descripcion' => 'nullable|string',
            'caracteristicas' => 'nullable|array',
            'caracteristicas.*' => 'nullable|string|max:50',
        ]);

        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('productos', 'public');
        }

        // Filtrar características vacías
        $caracteristicas = array_filter($request->input('caracteristicas', []), function ($val) {
            return !empty($val);
        });

        Producto::create([
            'categoria_id' => $request->categoria_id,
            'nombre' => $request->nombre,
            'slug' => Str::slug($request->nombre),
            'imagen' => $imagenPath,
            'descripcion' => $request->descripcion,
            'caracteristicas' => array_values($caracteristicas),
            'estado' => $request->has('estado') ? true : false,
        ]);

        return redirect()->route('productos.admin.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        $categorias = ProductoCategoria::active()->get();
        return view('admin.productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'categoria_id' => 'required|exists:producto_categorias,id',
            'nombre' => 'required|string|max:150|unique:productos,nombre,' . $producto->id,
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'descripcion' => 'nullable|string',
            'caracteristicas' => 'nullable|array',
            'caracteristicas.*' => 'nullable|string|max:50',
        ]);

        $data = [
            'categoria_id' => $request->categoria_id,
            'nombre' => $request->nombre,
            'slug' => Str::slug($request->nombre),
            'descripcion' => $request->descripcion,
            'estado' => $request->has('estado') ? true : false,
        ];

        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        // Filtrar características vacías
        $caracteristicas = array_filter($request->input('caracteristicas', []), function ($val) {
            return !empty($val);
        });
        $data['caracteristicas'] = array_values($caracteristicas);

        $producto->update($data);

        return redirect()->route('productos.admin.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }
        $producto->delete();

        return redirect()->route('productos.admin.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }
}
