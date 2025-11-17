<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;





/**Aqui comienza persona 2
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
            'token'   => $token,
        ], 200);
    }
    /**Aqui termina persona 2