<?php

namespace App\Http\Controllers;

use App\Models\Testimonio;
use Illuminate\Http\Request;

class TestimonioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonios = Testimonio::latest('fecha_publicacion')
            ->paginate(10);

        return view('testimonios.index', compact('testimonios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('testimonios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'comentario' => 'required|string',
            'fuente' => 'nullable|string|max:50',
            'fecha_publicacion' => 'required|date',
            'visible' => 'boolean',
        ]);

        Testimonio::create([
            'nombre' => $request->nombre,
            'comentario' => $request->comentario,
            'fuente' => $request->fuente,
            'fecha_publicacion' => $request->fecha_publicacion,
            'visible' => $request->has('visible') ? 1 : 0,
        ]);

        return redirect()->route('testimonios.index')
            ->with('success', 'Testimonio creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonio $testimonio)
    {
        return view('testimonios.show', compact('testimonio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonio $testimonio)
    {
        return view('testimonios.edit', compact('testimonio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonio $testimonio)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'comentario' => 'required|string',
            'fuente' => 'nullable|string|max:50',
            'fecha_publicacion' => 'required|date',
            'visible' => 'boolean',
        ]);

        $testimonio->update([
            'nombre' => $request->nombre,
            'comentario' => $request->comentario,
            'fuente' => $request->fuente,
            'fecha_publicacion' => $request->fecha_publicacion,
            'visible' => $request->has('visible') ? 1 : 0,
        ]);

        return redirect()->route('testimonios.index')
            ->with('success', 'Testimonio actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonio $testimonio)
    {
        $testimonio->delete();

        return redirect()->route('testimonios.index')
            ->with('success', 'Testimonio eliminado exitosamente.');
    }

    /**
     * Toggle visibility of a testimonial.
     */
    public function toggleVisible(Testimonio $testimonio)
    {
        $testimonio->update([
            'visible' => !$testimonio->visible
        ]);

        return back()->with('success', 'Visibilidad actualizada.');
    }
}
