<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<header class="w-full bg-white shadow flex justify-between items-center px-6 py-3 fixed top-0 left-0 z-50">
    <div class="flex items-center space-x-2">
        <!-- Botão Hamburguer -->
        <button id="menuToggle" class="text-gray-700 focus:outline-none lg:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Logo -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 6c-2.21 0-4 1.79-4 4v1H7v2h2v5h6v-5h2v-2h-1v-1c0-2.21-1.79-4-4-4z" />
        </svg>
        <span class="text-xl font-bold text-red-600">CHEF</span>
    </div>

    <!-- Menu do usuário -->
    <div class="relative inline-block text-left">
        <button id="userMenuButton" class="font-semibold text-gray-800 cursor-pointer">
            Olá, {{$user->username}}
        </button>
        <div id="userSubmenu"
            class="hidden absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-md shadow-lg z-10">
            <a href={{ route('alter_user') }} class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                Configurações
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                    Sair
                </button>
            </form>
        </div>
    </div>
</header>

<!-- Menu Lateral -->
<aside id="sidebar"
    class="fixed top-0 left-0 w-64 h-full bg-white shadow-md transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-40">
    <div class="mt-16 px-4">
        <nav class="space-y-2">
            <a href="{{route('receita')}}" class="block px-4 py-2 rounded-md text-gray-700 hover:bg-gray-100">Receitas</a>
            <a href="{{route('inventario.index')}}" class="block px-4 py-2 rounded-md text-gray-700 hover:bg-gray-100">Inventário</a>
            <a href="{{ route('encomenda.index') }}" class="block px-4 py-2 rounded-md text-gray-700 hover:bg-gray-100">Encomendas</a>
            <a href="{{ route('calendario.index') }}" class="block px-4 py-2 rounded-md text-gray-700 hover:bg-gray-100">Calendario</a>
        </nav>
    </div>
</aside>


<!-- Overlay escuro quando o menu estiver aberto -->
<div id="overlay"
    class="fixed inset-0 bg-black bg-opacity-50 hidden z-30"></div>

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
