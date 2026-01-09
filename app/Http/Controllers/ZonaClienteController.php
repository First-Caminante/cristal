<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ZonaClienteController extends Controller
{
    protected $filePath = 'zonas_clientes.json';

    /**
     * Display a listing of the zones.
     */
    public function index()
    {
        $zonas = $this->getZonas();
        $clientes = Cliente::orderBy('nombres')->orderBy('apellidos')->get();
        return view('admin.zonas.index', compact('zonas', 'clientes'));
    }

    /**
     * Store a newly created zone.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $zonas = $this->getZonas();
        $zonas[] = [
            'id' => (string) Str::uuid(),
            'nombre' => $request->nombre,
            'clientes' => []
        ];

        $this->saveZonas($zonas);

        return redirect()->back()->with('success', 'Zona creada correctamente.');
    }

    /**
     * Update the specified zone (add/remove clients).
     */
    public function update(Request $request, $id)
    {
        $zonas = $this->getZonas();
        $index = collect($zonas)->search(fn($z) => $z['id'] === $id);

        if ($index === false) {
            return redirect()->back()->with('error', 'Zona no encontrada.');
        }

        if ($request->has('clientes')) {
            $zonas[$index]['clientes'] = array_map('intval', $request->clientes);
        } else {
            $zonas[$index]['clientes'] = [];
        }

        if ($request->has('nombre')) {
            $zonas[$index]['nombre'] = $request->nombre;
        }

        $this->saveZonas($zonas);

        return redirect()->back()->with('success', 'Zona actualizada correctamente.');
    }

    /**
     * Remove the specified zone.
     */
    public function destroy($id)
    {
        $zonas = $this->getZonas();
        $zonas = array_filter($zonas, fn($z) => $z['id'] !== $id);
        $this->saveZonas(array_values($zonas));

        return redirect()->back()->with('success', 'Zona eliminada correctamente.');
    }

    /**
     * Helper to get zones from JSON.
     */
    private function getZonas()
    {
        if (!Storage::exists($this->filePath)) {
            return [];
        }
        return json_decode(Storage::get($this->filePath), true) ?: [];
    }

    /**
     * Helper to save zones to JSON.
     */
    private function saveZonas($zonas)
    {
        Storage::put($this->filePath, json_encode($zonas, JSON_PRETTY_PRINT));
    }

    /**
     * API endpoint to get zones for the map.
     */
    public function apiIndex()
    {
        return response()->json($this->getZonas());
    }
}
