<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MapaClienteController extends Controller
{
    /**
     * Mostrar el mapa con todos los clientes
     */
    public function index()
    {
        $clientes = Cliente::with(['telefonos', 'direccion', 'fotos'])
            ->whereHas('direccion')
            ->get()
            ->map(function ($cliente) {
                return [
                    'id' => $cliente->id,
                    'nombre' => $cliente->nombre_completo,
                    'telefono' => $cliente->telefonos->first()?->telefono,
                    'direccion' => $cliente->direccion ? [
                        'zona' => $cliente->direccion->zona,
                        'calle' => $cliente->direccion->calle,
                        'coordenadas' => $cliente->direccion->coordenadas,
                        'referencia' => $cliente->direccion->referencia,
                        'completa' => $cliente->direccion->direccion_completa,
                    ] : null,
                    'fotos' => $cliente->fotos->map(function ($foto) {
                        return [
                            'url' => asset('storage/' . $foto->ruta_foto),
                            'descripcion' => $foto->descripcion,
                        ];
                    }),
                ];
            });

        return view('mapa.mapacliente', [
            'clientes' => $clientes,
            'mapboxToken' => config('services.mapbox.token'),
        ]);
    }

    /**
     * Mostrar mapa para un cliente específico
     */
    public function show(Cliente $cliente)
    {
        $cliente->load(['telefonos', 'direccion', 'fotos']);

        $clienteData = [
            'id' => $cliente->id,
            'nombre' => $cliente->nombre_completo,
            'telefono' => $cliente->telefonos->first()?->telefono,
            'direccion' => $cliente->direccion ? [
                'zona' => $cliente->direccion->zona,
                'calle' => $cliente->direccion->calle,
                'coordenadas' => $cliente->direccion->coordenadas,
                'referencia' => $cliente->direccion->referencia,
                'completa' => $cliente->direccion->direccion_completa,
            ] : null,
            'fotos' => $cliente->fotos->map(function ($foto) {
                return [
                    'url' => asset('storage/' . $foto->ruta_foto),
                    'descripcion' => $foto->descripcion,
                ];
            }),
        ];

        return view('mapa.mapacliente', [
            'clientes' => collect([$clienteData]),
            'clienteEspecifico' => true,
            'mapboxToken' => config('services.mapbox.token'),
        ]);
    }

    /**
     * Geocodificar una dirección usando Mapbox Geocoding API
     */
    public function geocode(Request $request)
    {
        $request->validate([
            'direccion' => 'required|string',
        ]);

        $direccion = $request->direccion;
        $token = config('services.mapbox.token');

        // Geocoding con contexto de Bolivia, La Paz
        $response = Http::get("https://api.mapbox.com/geocoding/v5/mapbox.places/{$direccion}.json", [
            'access_token' => $token,
            'country' => 'BO',
            'proximity' => '-68.1193,	-16.5000', // La Paz, Bolivia
            'limit' => 1,
        ]);

        if ($response->successful() && !empty($response->json()['features'])) {
            $feature = $response->json()['features'][0];
            return response()->json([
                'success' => true,
                'coordinates' => $feature['center'], // [lng, lat]
                'place_name' => $feature['place_name'],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No se pudo geocodificar la dirección',
        ], 404);
    }
}
