<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHEF</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans bg-white">

    <x-header></x-header>
    <div class="flex pt-10 min-h-screen lg:ml-64">
        <!-- Conteúdo principal -->
        <main class="flex-1 p-10 bg-white overflow-auto">
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
<script>
    const userMenuButton = document.getElementById('userMenuButton');
    const userSubmenu = document.getElementById('userSubmenu');

    userMenuButton.addEventListener('click', () => {
        userSubmenu.classList.toggle('hidden');
    });

    document.addEventListener('click', function(event) {
        if (!userMenuButton.contains(event.target) && !userSubmenu.contains(event.target)) {
            userSubmenu.classList.add('hidden');
        }
    });
</script>
