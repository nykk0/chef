<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHEF</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const links = document.querySelectorAll("a[href^='#']");
            links.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute("href"));
                    window.scrollTo({
                        top: target.offsetTop - 70,
                        behavior: "smooth"
                    });
                });
            });
        });
    </script>
</head>
<body class="font-sans bg-gray-50">

    <!-- Navbar -->
    <header class="bg-white text-gray-800 shadow-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
            <div class="flex items-center space-x-2">
                <span class="font-extrabold text-xl text-red-600">LOGO</span>
                <span class="font-semibold text-xl text-red-600">CHEF</span>
            </div>
            <nav class="hidden md:flex space-x-6 text-lg font-medium">
                <a href="#inicio" class="hover:text-red-600">Início</a>
                <a href="#recursos" class="hover:text-red-600">Recursos</a>
                <a href="#precos" class="hover:text-red-600">Preços</a>
                <a href="#sobre" class="hover:text-red-600">Sobre</a>
                <a href="#contato" class="hover:text-red-600">Contato</a>
            </nav>
            <div class="flex items-center space-x-3">
                <a a href="{{ route('login') }}" class="border border-gray-800 px-4 py-2 rounded-md hover:bg-gray-800 hover:text-white transition ">Entrar</a>
                <a href="{{ route('register') }}" class="bg-yellow-400 text-white px-6 py-2 rounded-md hover:bg-yellow-300 transition">Cadastre-se</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="inicio" class="bg-gradient-to-r from-red-500 to-red-400 text-center py-24">
        <h1 class="text-5xl font-bold text-white">
            Potencialize Seu Negócio Culinário com CHEF
        </h1>
        <p class="mt-4 text-gray-100 text-lg max-w-2xl mx-auto">
            A plataforma completa para empreendedores culinários gerenciarem receitas, pedidos e estoque com facilidade.
        </p>
        <a href="#inicio" class="mt-6 inline-block bg-yellow-400 text-white px-8 py-3 rounded-md shadow-lg hover:bg-yellow-300 transition">
            Comece Gratuitamente
        </a>
    </section>

    <!-- Features -->
    <section id="recursos" class="bg-gray-200 py-16">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-semibold text-center text-red-700 mb-12">Tudo que Você Precisa para Crescer</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition">
                    <h3 class="text-xl font-semibold text-red-700 mb-2">Gestão de receitas</h3>
                    <p class="text-gray-700 text-sm">
                        Armazene, dimensione e compartilhe suas receitas facilmente. Mantenha suas criações culinárias organizadas e acessíveis.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition">
                    <h3 class="text-xl font-semibold text-red-700 mb-2">Agendamento de Pedidos</h3>
                    <p class="text-gray-700 text-sm">
                        Gerencie entregas e pedidos com eficiência. Nunca mais perca um prazo ou faça agendamentos duplicados.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition">
                    <h3 class="text-xl font-semibold text-red-700 mb-2">Estoque Inteligente</h3>
                    <p class="text-gray-700 text-sm">
                        Acompanhe ingredientes e suprimentos em tempo real. Alertas automáticos quando o estoque estiver baixo.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition">
                    <h3 class="text-xl font-semibold text-red-700 mb-2">Ferramentas Profissionais</h3>
                    <p class="text-gray-700 text-sm">
                        Acesse ferramentas de nível profissional desenvolvidas especificamente para negócios culinários.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Por que escolher -->
    <section id="precos" class="bg-red-600 text-white py-16 text-center">
        <h2 class="text-3xl font-bold mb-12">Por Que Escolher o CHEF?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-6xl mx-auto">
            <div>
                <div class="text-4xl mb-3">⭐</div>
                <h3 class="font-semibold text-lg mb-2">Qualidade Garantida</h3>
                <p class="text-gray-200 text-sm">
                    Controle preciso de ingredientes e processos para resultados consistentes.
                </p>
            </div>
            <div>
                <div class="text-4xl mb-3">👥</div>
                <h3 class="font-semibold text-lg mb-2">Comunidade Ativa</h3>
                <p class="text-gray-200 text-sm">
                    Compartilhe experiências e aprenda com outros profissionais.
                </p>
            </div>
            <div>
                <div class="text-4xl mb-3">📈</div>
                <h3 class="font-semibold text-lg mb-2">Crescimento Comprovado</h3>
                <p class="text-gray-200 text-sm">
                    Aumente sua produtividade e expanda seu negócio.
                </p>
            </div>
        </div>
    </section>

    <!-- Depoimentos -->
    <section id="sobre" class="bg-white py-16 text-center">
        <h2 class="text-3xl font-semibold text-red-700 mb-6">O Que Dizem Nossos Clientes</h2>
        <blockquote class="text-lg italic text-gray-700 max-w-2xl mx-auto">
            "O CHEF revolucionou meu negócio de confeitaria. A organização das receitas é perfeita!"
        </blockquote>
        <p class="mt-6 font-bold text-red-700">Maria Silva</p>
        <p class="text-gray-600">Confeiteira</p>
    </section>

    <!-- Call to action -->
    <section id="contato" class="bg-gradient-to-r from-red-500 to-red-400 py-16 text-center">
        <h2 class="text-3xl font-bold text-white">Pronto para Transformar Seu Negócio?</h2>
        <p class="mt-4 text-gray-100 max-w-2xl mx-auto">
            Junte-se a milhares de empreendedores culinários de sucesso que confiam no CHEF.
        </p>
        <a href="#contato" class="mt-6 inline-block bg-yellow-400 text-white px-8 py-3 rounded-md shadow-lg hover:bg-yellow-300 transition">
            Começar Agora
        </a>
    </section>

    <!-- Footer -->
    <footer class="bg-red-600 text-white pt-12 pb-6">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-10">
            <div>
                <span class="font-bold text-2xl">LOGO</span>
                <span class="font-bold text-2xl text-yellow-400"> CHEF</span>
            </div>
            <div>
                <h3 class="font-semibold mb-3">Institucional</h3>
                <ul class="space-y-2">
                    <li><a href="#sobre" class="hover:underline">Sobre</a></li>
                    <li><a href="#depoimentos" class="hover:underline">Depoimentos</a></li>
                    <li><a href="#contato" class="hover:underline">Contato</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-semibold mb-3">Ferramentas</h3>
                <ul class="space-y-2">
                    <li><a href="#recursos" class="hover:underline">Funcionalidades</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-semibold mb-3">Fale com a gente</h3>
                <ul class="space-y-2">
                    <li>+55 (31) xxxx-xxxx</li>
                    <li><a href="mailto:chefereceitas@gmail.com" class="hover:underline">chefereceitas@gmail.com</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-10 pt-4 text-center text-sm text-gray-300">
            &copy; 2025 - CHEF - Todos os direitos reservados
        </div>
    </footer>

</body>
</html>
