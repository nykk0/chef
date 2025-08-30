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
        <main class="flex-1 p-10 bg-gray-50 overflow-auto">

            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-red-700">Encomendas</h1>
                <a href="{{ route('encomenda.create') }}"
                    class="bg-yellow-500 text-white px-6 py-2 rounded-md font-semibold shadow hover:bg-yellow-600 transition">
                    + Adicionar Encomenda
                </a>
            </div>

            <!-- Filtros -->
            <form method="GET" class="flex flex-wrap gap-4 mb-6">
                <div>
                    <label class="block font-semibold text-gray-700">Data Inicial</label>
                    <input type="date" name="data_inicial" value="{{ request('data_inicial') }}"
                        class="border rounded px-2 py-1">
                </div>
                <div>
                    <label class="block font-semibold text-gray-700">Data Final</label>
                    <input type="date" name="data_final" value="{{ request('data_final') }}"
                        class="border rounded px-2 py-1">
                </div>
                <div>
                    <label class="block font-semibold text-gray-700">Status</label>
                    <select name="status" class="border rounded px-2 py-1">
                        <option value="">Todos</option>
                        <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                        <option value="confirmado" {{ request('status') == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                        <option value="finalizado" {{ request('status') == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="bg-red-700 text-white px-4 py-2 rounded shadow hover:bg-red-600 transition">
                        Filtrar
                    </button>
                </div>
            </form>

            <!-- Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                @forelse($encomendas as $encomenda)
                    <div id="encomenda-{{ $encomenda->id }}"
                        class="bg-white shadow rounded-lg p-4 flex flex-col justify-between hover:shadow-lg transition relative">

                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <h2 class="text-lg font-bold text-red-700">{{ $encomenda->nome_cliente }}</h2>

                                {{-- Status + Lixeira --}}
                                <div class="flex items-center space-x-2">
                                    <span id="status-{{ $encomenda->id }}"
                                        class="px-3 py-1 text-white text-sm rounded-full flex items-center gap-1
                                            {{ $encomenda->status === 'pendente' ? 'bg-yellow-500' : ($encomenda->status === 'confirmado' ? 'bg-blue-600' : 'bg-green-600') }}">
                                        <i class="fa-solid
                                            {{ $encomenda->status === 'pendente' ? 'fa-hourglass-half' : ($encomenda->status === 'confirmado' ? 'fa-check' : 'fa-check-double') }}">
                                        </i>
                                        {{ ucfirst($encomenda->status) }}
                                    </span>

                                    <button onclick="deletarEncomenda({{ $encomenda->id }})"
                                        class="text-gray-400 hover:text-red-600 transition">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </div>

                            <p class="text-gray-700 font-semibold">Itens:</p>
                            <ul class="text-gray-700 mb-3">
                                @foreach($encomenda->itens as $item)
                                    <li>{{ $item['nome'] }} – {{ $item['quantidade'] }} porções</li>
                                @endforeach
                            </ul>

                            <p class="flex items-center text-gray-500 mb-2">
                                📅 Entrega: {{ \Carbon\Carbon::parse($encomenda->data)->format('d/m/Y') }}
                            </p>
                            <p class="font-bold text-gray-900">R$ {{ number_format($encomenda->valor ?? 0, 2, ',', '.') }}
                            </p>
                        </div>

                        @if($encomenda->status !== 'finalizado')
                            <button onclick="atualizarStatus({{ $encomenda->id }})"
                                class="mt-4 bg-red-700 text-white w-full py-2 rounded shadow hover:bg-red-600 transition">
                                {{ $encomenda->status === 'pendente' ? 'Processar Pedido' : 'Finalizar Pedido' }}
                            </button>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500">Nenhuma encomenda cadastrada.</p>
                @endforelse
            </div>

            <!-- Paginação -->
            <div class="mt-6">
                {{ $encomendas->links('pagination::tailwind') }}
            </div>
        </main>
    </div>

    <script>
        function atualizarStatus(id) {
            const statusSpan = document.getElementById(`status-${id}`);
            const statusAtual = statusSpan.textContent.trim().toLowerCase();

            let novoStatus;
            let confirmText;

            if (statusAtual === 'pendente') {
                novoStatus = 'confirmado';
                confirmText = 'O status será atualizado para confirmado.';
            } else if (statusAtual === 'confirmado') {
                novoStatus = 'finalizado';
                confirmText = 'O status será atualizado para finalizado.';
            } else {
                return; // se já for finalizado, não faz nada
            }

            Swal.fire({
                title: 'Atualizar status?',
                text: confirmText,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim',
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
                        body: JSON.stringify({ status: novoStatus })
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                // Atualiza texto e cor do badge
                                statusSpan.textContent = '';
                                statusSpan.classList.remove('bg-yellow-500', 'bg-blue-600', 'bg-green-600');
                                statusSpan.classList.add(novoStatus === 'pendente' ? 'bg-yellow-500' : (novoStatus === 'confirmado' ? 'bg-blue-600' : 'bg-green-600'));
                                let iconClass = novoStatus === 'pendente' ? 'fa-hourglass-half' : (novoStatus === 'confirmado' ? 'fa-check' : 'fa-check-double');
                                statusSpan.innerHTML = `<i class="fa-solid ${iconClass}"></i> ${novoStatus.charAt(0).toUpperCase() + novoStatus.slice(1)}`;

                                const btn = document.querySelector(`#encomenda-${id} button.mt-4`);
                                if (novoStatus === 'finalizado' && btn) {
                                    btn.remove();
                                } else if (btn) {
                                    btn.textContent = 'Finalizar Pedido';
                                }

                                Swal.fire('Sucesso!', `O pedido foi atualizado para ${novoStatus}.`, 'success');
                            } else {
                                Swal.fire('Erro!', 'Não foi possível atualizar o pedido.', 'error');
                            }
                        })
                        .catch(() => Swal.fire('Erro!', 'Ocorreu um erro.', 'error'));
                }
            });
        }

        function deletarEncomenda(id) {
            Swal.fire({
                title: 'Deletar encomenda?',
                text: "Essa ação não pode ser desfeita!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, deletar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/encomenda/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                const card = document.getElementById(`encomenda-${id}`);
                                if (card) card.remove();
                                Swal.fire('Deletado!', 'A encomenda foi removida.', 'success');
                            } else {
                                Swal.fire('Erro!', 'Não foi possível deletar a encomenda.', 'error');
                            }
                        })
                        .catch(() => Swal.fire('Erro!', 'Ocorreu um erro.', 'error'));
                }
            });
        }
    </script>
</body>

</html>