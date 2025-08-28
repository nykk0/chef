<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHEF</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans bg-gray-100">

    <!-- Header fixo -->
    <header class="w-full bg-white shadow flex justify-between items-center px-6 py-3 fixed top-0 left-0 z-50">
        <div class="flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6c-2.21 0-4 1.79-4 4v1H7v2h2v5h6v-5h2v-2h-1v-1c0-2.21-1.79-4-4-4z" />
            </svg>
            <span class="text-xl font-bold text-red-600">CHEF</span>
        </div>
        <div>
            <span class="font-semibold text-gray-800">Olá, {{$user->username}}</span>
        </div>
    </header>

    <!-- Container principal com sidebar e conteúdo -->
    <div class="flex pt-10 min-h-screen"> <!-- pt-16 para compensar o header fixo -->
        <!-- Conteúdo principal -->
        <main class="flex-1 p-10 bg-gray-100 overflow-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-red-800">Receitas</h1>
                <a href="#"
                   class="bg-yellow-400 text-white px-6 py-2 rounded-md font-semibold shadow hover:bg-yellow-500 transition">
                    + Adicionar Receita
                </a>
            </div>

            <!-- Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-red-600 to-red-400 px-4 py-3">
                        <h2 class="text-lg font-bold text-white">Bolo de chocolate</h2>
                    </div>
                    <div class="p-4 text-gray-700">
                        <p>Tempo: 45 minutos</p>
                        <p>Dificuldade: Média</p>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-red-600 to-red-400 px-4 py-3">
                        <h2 class="text-lg font-bold text-white">Cookies</h2>
                    </div>
                    <div class="p-4 text-gray-700">
                        <p>Tempo: 30 minutos</p>
                        <p>Dificuldade: Fácil</p>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-red-600 to-red-400 px-4 py-3">
                        <h2 class="text-lg font-bold text-white">Receitas</h2>
                    </div>
                    <div class="p-4 text-gray-700">
                        <p>Tempo: 40 minutos</p>
                        <p>Dificuldade: Fácil</p>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-red-600 to-red-400 px-4 py-3">
                        <h2 class="text-lg font-bold text-white">Brigadeiros</h2>
                    </div>
                    <div class="p-4 text-gray-700">
                        <p>Tempo: 25 minutos</p>
                        <p>Dificuldade: Fácil</p>
                    </div>
                </div>
            </div>
        </main>

    </div>
</body>
</html>
