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
            <h1 class="text-2xl font-bold text-red-800 mb-6">Adicionar Item</h1>

            <form action="{{ route('inventario.store') }}" method="POST" class="space-y-4 bg-white p-6 shadow rounded">
                @csrf
                <div>
                    <label class="block font-semibold">Nome</label>
                    <input type="text" name="nome" value="{{ old('nome') }}"
                        class="w-full px-4 py-2 border rounded">
                </div>
                <div>
                    <label class="block font-semibold">Categoria</label>
                    <input type="text" name="categoria" value="{{ old('categoria') }}"
                        class="w-full px-4 py-2 border rounded">
                </div>
                <div>
                    <label class="block font-semibold">Unidade de Compra</label>
                    <select name="unidade_compra" class="w-full px-4 py-2 border rounded">
                        <option value="kg">Kg</option>
                        <option value="g">g</option>
                        <option value="mg">mg</option>
                        <option value="l">L</option>
                        <option value="ml">ml</option>
                    </select>
                </div>

                <div>
                    <label class="block font-semibold">Unidade de Saída</label>
                    <select name="unidade_saida" class="w-full px-4 py-2 border rounded">
                        <option value="kg">Kg</option>
                        <option value="g">g</option>
                        <option value="mg">mg</option>
                        <option value="l">L</option>
                        <option value="ml">ml</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold">Quantidade</label>
                    <input type="number" name="quantidade" value="{{ old('quantidade', 0) }}"
                        class="w-full px-4 py-2 border rounded">
                </div>
                <div>
                    <label class="block font-semibold">Quantidade mínima</label>
                    <input type="number" name="quantidade_minima" value="{{ old('quantidade_minima', 1) }}"
                        class="w-full px-4 py-2 border rounded">
                </div>
                <button type="submit"
                        class="bg-yellow-400 text-white px-6 py-2 rounded shadow hover:bg-yellow-500 transition">
                    Salvar
                </button>
            </form>
        </main>
    </div>
</body>
</html>
