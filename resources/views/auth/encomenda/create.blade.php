<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHEF - Nova Receita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="font-sans bg-white">

    <x-header></x-header>

    <div class="flex pt-10 min-h-screen lg:ml-64">
        <main class="flex-1 p-10 bg-gray-100 overflow-auto">

            <h1 class="text-2xl font-bold text-red-800 mb-6">Registrar Uma Nova Receita</h1>

            <form action="" method="POST" class="space-y-4 bg-white p-6 shadow rounded">
                @csrf

                <div>
                    <label class="block font-semibold text-gray-800">Nome do Cliente</label>
                    <input type="text" name="nome_cliente" placeholder="Nome do Cliente" value="{{ old('nome_cliente') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-gray-800">Receitas</label>
                        <input type="text" name="receitas[]" placeholder="Receitas" value="{{ old('receitas.0') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block font-semibold text-gray-800">Qtd.</label>
                            <input type="number" name="quantidade" placeholder="Porções" value="{{ old('quantidade') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>
                        <div class="flex items-center">
                            <button type="button" class="text-red-600 font-semibold ml-2">+Adicionar ingrediente</button>
                        </div>
                    </div>                    
                </div>

                <div class="col-span-3">
                    <label class="block font-semibold text-gray-800">Observações</label>
                    <textarea name="observacoes"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500" 
                    rows="5">{{ old('observacoes') }}</textarea>
                </div>
                    
                <div class="col-span-full mt-4 flex justify-end">
                    <button type="submit"
                        class="bg-red-700 text-white px-6 py-2 rounded shadow hover:bg-red-800 transition">
                        Registrar receita
                    </button>
                </div>
            </form>

        </main>
    </div>
</body>
</html>
