<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


     /**
     * LOGIN DE USUARIO
     * Genera un token de acceso si las credenciales son válidas.
     */
    public function login(Request $request)
    {
        $request->validate([
            'correo'   => 'required|email',
            'password' => 'required|string',
        ], [
            'correo.required'   => 'Debe ingresar un correo.',
            'correo.email'      => 'Formato de correo inválido.',
            'password.required' => 'Debe ingresar una contraseña.',
        ]);

        $usuario = Usuario::where('correo', $request->correo)->first();

        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            return response()->json([
                'message' => 'Las credenciales no son válidas.',
            ], 401);
        }

        $token = $usuario->createToken('token_auth')->plainTextToken;

        return response()->json([
            'message' => 'Inicio de sesión exitoso.',
            'usuario' => $usuario,
            'token' => $token,
        ],200);
    }


    /**
     * LOGOUT GLOBAL
     * Elimina todos los tokens activos del usuario autenticado.
     */
    public function logout(Request $request)
    {
        // Revoca todos los tokens asociados al usuario actual
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Sesión cerrada correctamente. Todos los tokens fueron eliminados.',
        ], 200);
    }
    