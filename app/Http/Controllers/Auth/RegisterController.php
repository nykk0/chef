<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
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

    public function updateUser(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:15',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'senha_atual' => 'nullable|required_with:nova_senha|string',
            'nova_senha' => 'nullable|min:6|required_with:senha_atual|same:confirmar_senha',
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
            'senha_atual.required_with' => 'Informe a senha atual para alterar a senha.',
            'nova_senha.min' => 'A nova senha deve ter no mínimo 6 caracteres.',
            'nova_senha.same' => 'A confirmação da nova senha não confere.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', 'Erro!')->withInput();
        }

        // Verifica se a senha atual está correta
        if ($request->filled('senha_atual') && !Hash::check($request->senha_atual, $user->password)) {
            return redirect()->back()->withErrors(['senha_atual' => 'A senha atual está incorreta.'])->with('error', 'Erro!')->withInput();
        }

        // Atualiza os dados do usuário
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->username = $request->username;

        if ($request->filled('nova_senha')) {
            $user->password = bcrypt($request->nova_senha);
        }

        $user->save();

        return redirect()->route('alter_user')->with('success', 'Dados atualizados com sucesso!');
    }


    public function login(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required',
        ], [
            'email.required' => 'O Email é obrigatorio.',
            'password.required' => 'O campo Senha é obrigatório.',
        ]);

        $credentials = $request->only('email','password');
        $auth = Auth::attempt(['email'=> $request->email,'password'=> $request->password]);

        if(!$auth){
           return redirect()->route('login')->withErrors(['error' => "Email ou senha inválidos!"]);
        }else{
            return redirect()->route("receita")->with("success","Logado com Sucesso!");
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('msg', 'Usuario deslogado com Sucesso!');
    }
}
