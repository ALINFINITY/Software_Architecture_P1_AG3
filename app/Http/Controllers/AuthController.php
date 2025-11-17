<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthController extends Controller
{
    /**
     * REGISTRO DE USUARIO
     * Crea el usuario y genera un token automaticamente.
     */
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre'   => 'required|string|max:100',
                'correo'   => 'required|string|email|unique:usuarios,correo',
                'password' => 'required|string|min:6',
                'rol'      => 'in:ADMIN,USER',
            ], [
                'nombre.required'   => 'El nombre es obligatorio.',
                'correo.required'   => 'El correo es obligatorio.',
                'correo.email'      => 'El formato del correo no es válido.',
                'correo.unique'     => 'El correo ya está registrado.',
                'password.required' => 'La contraseña es obligatoria.',
                'password.min'      => 'La contraseña debe tener al menos 6 caracteres.',
                'rol.in'            => 'El rol debe ser ADMIN o USER.',
            ]);

            $usuario = Usuario::create([
                'nombre'   => $validated['nombre'],
                'correo'   => $validated['correo'],
                'password' => Hash::make($validated['password']),
                'rol'      => $validated['rol'] ?? 'USER',
            ]);

            $token = $usuario->createToken('token_auth')->plainTextToken;

            return response()->json([
                'message' => 'Usuario registrado correctamente. Ahora puede iniciar sesión.',
                'usuario' => $usuario,
                'token'   => $token,
            ], 201);

        } catch (ValidationException $e) {
            throw new HttpResponseException(response()->json([
                'message' => 'Error en el registro.',
                'errors'  => $e->errors(),
            ], 422));
        }
    }

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

}