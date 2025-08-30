<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHEF</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="font-sans bg-gray-50">

    <x-header></x-header>

    {{-- Toasts --}}
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
        <main class="flex-1 p-10 bg-gray-50 overflow-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-red-700">Encomendas</h1>
                <a href="{{ route('encomenda.create') }}"
                   class="bg-yellow-500 text-white px-6 py-2 rounded-md font-semibold shadow hover:bg-yellow-600 transition">
                    + Adicionar Encomenda
                </a>
            </div>

            <!-- Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                @forelse($encomendas as $encomenda)
                    <div id="encomenda-{{ $encomenda->id }}" class="bg-white shadow rounded-lg p-4 flex flex-col justify-between hover:shadow-lg transition">
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <h2 class="text-lg font-bold text-red-700">{{ $encomenda->nome_cliente }}</h2>
                                <span id="status-{{ $encomenda->id }}" class="px-3 py-1 text-white text-sm rounded-full 
                                    {{ $encomenda->status === 'pendente' ? 'bg-yellow-500' : 'bg-red-600' }}">
                                    {{ ucfirst($encomenda->status) }}
                                </span>
                            </div>

                            <p class="text-gray-700 font-semibold">Itens:</p>
                            <ul class="text-gray-700 mb-3">
                                @foreach($encomenda->receita as $index => $nomeReceita)
                                    <li>
                                        {{ $nomeReceita }} – 
                                        <input type="number" value="{{ $encomenda->quantidade[$index] ?? 1 }}" 
                                               class="w-20 border rounded px-2 py-1 text-sm"> porções
                                    </li>
                                @endforeach
                            </ul>

                            <p class="flex items-center text-gray-500 mb-2">
                                📅 Entrega: {{ \Carbon\Carbon::parse($encomenda->data)->format('d/m/Y') }}
                            </p>
                            <p class="font-bold text-gray-900">R$ {{ number_format($encomenda->valor ?? 0, 2, ',', '.') }}</p>
                        </div>

                        @if($encomenda->status === 'pendente')
                            <button onclick="processarPedido({{ $encomenda->id }})" 
                                    class="mt-4 bg-red-700 text-white w-full py-2 rounded shadow hover:bg-red-600 transition">
                                Processar Pedido
                            </button>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500">Nenhuma encomenda cadastrada.</p>
                @endforelse
            </div>
        </main>
    </div>

    <script>
        function processarPedido(id) {
            Swal.fire({
                title: 'Processar pedido?',
                text: "O status será atualizado para confirmado.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, processar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/encomenda/${id}/processar`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ status: 'confirmado' })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Atualiza badge
                            const statusSpan = document.getElementById(`status-${id}`);
                            statusSpan.textContent = 'Confirmado';
                            statusSpan.classList.remove('bg-yellow-500');
                            statusSpan.classList.add('bg-blue-600');

                            // Remove botão
                            const btn = document.querySelector(`#encomenda-${id} button`);
                            if (btn) btn.remove();

                            Swal.fire('Sucesso!', 'O pedido foi processado.', 'success');
                        } else {
                            Swal.fire('Erro!', 'Não foi possível processar o pedido.', 'error');
                        }
                    })
                    .catch(() => Swal.fire('Erro!', 'Ocorreu um erro.', 'error'));
                }
            });
        }
    </script>
</body>
</html>
