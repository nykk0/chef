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
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-2xl font-bold text-red-800">Cadastrar Receita</h1>
                </div>

            <form
                action="{{ isset($receita) ? route('receita.update', $receita->id) : route('receita.store') }}"
                method="POST">

                @csrf
                @if(isset($receita))
                    @method('PUT')
                @endif

                <!-- Nome -->
                <div class="mb-4">
                    <label class="block font-semibold mb-2">Nome da Receita</label>
                    <input type="text" name="nome"
                        value="{{ old('nome', $receita->nome ?? '') }}"
                        class="w-full border rounded p-2" required>
                </div>

                <div class="flex gap-4">
                    <!-- Tempo -->
                    <div class="w-1/2">
                        <label class="block font-semibold mb-2">Tempo de Preparo</label>
                        <input type="text" name="tempo_preparo"
                            value="{{ old('tempo_preparo', $receita->tempo_preparo ?? '') }}"
                            class="w-full border rounded p-2" required>
                    </div>

                    <!-- Valor -->
                    <div class="w-1/2">
                        <label class="block font-semibold mb-2">Valor (R$)</label>
                        <input type="number" step="0.01" name="valor"
                            value="{{ old('valor', $receita->valor ?? '') }}"
                            class="w-full border rounded p-2" required>
                    </div>
                </div>

                <!-- Ingredientes -->
                <div class="mb-4">
                    <label class="block font-semibold mb-2">Ingredientes</label>
                    <div id="ingredientes-container">
                        @php
                            $ingredientesIds = isset($receita) ? explode(',', $receita->ingredientes_ids) : [];
                            $ingredientesQtds = isset($receita) ? explode(',', $receita->ingredientes_qtds) : [];
                        @endphp

                        <button type="button" onclick="addIngrediente()" class="text-red-600 font-semibold mt-2">
                        + Adicionar Item
                        </button>
                        @if(isset($receita))
                            @foreach($ingredientesIds as $index => $id)
                                <div class="flex space-x-2 mb-2">
                                    <select name="ingredientes[]" class="flex-1 border rounded p-2" required>
                                        <option value="">Selecione</option>
                                        @foreach($ingredientes as $item)
                                            <option value="{{ $item->id }}" {{ $item->id == $id ? 'selected' : '' }}>
                                                {{ $item->nome .' - Unidade: '. $item->unidade_saida }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="number" name="quantidades[]"
                                        value="{{ $ingredientesQtds[$index] ?? '' }}"
                                        class="w-24 border rounded p-2" placeholder="Qtd" required>
                                    <button type="button" onclick="this.parentNode.remove()"
                                            class="bg-red-500 text-white px-3 rounded">-</button>
                                </div>
                            @endforeach
                            @else
                                <div class="flex space-x-2 mb-2">
                                    <select name="ingredientes[]" class="flex-1 border rounded p-2" required>
                                        <option value="">Selecione</option>
                                        @foreach($ingredientes as $item)
                                            <option value="{{ $item->id }}">{{ $item->nome .' - Unidade: '. $item->unidade_saida }}</option>
                                        @endforeach
                                    </select>
                                    <input type="number" name="quantidades[]" class="w-24 border rounded p-2" placeholder="Qtd" required>
                                </div>
                        @endif
                    </div>
                </div>

                <!-- Modo de preparo -->
                <div class="mb-4">
                    <label class="block font-semibold mb-2">Modo de Preparo</label>
                    <textarea name="modo_preparo" rows="5" class="w-full border rounded p-2" required>{{ old('modo_preparo', $receita->modo_preparo ?? '') }}</textarea>
                </div>

                <!-- Botão -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded shadow hover:bg-yellow-600">
                        {{ isset($receita) ? 'Atualizar Receita' : 'Salvar Receita' }}
                    </button>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
    <script>
        function addIngrediente() {
            const container = document.getElementById('ingredientes-container');
            const div = document.createElement('div');
            div.classList.add('flex','space-x-2','mb-2');

            div.innerHTML = `
                <select name="ingredientes[]" class="flex-1 border rounded p-2" required>
                    <option value="">Selecione</option>
                    @foreach($ingredientes as $item)
                        <option value="{{ $item->id }}">{{ $item->nome .' - Unidade: '. $item->unidade_saida }}</option>
                    @endforeach
                </select>
                <input type="number" name="quantidades[]" class="w-24 border rounded p-2" placeholder="Qtd" required>
                <button type="button" onclick="this.parentNode.remove()" class="bg-red-500 text-white px-3 rounded">-</button>
            `;
            container.appendChild(div);
        }
    </script>
