<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

/**
 * Controlador para la gestión de usuarios.
 * Implementa operaciones CRUD sobre la entidad Usuario.
 * Incluye validación de permisos según el rol del usuario autenticado.
 */
class UsuarioController extends Controller
{
    /**
     * Devuelve la lista de todos los usuarios registrados.
     * Solo ADMIN puede ver a todos; USER solo ve su propio perfil.
     */
    public function index(Request $request)
    {
        $usuarioAuth = $request->user();

        if ($usuarioAuth->rol === 'ADMIN') {
            $usuarios = Usuario::all();
        } else {
            // Los usuarios normales solo ven su propio registro
            $usuarios = Usuario::where('id', $usuarioAuth->id)->get();
        }

        return response()->json($usuarios, 200);
    }

    /**
     * Crea un nuevo usuario.
     * Solo permitido para ADMIN.
     */
    public function store(Request $request)
    {
        $usuarioAuth = $request->user();

        if ($usuarioAuth->rol !== 'ADMIN') {
            return response()->json(['message' => 'No tienes permisos para crear usuarios.'], 403);
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|unique:usuarios,correo',
            'password' => 'required|string|min:6',
            'fecha_nacimiento' => 'nullable|date',
            'sexo' => 'nullable|in:Masculino,Femenino,Otro',
            'numero_seguro' => 'nullable|string|max:100',
            'historial_medico' => 'nullable|string',
            'contacto_emergencia' => 'nullable|string|max:30',
            'rol' => 'nullable|in:ADMIN,USER',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $usuario = Usuario::create($validated);

        return response()->json([
            'message' => 'Usuario creado correctamente.',
            'usuario' => $usuario,
        ], 201);
    }

    /**
     * Muestra un usuario específico por su ID.
     * Los ADMIN pueden ver cualquier usuario; los USER solo el suyo.
     */
    public function show(Request $request, $id)
    {
        $usuarioAuth = $request->user();
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        if ($usuarioAuth->rol !== 'ADMIN' && $usuarioAuth->id !== $usuario->id) {
            return response()->json(['message' => 'No tienes permiso para ver este usuario.'], 403);
        }

        return response()->json($usuario, 200);
    }

    /**
     * Actualiza los datos de un usuario existente.
     * ADMIN puede modificar cualquier usuario.
     * USER solo puede actualizar su propio perfil.
     */
    public function update(Request $request, $id)
    {
        $usuarioAuth = $request->user();
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        // Verificación de permisos
        if ($usuarioAuth->rol !== 'ADMIN' && $usuarioAuth->id !== $usuario->id) {
            return response()->json(['message' => 'No tienes permiso para actualizar este usuario.'], 403);
        }

        $validated = $request->validate([
            'nombre' => 'sometimes|string|max:100',
            'correo' => [
                'sometimes',
                'email',
                Rule::unique('usuarios', 'correo')->ignore($id),
            ],
            'password' => 'sometimes|string|min:6',
            'fecha_nacimiento' => 'nullable|date',
            'sexo' => 'nullable|in:Masculino,Femenino,Otro',
            'numero_seguro' => 'nullable|string|max:100',
            'historial_medico' => 'nullable|string',
            'contacto_emergencia' => 'nullable|string|max:30',
            'rol' => 'nullable|in:ADMIN,USER',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $usuario->update($validated);

        return response()->json([
            'message' => 'Usuario actualizado correctamente.',
            'usuario' => $usuario,
        ], 200);
    }

    /**
     * Elimina un usuario existente.
     * Solo ADMIN puede eliminar usuarios.
     */
    public function destroy(Request $request, $id)
    {
        $usuarioAuth = $request->user();

        if ($usuarioAuth->rol !== 'ADMIN') {
            return response()->json(['message' => 'No tienes permisos para eliminar usuarios.'], 403);
        }

        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        $usuario->delete();

        return response()->json(['message' => 'Usuario eliminado correctamente.'], 200);
    }
}