<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function tela_cadastro()
    {
        return view('auth.register');
    }

    public function tela_login()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'O campo Nome Completo é obrigatório.',
            'name.max' => 'O campo Nome Completo deve ter no máximo 255 caracteres.',
            'email.required' => 'O campo Email é obrigatório.',
            'email.email' => 'O Email deve ser válido.',
            'email.unique' => 'Este Email já está em uso.',
            'phone.required' => 'O campo Telefone é obrigatório.',
            'phone.max' => 'O campo Telefone deve ter no máximo 15 caracteres.',
            'username.required' => 'O campo Nome de Usuário é obrigatório.',
            'username.unique' => 'Este Nome de Usuário já está em uso.',
            'password.required' => 'O campo Senha é obrigatório.',
            'password.min' => 'A Senha deve ter no mínimo 8 caracteres.',
            'password.confirmed' => 'A confirmação da Senha não confere.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create($request->all());

        return redirect()->route('login')->with('success', 'Cadastro realizado com sucesso!');
    }
}
