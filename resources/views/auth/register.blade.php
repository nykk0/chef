<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHEF</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans bg-gray-50">
    <!-- Navbar -->
    <header class="bg-white text-gray-800 shadow-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <span class="font-extrabold text-xl text-red-600">LOGO</span>
                <span class="font-semibold text-xl text-red-600">CHEF</span>
            </a>
            <nav class="hidden md:flex space-x-6 text-lg font-medium">
                <a href="{{ route('home') }}" class="hover:text-red-600">Início</a>
                <a href="{{ route('home') }}" class="hover:text-red-600">Recursos</a>
                <a href="{{ route('home') }}" class="hover:text-red-600">Preços</a>
                <a href="{{ route('home') }}" class="hover:text-red-600">Sobre</a>
                <a href="{{ route('home') }}" class="hover:text-red-600">Contato</a>
            </nav>
            <div class="flex items-center space-x-3">
                <a a href="{{ route('login') }}" class="border border-gray-800 px-4 py-2 rounded-md hover:bg-gray-800 transition">Entrar</a>
                <a href="{{ route('register') }}" class="bg-yellow-400 text-white px-6 py-2 rounded-md hover:bg-yellow-300 transition">Cadastre-se</a>
            </div>
        </div>
    </header>

    <section class="bg-gray-200 py-16">
        <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-3xl font-semibold text-center text-red-700 mb-6">Cadastro</h2>
            <form action="{{ route('register') }}" method="POST" >
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold">Nome Completo</label>
                    <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('name') border-red-600 @enderror" value="{{ old('name') }}">
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold">Email</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('email') border-red-600 @enderror" value="{{ old('email') }}">
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 font-semibold">Telefone</label>
                    <input type="text" id="phone" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('phone') border-red-600 @enderror" value="{{ old('phone') }}">
                </div>

                <div class="mb-4">
                    <label for="username" class="block text-gray-700 font-semibold">Nome de Usuário</label>
                    <input type="text" id="username" name="username" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('username') border-red-600 @enderror" value="{{ old('username') }}">

                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-semibold">Senha</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('password') border-red-600 @enderror">
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-gray-700 font-semibold">Confirmar Senha</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                    <p id="password-error" class="text-red-600 text-sm mt-2 hidden">As senhas não coincidem.</p>
                </div>

                <div class="mb-6">
                    <button type="submit" id="submit-btn" class="w-full bg-yellow-400 text-white px-6 py-2 rounded-md hover:bg-yellow-300 transition disabled:opacity-50" disabled>Cadastrar</button>
                </div>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-red-600 text-white pt-12 pb-6">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-10">
            <div>
                <span class="font-bold text-2xl">LOGO</span>
                <span class="font-bold text-2xl text-yellow-400"> CHEF</span>
            </div>
            <div>
                <h3 class="font-semibold mb-3">Institucional</h3>
                <ul class="space-y-2">
                    <li><a href="#sobre" class="hover:underline">Sobre</a></li>
                    <li><a href="#depoimentos" class="hover:underline">Depoimentos</a></li>
                    <li><a href="#contato" class="hover:underline">Contato</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-semibold mb-3">Ferramentas</h3>
                <ul class="space-y-2">
                    <li><a href="#recursos" class="hover:underline">Funcionalidades</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-semibold mb-3">Fale com a gente</h3>
                <ul class="space-y-2">
                    <li>+55 (31) xxxx-xxxx</li>
                    <li><a href="mailto:chefereceitas@gmail.com" class="hover:underline">chefereceitas@gmail.com</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-10 pt-4 text-center text-sm text-gray-300">
            &copy; 2025 - CHEF - Todos os direitos reservados
        </div>
    </footer>

</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.6/dist/inputmask.min.js"></script>
<script>
    // Validação de senhas
    const password = document.getElementById('password');
    const passwordConfirmation = document.getElementById('password_confirmation');
    const submitBtn = document.getElementById('submit-btn');
    const passwordError = document.getElementById('password-error');

    passwordConfirmation.addEventListener('input', function() {
        console.log(password.value,passwordConfirmation.value);

        if (password.value !== passwordConfirmation.value) {
            passwordError.classList.remove('hidden');
            submitBtn.disabled = true;
        } else {
            passwordError.classList.add('hidden');
            submitBtn.disabled = false;
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        // máscara para o campo de telefone (formato (XX) XXXXX-XXXX)
        var phoneInput = document.getElementById('phone');
        var im = new Inputmask('(99) 99999-9999'); // definindo a máscara para telefone
        im.mask(phoneInput);
    });

</script>


