<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHEF - Configurações</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans bg-white">

    <x-header></x-header>
    @if($errors->any())
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: "{{ $errors->first() }}",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            })
        </script>
    @endif

    @if(session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            })
        </script>
    @endif

    <div class="flex pt-10 min-h-screen lg:ml-64">
        <!-- Conteúdo principal -->
        <main class="flex-1 p-10 bg-white overflow-auto">

            <!-- Título -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-red-800">Configurações</h1>
            </div>

            <form action="{{ route('user.update') }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Informações Pessoais -->
                <fieldset class="border border-gray-300 rounded-lg p-6 mb-8">
                    <legend class="text-lg font-semibold text-red-700 px-2">Informações Pessoais</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">

                        <!-- Nome Completo -->
                        <div>
                            <label for="nome" class="block text-gray-700 font-medium mb-2">Nome Completo</label>
                            <input type="text" id="nome" value="{{ old('name', $user->name) }}" name="name"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500">
                            @error('name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-gray-700 font-medium mb-2">E-mail</label>
                            <input type="email" id="email" value="{{ old('email', $user->email) }}" name="email"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500">
                            @error('email')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Telefone -->
                        <div>
                            <label for="phone" class="block text-gray-700 font-medium mb-2">Telefone</label>
                            <input type="tel" id="phone" value="{{ old('phone', $user->phone) }}" name="phone"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500">
                            @error('phone')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nome de Usuário -->
                        <div>
                            <label for="username" class="block text-gray-700 font-medium mb-2">Nome de Usuário</label>
                            <input type="text" id="username" value="{{ old('username', $user->username) }}" name="username"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500">
                            @error('username')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </fieldset>

                <!-- Alterar Senha -->
                <fieldset class="border border-gray-300 rounded-lg p-6">
                    <legend class="text-lg font-semibold text-red-700 px-2">Alterar Senha</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">

                        <!-- Senha Atual -->
                        <div>
                            <label for="senha_atual" class="block text-gray-700 font-medium mb-2">Senha Atual</label>
                            <input type="password" id="senha_atual" name="senha_atual"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500">
                            @error('senha_atual')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nova Senha -->
                        <div>
                            <label for="nova_senha" class="block text-gray-700 font-medium mb-2">Nova Senha</label>
                            <input type="password" id="nova_senha" name="nova_senha"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500">
                            @error('nova_senha')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirmar Senha -->
                        <div>
                            <label for="confirmar_senha" class="block text-gray-700 font-medium mb-2">Confirmar Senha</label>
                            <input type="password" id="confirmar_senha" name="confirmar_senha"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500">
                            @error('nova_senha') {{-- Laravel vai usar a mesma validação de same:confirmar_senha --}}
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p id="senha-diferente" class="text-red-600 text-sm mt-1 hidden">As senhas não coincidem.</p>
                        </div>

                    </div>
                </fieldset>

                <div class="mt-6">
                    <button type="submit"
                            class="bg-yellow-400 text-white px-6 py-2 rounded-md font-semibold shadow hover:bg-yellow-500 transition">
                        Salvar Alterações
                    </button>
                </div>
            </form>

        </main>
    </div>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.6/dist/inputmask.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var phoneInput = document.getElementById('phone');
        var im = new Inputmask('(99) 99999-9999'); // definindo a máscara para telefone
        im.mask(phoneInput);
    });

    document.addEventListener('DOMContentLoaded', function () {
        var phoneInput = document.getElementById('phone');
        var im = new Inputmask('(99) 99999-9999');
        im.mask(phoneInput);

        const novaSenha = document.getElementById('nova_senha');
        const confirmarSenha = document.getElementById('confirmar_senha');
        const aviso = document.getElementById('senha-diferente');

        confirmarSenha.addEventListener('input', function () {
            if (confirmarSenha.value !== novaSenha.value) {
                aviso.classList.remove('hidden');
            } else {
                aviso.classList.add('hidden');
            }
        });
    });

</script>
