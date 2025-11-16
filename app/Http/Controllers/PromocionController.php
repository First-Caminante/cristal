<?php

namespace App\Http\Controllers;

use App\Models\Promocion;
use App\Models\PromocionFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PromocionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promociones = Promocion::with('fotos')
            ->latest('fecha_inicio')
            ->paginate(10);

        return view('promociones.index', compact('promociones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('promociones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'precio' => 'nullable|numeric|min:0',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'fotos' => 'nullable|array',
            'fotos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();

        try {
            // Crear promoción
            $promocion = Promocion::create([
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
            ]);

            // Guardar fotos
            if ($request->hasFile('fotos')) {
                foreach ($request->file('fotos') as $foto) {
                    $ruta = $foto->store('promociones/fotos', 'public');

                    PromocionFoto::create([
                        'promo_id' => $promocion->id,
                        'ruta_foto' => $ruta,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('promociones.index')
                ->with('success', 'Promoción creada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()
                ->with('error', 'Error al crear la promoción: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Promocion $promocion)
    {
        $promocion->load('fotos');
        return view('promociones.show', compact('promocion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promocion $promocion)
    {
        $promocion->load('fotos');
        return view('promociones.edit', compact('promocion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promocion $promocion)
    {
        $request->validate([
            'titulo' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'precio' => 'nullable|numeric|min:0',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'fotos' => 'nullable|array',
            'fotos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'fotos_eliminar' => 'nullable|array',
        ]);

        DB::beginTransaction();

        try {
            // Actualizar datos de la promoción
            $promocion->update([
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
            ]);

            // Eliminar fotos marcadas
            if ($request->has('fotos_eliminar')) {
                foreach ($request->fotos_eliminar as $fotoId) {
                    $foto = PromocionFoto::find($fotoId);
                    if ($foto && $foto->promo_id == $promocion->id) {
                        Storage::disk('public')->delete($foto->ruta_foto);
                        $foto->delete();
                    }
                }
            }

            // Agregar nuevas fotos
            if ($request->hasFile('fotos')) {
                foreach ($request->file('fotos') as $foto) {
                    $ruta = $foto->store('promociones/fotos', 'public');

                    PromocionFoto::create([
                        'promo_id' => $promocion->id,
                        'ruta_foto' => $ruta,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('promociones.index')
                ->with('success', 'Promoción actualizada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()
                ->with('error', 'Error al actualizar la promoción: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promocion $promocion)
    {
        DB::beginTransaction();

        try {
            // Eliminar fotos del storage
            foreach ($promocion->fotos as $foto) {
                Storage::disk('public')->delete($foto->ruta_foto);
            }

            // Eliminar fotos y promoción
            $promocion->fotos()->delete();
            $promocion->delete();

            DB::commit();

            return redirect()->route('promociones.index')
                ->with('success', 'Promoción eliminada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Error al eliminar la promoción: ' . $e->getMessage());
        }
    }
}
