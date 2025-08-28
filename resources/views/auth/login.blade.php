<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHEF</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans bg-gray-50 flex flex-col min-h-screen">

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
                <a href="{{ route('login') }}" class="border border-gray-800 px-4 py-2 rounded-md hover:bg-gray-800 transition">Entrar</a>
                <a href="{{ route('register') }}" class="bg-yellow-400 text-white px-6 py-2 rounded-md hover:bg-yellow-300 transition">Cadastre-se</a>
            </div>
        </div>
    </header>

    <!-- Login Section -->
    <section class="bg-gray-200 py-16 flex-grow">
        <div class="max-w-7xl mx-auto px-6">
            <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
                <h2 class="text-3xl font-semibold text-center text-red-700 mb-6">Login</h2>
                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                        <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-md @error('email') border-red-600 @enderror" value="{{ old('email') }}" placeholder="Digite seu email">
                        @error('email')
                            <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-6 relative">
                        <label for="password" class="block text-gray-700 font-semibold mb-2">Senha</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-md pr-10 @error('password') border-red-600 @enderror"
                            placeholder="Digite sua senha"
                        >
                        <button
                            type="button"
                            onclick="togglePassword()"
                            class="mt-4 absolute right-2 top-1/2 -translate-y-1/2 flex items-center justify-center text-gray-500"
                        >
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>

                        @error('password')
                            <span class="text-red-600 text-sm mt-2 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <button type="submit" class="w-full bg-yellow-400 text-white px-6 py-3 rounded-md hover:bg-yellow-300 transition">Entrar</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-red-600 text-white pt-12 pb-6 mt-auto">
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
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            // opcional: trocar ícone para "olho aberto"
            eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a10.05 10.05 0 011.698-3.042m2.34-2.313A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-1.59 2.774M15 12a3 3 0 11-6 0 3 3 0 016 0z" />`;
        } else {
            passwordInput.type = "password";
            // voltar ícone original
            eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
        }
    }
</script>
