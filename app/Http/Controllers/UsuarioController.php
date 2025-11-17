<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::with('role')
            ->latest('creado_en')
            ->paginate(10);

        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Búsqueda de usuarios
     */
    public function buscar(Request $request)
    {
        $tipoBusqueda = $request->input('tipo_busqueda');
        $termino = $request->input('termino');

        $usuarios = User::with('role');

        if ($tipoBusqueda && $termino) {
            switch ($tipoBusqueda) {
                case 'nombre':
                    $usuarios->where(function ($query) use ($termino) {
                        $query->where('nombre', 'like', "%{$termino}%")
                            ->orWhere('apellido', 'like', "%{$termino}%");
                    });
                    break;

                case 'correo':
                    $usuarios->where('correo', 'like', "%{$termino}%");
                    break;

                case 'rol':
                    $usuarios->whereHas('role', function ($query) use ($termino) {
                        $query->where('nombre', 'like', "%{$termino}%");
                    });
                    break;
            }
        }

        $usuarios = $usuarios->latest('creado_en')->paginate(10);

        return view('usuarios.index', compact('usuarios', 'tipoBusqueda', 'termino'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('usuarios.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'correo' => 'required|email|max:100|unique:usuarios,correo',
            'telefono' => 'nullable|string|max:20',
            'password' => ['required', 'confirmed', Password::defaults()],
            'rol_id' => 'required|exists:roles,id',
            'estado' => 'required|boolean',
        ]);

        try {
            User::create([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'correo' => $request->correo,
                'telefono' => $request->telefono,
                'password' => Hash::make($request->password),
                'rol_id' => $request->rol_id,
                'estado' => $request->estado,
            ]);

            return redirect()->route('usuarios.index')
                ->with('success', 'Usuario creado exitosamente.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error al crear el usuario: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $usuario)
    {
        $usuario->load('role');
        return view('usuarios.show', compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $usuario)
    {
        $roles = Role::all();
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'correo' => 'required|email|max:100|unique:usuarios,correo,' . $usuario->id,
            'telefono' => 'nullable|string|max:20',
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'rol_id' => 'required|exists:roles,id',
            'estado' => 'required|boolean',
        ]);

        try {
            $data = [
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'correo' => $request->correo,
                'telefono' => $request->telefono,
                'rol_id' => $request->rol_id,
                'estado' => $request->estado,
            ];

            // Solo actualizar password si se proporcionó uno nuevo
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $usuario->update($data);

            return redirect()->route('usuarios.index')
                ->with('success', 'Usuario actualizado exitosamente.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error al actualizar el usuario: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $usuario)
    {
        // Prevenir que el superadmin se elimine a sí mismo
        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminarte a ti mismo.');
        }

        try {
            $usuario->delete();

            return redirect()->route('usuarios.index')
                ->with('success', 'Usuario eliminado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el usuario: ' . $e->getMessage());
        }
    }

    /**
     * Toggle user status (activate/deactivate)
     */
    public function toggleEstado(User $usuario)
    {
        // Prevenir que el superadmin se desactive a sí mismo
        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'No puedes desactivarte a ti mismo.');
        }

        try {
            $usuario->update([
                'estado' => !$usuario->estado
            ]);

            $mensaje = $usuario->estado ? 'Usuario activado' : 'Usuario desactivado';

            return redirect()->route('usuarios.index')
                ->with('success', $mensaje . ' exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al cambiar el estado: ' . $e->getMessage());
        }
    }
}
