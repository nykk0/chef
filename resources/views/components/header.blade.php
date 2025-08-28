<header class="w-full bg-white shadow flex justify-between items-center px-6 py-3 fixed top-0 left-0 z-50">
        <div class="flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6c-2.21 0-4 1.79-4 4v1H7v2h2v5h6v-5h2v-2h-1v-1c0-2.21-1.79-4-4-4z" />
            </svg>
            <span class="text-xl font-bold text-red-600">CHEF</span>
        </div>
        <div class="relative inline-block text-left">
            <!-- Botão principal -->
            <button id="userMenuButton" class="font-semibold text-gray-800 cursor-pointer">
                Olá, {{$user->username}}
            </button>

            <!-- Submenu -->
            <div id="userSubmenu" class="hidden absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-md shadow-lg z-10">
                <a href="" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                    Configurações
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                        Sair
                    </button>
                </form>
            </div>
        </div>
    </header>
    

@push('scripts')
<script>
    const userMenuButton = document.getElementById('userMenuButton');
    const userSubmenu = document.getElementById('userSubmenu');

    if(userMenuButton && userSubmenu){
        userMenuButton.addEventListener('click', () => {
            userSubmenu.classList.toggle('hidden');
        });

        document.addEventListener('click', function(event) {
            if (!userMenuButton.contains(event.target) && !userSubmenu.contains(event.target)) {
                userSubmenu.classList.add('hidden');
            }
        });
    }
</script>
@endpush