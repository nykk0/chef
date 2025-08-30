<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHEF - Nova Encomenda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            });
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
            });
        </script>
    @endif

    <div class="flex pt-10 min-h-screen lg:ml-64">
        <main class="flex-1 p-10 bg-white overflow-auto">

            <h1 class="text-2xl font-bold text-red-800 mb-6">Registrar Uma Nova Encomenda</h1>

            <form action="{{ route('encomenda.store') }}" method="POST" class="space-y-6 bg-white p-6 shadow rounded">
                @csrf

                <!-- Data + Nome do cliente -->
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="w-full md:w-40">
                        <label class="block font-semibold text-gray-800">Data de Entrega</label>
                        <input type="date" name="data" value="{{ old('data') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>
                    <div class="w-full md:w-40">
                        <label class="block font-semibold text-gray-800">Telefone</label>
                        <input type="text" name="telefone" id="telefone" value="{{ old('telefone') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500"
                            placeholder="(99) 99999-9999">
                    </div>

                    <div class="flex-1">
                        <label class="block font-semibold text-gray-800">Nome do Cliente</label>
                        <input type="text" name="nome_cliente" placeholder="Nome do Cliente" value="{{ old('nome_cliente') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>
                </div>

                <!-- Container das receitas -->
                <div id="receitas-container" class="space-y-4">
                    @php $oldItens = old('itens', [[]]); @endphp
                
                    @foreach($oldItens as $i => $item)
                        <div class="flex flex-col md:flex-row gap-4 receita-item">
                            <div class="flex-1">
                                <label class="block font-semibold text-gray-800">Receita</label>
                                <select name="itens[{{ $i }}][receita]" onchange="atualizarValorTotal()"
                                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500">
                                    <option value="">Selecione uma receita</option>
                                    @foreach($receitas as $receita)
                                        <option value="{{ $receita->id }}"
                                            {{ (isset($item['receita']) && $item['receita'] == $receita->id) ? 'selected' : '' }}>
                                            {{ $receita->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-full md:w-32">
                                <label class="block font-semibold text-gray-800">Qtd.</label>
                                <input type="number" name="itens[{{ $i }}][quantidade]"
                                    value="{{ $item['quantidade'] ?? '' }}"
                                    oninput="atualizarValorTotal()" placeholder="Porções" min="1"
                                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500">
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Botão adicionar receita -->
                <div class="flex">
                    <button type="button" id="add-receita" class="text-red-600 font-semibold mt-2">
                        + Adicionar receita
                    </button>
                </div>
                <!-- Valor Total -->
                <div class="mb-4">
                    <label class="block font-semibold text-gray-800">Valor Total (R$)</label>
                    <input type="text" id="valor-total" name="valor" value="0.00" required
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500 bg-gray-100">
                </div>

                <!-- Observações -->
                <div>
                    <label class="block font-semibold text-gray-800">Observações</label>
                    <textarea name="observacoes"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500"
                        rows="5">{{ old('observacoes') }}</textarea>
                </div>

                <!-- Botão salvar -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-red-700 text-white px-6 py-2 rounded shadow hover:bg-red-800 transition">
                        Registrar Encomenda
                    </button>
                </div>
            </form>

        </main>
    </div>

    <script>
        const receitaValores = @json($receitas->pluck('valor','id'));

        function atualizarValorTotal() {
            let total = 0;

            document.querySelectorAll('.receita-item').forEach(item => {
                const select = item.querySelector('select');
                const quantidade = item.querySelector('input[type="number"]');
                const receitaId = parseInt(select.value);
                const qtd = parseInt(quantidade.value) || 0;

                if(receitaId && receitaValores[receitaId]) {
                    total += receitaValores[receitaId] * qtd;
                }
            });

            document.getElementById('valor-total').value = total.toFixed(2);
        }


        // Máscara para telefone
        const telefoneInput = document.getElementById('telefone');
        telefoneInput.addEventListener('input', function(e) {
            let x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
            e.target.value = !x[2] ? x[1] : `(${x[1]}) ${x[2]}${x[3] ? '-' + x[3] : ''}`;
        });

        // Adicionar novas receitas dinamicamente
        let receitaIndex = document.querySelectorAll('.receita-item').length;
        document.getElementById('add-receita').addEventListener('click', function () {
            const container = document.getElementById('receitas-container');

            const novaReceita = document.createElement('div');
            novaReceita.classList.add('flex', 'flex-col', 'md:flex-row', 'gap-4', 'receita-item', 'mt-2');
            novaReceita.innerHTML = `
                <div class="flex-1">
                    <label class="block font-semibold text-gray-800">Receita</label>
                    <select name="itens[${receitaIndex}][receita]" onchange="atualizarValorTotal()"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500">
                        <option value="">Selecione uma receita</option>
                        @foreach($receitas as $receita)
                            <option value="{{ $receita->id }}">{{ $receita->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full md:w-32">
                    <label class="block font-semibold text-gray-800">Qtd.</label>
                    <input type="number" name="itens[${receitaIndex}][quantidade]" placeholder="Porções" min="1"
                        oninput="atualizarValorTotal()"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>
            `;
            container.appendChild(novaReceita);
            receitaIndex++;
        });
    </script>
</body>
</html>
