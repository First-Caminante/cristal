<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ClienteTelefono;
use App\Models\ClienteDireccion;
use App\Models\ClienteFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::with(['telefonos', 'direccion', 'fotos'])
            ->latest('creado_en')
            ->paginate(10);

        return view('clientes.index', compact('clientes'));
    }

    /**
     * Búsqueda de clientes
     */
    public function buscar(Request $request)
    {
        $tipoBusqueda = $request->input('tipo_busqueda');
        $termino = $request->input('termino');

        $clientes = Cliente::with(['telefonos', 'direccion', 'fotos']);

        if ($tipoBusqueda && $termino) {
            switch ($tipoBusqueda) {
                case 'nombre':
                    $clientes->where(function ($query) use ($termino) {
                        $query->where('nombres', 'like', "%{$termino}%")
                            ->orWhere('apellidos', 'like', "%{$termino}%");
                    });
                    break;

                case 'zona':
                    $clientes->whereHas('direccion', function ($query) use ($termino) {
                        $query->where('zona', 'like', "%{$termino}%");
                    });
                    break;

                case 'telefono':
                    $clientes->whereHas('telefonos', function ($query) use ($termino) {
                        $query->where('telefono', 'like', "%{$termino}%");
                    });
                    break;
            }
        }

        $clientes = $clientes->latest('creado_en')->paginate(10);

        return view('clientes.index', compact('clientes', 'tipoBusqueda', 'termino'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'cedula_identidad' => 'nullable|string|max:200',
            'correo' => 'nullable|email|max:120',

            // Teléfonos (máximo 3)
            'telefonos' => 'nullable|array|max:3',
            'telefonos.*.numero' => 'required|string|max:20',
            'telefonos.*.descripcion' => 'nullable|string|max:100',

            // Dirección (solo 1)
            'direccion.zona' => 'required|string|max:255',
            'direccion.calle' => 'required|string|max:255',
            'direccion.coordenadas' => 'nullable|string|max:100',
            'direccion.referencia' => 'nullable|string|max:255',

            // Fotos (máximo 3)
            'fotos' => 'nullable|array|max:3',
            'fotos.*' => 'image|mimes:jpeg,png,jpg,gif|max:15360',
        ]);

        DB::beginTransaction();

        try {
            // Crear cliente
            $cliente = Cliente::create([
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'cedula_identidad' => $request->cedula_identidad,
                'correo' => $request->correo,
            ]);

            // Guardar teléfonos
            if ($request->has('telefonos')) {
                foreach ($request->telefonos as $index => $telefono) {
                    if (!empty($telefono['numero'])) {
                        ClienteTelefono::create([
                            'cliente_id' => $cliente->id,
                            'telefono' => $telefono['numero'],
                            'descripcion' => $telefono['descripcion'] ?? null,
                            'es_principal' => $index === 0 ? 1 : 0,
                        ]);
                    }
                }
            }

            // Guardar dirección (solo una)
            if ($request->has('direccion')) {
                ClienteDireccion::create([
                    'cliente_id' => $cliente->id,
                    'zona' => $request->direccion['zona'],
                    'calle' => $request->direccion['calle'],
                    'coordenadas' => $request->direccion['coordenadas'] ?? null,
                    'referencia' => $request->direccion['referencia'] ?? null,
                    'es_principal' => 1,
                ]);
            }

            // Guardar fotos
            if ($request->hasFile('fotos')) {
                foreach ($request->file('fotos') as $index => $foto) {
                    $ruta = $foto->store('clientes/fotos', 'public');

                    ClienteFoto::create([
                        'cliente_id' => $cliente->id,
                        'ruta_foto' => $ruta,
                        'descripcion' => "Foto " . ($index + 1),
                        'orden' => $index + 1,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('clientes.index')
                ->with('success', 'Cliente creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()
                ->with('error', 'Error al crear el cliente: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        $cliente->load(['telefonos', 'direccion', 'fotos']);
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        $cliente->load(['telefonos', 'direccion', 'fotos']);
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'cedula_identidad' => 'nullable|string|max:200',
            'correo' => 'nullable|email|max:120',

            'telefonos' => 'nullable|array|max:3',
            'telefonos.*.numero' => 'required|string|max:20',
            'telefonos.*.descripcion' => 'nullable|string|max:100',

            'direccion.zona' => 'required|string|max:255',
            'direccion.calle' => 'required|string|max:255',
            'direccion.coordenadas' => 'nullable|string|max:100',
            'direccion.referencia' => 'nullable|string|max:255',

            'fotos' => 'nullable|array|max:3',
            'fotos.*' => 'image|mimes:jpeg,png,jpg,gif|max:15360',
            'fotos_eliminar' => 'nullable|array',
        ]);

        DB::beginTransaction();

        try {
            // Actualizar datos del cliente
            $cliente->update([
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'cedula_identidad' => $request->cedula_identidad,
                'correo' => $request->correo,
            ]);

            // Actualizar teléfonos (eliminar los antiguos y crear nuevos)
            $cliente->telefonos()->delete();
            if ($request->has('telefonos')) {
                foreach ($request->telefonos as $index => $telefono) {
                    if (!empty($telefono['numero'])) {
                        ClienteTelefono::create([
                            'cliente_id' => $cliente->id,
                            'telefono' => $telefono['numero'],
                            'descripcion' => $telefono['descripcion'] ?? null,
                            'es_principal' => $index === 0 ? 1 : 0,
                        ]);
                    }
                }
            }

            // Actualizar dirección
            $cliente->direccion()->delete();
            if ($request->has('direccion')) {
                ClienteDireccion::create([
                    'cliente_id' => $cliente->id,
                    'zona' => $request->direccion['zona'],
                    'calle' => $request->direccion['calle'],
                    'coordenadas' => $request->direccion['coordenadas'] ?? null,
                    'referencia' => $request->direccion['referencia'] ?? null,
                    'es_principal' => 1,
                ]);
            }

            // Eliminar fotos marcadas
            if ($request->has('fotos_eliminar')) {
                foreach ($request->fotos_eliminar as $fotoId) {
                    $foto = ClienteFoto::find($fotoId);
                    if ($foto && $foto->cliente_id == $cliente->id) {
                        Storage::disk('public')->delete($foto->ruta_foto);
                        $foto->delete();
                    }
                }
            }

            // Agregar nuevas fotos
            if ($request->hasFile('fotos')) {
                $fotosActuales = $cliente->fotos()->count();
                $espacioDisponible = 3 - $fotosActuales;

                foreach ($request->file('fotos') as $index => $foto) {
                    if ($index < $espacioDisponible) {
                        $ruta = $foto->store('clientes/fotos', 'public');

                        ClienteFoto::create([
                            'cliente_id' => $cliente->id,
                            'ruta_foto' => $ruta,
                            'descripcion' => "Foto " . ($fotosActuales + $index + 1),
                            'orden' => $fotosActuales + $index + 1,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('clientes.index')
                ->with('success', 'Cliente actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()
                ->with('error', 'Error al actualizar el cliente: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        DB::beginTransaction();

        try {
            // Eliminar fotos del storage
            foreach ($cliente->fotos as $foto) {
                Storage::disk('public')->delete($foto->ruta_foto);
            }

            // Eliminar relaciones y el cliente
            $cliente->fotos()->delete();
            $cliente->telefonos()->delete();
            $cliente->direccion()->delete();
            $cliente->delete();

            DB::commit();

            return redirect()->route('clientes.index')
                ->with('success', 'Cliente eliminado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Error al eliminar el cliente: ' . $e->getMessage());
        }
    }
}
