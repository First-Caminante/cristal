<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Testimonio;
use App\Models\Promocion;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Mostrar el dashboard según el rol del usuario
     */
    public function index()
    {
        $user = auth()->user();

        // Si es vendedor, mostrar página en blanco
        if ($user->isVendedor()) {
            return view('dashboard.vendedor');
        }

        // Si es superadmin o admin, mostrar dashboard con estadísticas
        if ($user->isSuperAdmin() || $user->isAdmin()) {
            $stats = [
                'total_clientes' => Cliente::count(),
                'total_testimonios' => Testimonio::count(),
                'total_promociones' => Promocion::count(),
                'total_usuarios' => User::count(),
            ];

            return view('dashboard.admin', compact('stats'));
        }

        // Si no tiene rol, logout
        auth()->logout();
        return redirect()->route('login');
    }
}
