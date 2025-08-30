<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CHEF</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="font-sans bg-white">

<x-header></x-header>
<div class="flex pt-10 min-h-screen lg:ml-64">
    <main class="flex-1 p-10 bg-gray-100 overflow-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-red-800">Calendário de Entregas</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Calendário -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <button id="prev" class="px-3 py-1 bg-red-700 text-white rounded hover:bg-red-800">&lt;</button>
                    <h2 id="monthYear" class="text-xl font-bold text-red-800"></h2>
                    <button id="next" class="px-3 py-1 bg-red-700 text-white rounded hover:bg-red-800">&gt;</button>
                </div>
                <div class="grid grid-cols-7 gap-2 text-center font-semibold text-gray-600">
                    <div>Dom</div><div>Seg</div><div>Ter</div><div>Qua</div><div>Qui</div><div>Sex</div><div>Sáb</div>
                </div>
                <div id="days" class="grid grid-cols-7 gap-2 mt-2 text-center"></div>
            </div>

            <!-- Bloco de entregas -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">
                    Entregas para <span id="deliveryDate">--/--/----</span>
                </h2>
                <div id="entregas"></div>
            </div>
        </div>
    </main>
</div>

<script>
const daysContainer = document.getElementById("days");
const monthYear = document.getElementById("monthYear");
const prevBtn = document.getElementById("prev");
const nextBtn = document.getElementById("next");

let date = new Date();
let diasComEntrega = [];

// Busca dias do mês que têm entregas
async function fetchDiasComEntrega(mes, ano) {
    const response = await fetch("{{ route('calendario.diasComEntrega') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ mes, ano })
    });

    diasComEntrega = await response.json();
}

// Renderiza o calendário
async function renderCalendar() {
    const year = date.getFullYear();
    const month = date.getMonth();

    await fetchDiasComEntrega(month + 1, year);

    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);

    const monthNames = [
        "Janeiro","Fevereiro","Março","Abril","Maio","Junho",
        "Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"
    ];

    monthYear.textContent = `${monthNames[month]} ${year}`;
    daysContainer.innerHTML = "";

    for (let i = 0; i < firstDay.getDay(); i++) daysContainer.innerHTML += `<div></div>`;

    for (let i = 1; i <= lastDay.getDate(); i++) {
        const today = new Date();
        const isToday = i === today.getDate() && month === today.getMonth() && year === today.getFullYear();
        const hasEntrega = diasComEntrega.includes(i);

        let classes = "p-2 rounded cursor-pointer hover:bg-yellow-300 bg-gray-100";
        if (isToday) classes = "p-2 rounded cursor-pointer bg-yellow-400 text-white font-bold";
        if (hasEntrega) classes = "p-2 rounded cursor-pointer bg-red-400 text-white font-bold";

        daysContainer.innerHTML += `
            <div class="${classes}" data-dia="${i}" data-mes="${month + 1}" data-ano="${year}">
                ${i}
            </div>
        `;
    }
}

// Navegação do calendário
prevBtn.addEventListener("click", async () => { date.setMonth(date.getMonth() - 1); await renderCalendar(); });
nextBtn.addEventListener("click", async () => { date.setMonth(date.getMonth() + 1); await renderCalendar(); });

// Clique no dia
daysContainer.addEventListener('click', async (e) => {
    const target = e.target.closest('div[data-dia]');
    if (!target) return;

    const dia = target.dataset.dia;
    const mes = target.dataset.mes;
    const ano = target.dataset.ano;

    document.getElementById('deliveryDate').textContent = `${dia}/${mes}/${ano}`;

    const response = await fetch("{{ route('calendario.entregas') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ dia, mes, ano })
    });

    const entregas = await response.json();
    const deliveriesContainer = document.getElementById('entregas');
    deliveriesContainer.innerHTML = '';
    entregas.forEach(entrega => {
        // monta a lista de itens com nome e quantidade
        const itensHtml = entrega.itens.map(item => {
            return `${item.nome} (${item.quantidade})`;
        }).join('<br>');

        deliveriesContainer.innerHTML += `
            <div class="border rounded-lg p-4 mb-4 border-red-300 flex justify-between items-start">
                <div>
                    <h3 class="font-semibold text-red-800">${entrega.nome_cliente}</h3>
                    <p class="text-gray-600 text-sm">${itensHtml}</p>
                </div>
                <div class="text-black font-bold text-xl">
                    R$ ${entrega.valor}
                </div>
            </div>
        `;
    });
});

renderCalendar();
</script>
</body>
</html>
