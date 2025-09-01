<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function tela_cadastro()
    {
        return view('auth.register');
    }

    public function tela_update()
    {
        $user = Auth::user();
        return view('auth.alter_user', compact('user'));
    }

    public function tela_login()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'phone'    => 'required|string|max:15',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $this->userService->register($request->all());

        return redirect()->route('login')->with('success', 'Cadastro realizado com sucesso!');
    }

    public function updateUser(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'email'       => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone'       => 'required|string|max:15',
            'username'    => 'required|string|max:255|unique:users,username,' . $user->id,
            'senha_atual' => 'nullable|required_with:nova_senha|string',
            'nova_senha'  => 'nullable|min:6|required_with:senha_atual|same:confirmar_senha',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Erro!')->withInput();
        }

        if ($request->filled('senha_atual') && !Hash::check($request->senha_atual, $user->password)) {
            return redirect()->back()->withErrors(['senha_atual' => 'A senha atual está incorreta.'])->with('error', 'Erro!')->withInput();
        }

        $this->userService->update($user, $request->all());

        return redirect()->route('alter_user')->with('success', 'Dados atualizados com sucesso!');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('login')->withErrors(['error' => "Email ou senha inválidos!"]);
        }

        return redirect()->route("receita")->with("success", "Logado com Sucesso!");
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('msg', 'Usuario deslogado com Sucesso!');
    }
}
