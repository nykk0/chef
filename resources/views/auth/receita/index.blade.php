<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHEF</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="font-sans bg-white">

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
        <main class="flex-1 p-10 bg-white overflow-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-red-800">Receitas</h1>
                <a href="{{route('receita.create')}}"
                   class="bg-yellow-400 text-white px-6 py-2 rounded-md font-semibold shadow hover:bg-yellow-500 transition">
                    + Adicionar Receita
                </a>
            </div>

            <!-- Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                @forelse($receitas as $receita)
                    <div onclick="showReceita({{ $receita->id }})"
                         class="cursor-pointer bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition">
                        <div class="bg-gradient-to-r from-red-600 to-red-400 px-4 py-3">
                            <h2 class="text-lg font-bold text-white">{{ $receita->nome }}</h2>
                        </div>
                        <div class="p-4 text-gray-700">
                            <p><strong>Tempo:</strong> {{ $receita->tempo_preparo }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">Nenhuma receita cadastrada.</p>
                @endforelse
            </div>
        </main>
    </div>

    <!-- Modal (hidden por padrão) -->
    <div id="modalReceita" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full p-6 relative">
            <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-600 hover:text-red-600 text-xl">&times;</button>

            <h2 id="modalNome" class="text-2xl font-bold text-red-700 mb-4"></h2>
            <p><strong>Tempo de Preparo:</strong> <span id="modalTempo"></span></p>
            <div class="mt-4">
                <h3 class="font-semibold mb-2">Ingredientes</h3>
                <ul id="modalIngredientes" class="list-disc list-inside text-gray-700"></ul>
            </div>
            <div class="mt-4">
                <h3 class="font-semibold mb-2">Modo de Preparo</h3>
                <p id="modalModo" class="text-gray-700 whitespace-pre-line"></p>
            </div>
            <div class="flex justify-between items-center mb-4">
                <h2 id="modalNome" class="text-2xl font-bold text-red-700"></h2>
                <div class="flex gap-4 items-center">
                    <a id="editLink" href="#"
                    class="text-blue-600 hover:text-blue-800"
                    title="Editar Receita">
                        ✏️
                    </a>
                    <button onclick="deleteReceita()"
                            class="text-red-600 hover:text-red-800"
                            title="Excluir Receita">
                        🗑️
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const receitas = @json($receitas);
        const inventarios = @json(\App\Models\Inventario::pluck('nome','id'));

        let receitaSelecionada = null;

        function showReceita(id) {
            const receita = receitas.find(r => r.id === id);
            if (!receita) return;

            receitaSelecionada = receita;

            document.getElementById('modalNome').textContent = receita.nome;
            document.getElementById('modalTempo').textContent = receita.tempo_preparo;
            document.getElementById('modalModo').textContent = receita.modo_preparo;
            document.getElementById('editLink').href = `/receita/${id}/edit`;

            const ingredientesIds = receita.ingredientes_ids.split(',');
            const ingredientesQtds = receita.ingredientes_qtds.split(',');

            const ul = document.getElementById('modalIngredientes');
            ul.innerHTML = '';

            ingredientesIds.forEach((id, index) => {
                const nome = inventarios[id] ?? 'Desconhecido';
                const qtd = ingredientesQtds[index] ?? '-';
                const li = document.createElement('li');
                li.textContent = `${nome} - ${qtd}`;
                ul.appendChild(li);
            });

            document.getElementById('modalReceita').classList.remove('hidden');
            document.getElementById('modalReceita').classList.add('flex');
        }

        function deleteReceita() {
            if (!receitaSelecionada) return;

            Swal.fire({
                title: "Tem certeza?",
                text: `A receita "${receitaSelecionada.nome}" será excluída permanentemente.`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sim, excluir!",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/receita/${receitaSelecionada.id}`, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json"
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            Swal.fire("Excluída!", "A receita foi removida com sucesso.", "success");
                            closeModal();
                            setTimeout(() => location.reload(), 1200);
                        } else {
                            Swal.fire("Erro!", "Não foi possível excluir a receita.", "error");
                        }
                    })
                    .catch(() => {
                        Swal.fire("Erro!", "Ocorreu um problema na exclusão.", "error");
                    });
                }
            });
        }


        function closeModal() {
            document.getElementById('modalReceita').classList.add('hidden');
            document.getElementById('modalReceita').classList.remove('flex');
        }
    </script>

</body>
</html>
