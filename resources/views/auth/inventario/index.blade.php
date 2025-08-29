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
        <main class="flex-1 p-10 bg-white overflow-auto">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold text-red-800">Inventário</h1>
                <a href="{{ route('inventario.create') }}"
                class="bg-yellow-400 text-white px-6 py-2 rounded-md font-semibold shadow hover:bg-yellow-500 transition">
                    + Adicionar Item
                </a>
            </div>

            <input type="text" id="search" placeholder="Buscar Ingredientes..."
                class="w-full mb-4 px-4 py-2 border rounded-md">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-b">
                        <th class="text-left p-2">Ingrediente</th>
                        <th class="text-left p-2">Quantidade</th>
                        <th class="text-left p-2">Disponibilidade</th>
                        <th class="text-left p-2">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($itens as $item)
                        <tr class="border-b">
                            <td class="p-2">{{ $item->nome }}</td>
                            <td class="p-2">{{ $item->quantidade }} {{ $item->unidade_saida }}</td>
                            <td class="p-2">
                                @if($item->quantidade == 0)
                                    <span class="text-red-600 font-bold">Sem estoque</span>
                                @elseif($item->quantidade <= $item->quantidade_minima)
                                    <span class="text-yellow-500 font-bold">Abaixo do estoque mínimo</span>
                                @else
                                    <span class="text-green-500">Em estoque</span>
                                @endif
                            </td>
                            <td class="p-2 flex items-center space-x-2">
                                <input type="number" id="quantidade-{{ $item->id }}" value="1" min="1"
                                    class="w-16 px-2 py-1 border rounded">

                                <form action="{{ route('inventario.entrada', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="quantidade" :value="document.getElementById('quantidade-{{ $item->id }}').value">
                                    <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition"
                                            onclick="this.form.quantidade.value = document.getElementById('quantidade-{{ $item->id }}').value">
                                        +
                                    </button>
                                </form>

                                <form action="{{ route('inventario.saida', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="quantidade" :value="document.getElementById('quantidade-{{ $item->id }}').value">
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition"
                                            onclick="this.form.quantidade.value = document.getElementById('quantidade-{{ $item->id }}').value">
                                        −
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $itens->links() }}
            </div>
        </main>
    </div>
</body>
</html>
<script>
    const searchInput = document.getElementById('search');
    const tableRows = document.querySelectorAll('tbody tr');

    searchInput.addEventListener('input', function() {
        const filter = this.value.toLowerCase();

        tableRows.forEach(row => {
            const nome = row.cells[0].textContent.toLowerCase();
            if (nome.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
