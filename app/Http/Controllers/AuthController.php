<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Mostrar el formulario de registro
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Registrar un nuevo usuario
    public function register(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email', 
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.unique' => 'El correo electrónico ya ha sido registrado.',
            'name.required' => 'El nombre es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
        ]);

        // Crear un nuevo usuario
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // Iniciar sesión automáticamente
        Auth::login($user);

        // Redireccionar 
        return redirect('/');
    }

    // Mostrar el formulario de inicio de sesión
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Iniciar sesión
    public function login(Request $request)
    {
        // Validar los datos del formulario
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        // Intentar autenticar al usuario
        if (Auth::attempt($credentials)) {
            // Autenticación exitosa
            return redirect()->intended('/');
        } else {
            // Autenticación fallida
            return back()->withErrors([
                'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
            ]);
        }
    }

    // Método para cerrar sesión
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
