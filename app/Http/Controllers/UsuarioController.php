<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UsuarioController extends Controller
{
    public function getRol_usuario(Request $request)
    {
        try {
            $rol = $request->auth()->user()->rol_id;
            $usuario_rol = User::when($rol, function ($query) use ($rol) {
                $query->where('rold_id', $rol);
            })->get();
            $response = ['data' => $usuario_rol];
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Error al traer registros'], 500);
        }
        return response()->json($response);
    }
}
