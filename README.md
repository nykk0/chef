# <p align="center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-600 lucide lucide-chef-hat h-8 w-8 text-primary" data-lov-id="src/components/NavBar.tsx:21:14" data-lov-name="ChefHat" data-component-path="src/components/NavBar.tsx" data-component-line="21" data-component-file="NavBar.tsx" data-component-name="ChefHat" data-component-content="%7B%22className%22%3A%22h-8%20w-8%20text-primary%22%7D"><path d="M17 21a1 1 0 0 0 1-1v-5.35c0-.457.316-.844.727-1.041a4 4 0 0 0-2.134-7.589 5 5 0 0 0-9.186 0 4 4 0 0 0-2.134 7.588c.411.198.727.585.727 1.041V20a1 1 0 0 0 1 1Z"></path><path d="M6 17h12"></path></svg> CHEF</p>

### Participantes
* #### Nome do aluno 1 - Matrícula: 000000000  
* #### Nome do aluno 2 - Matrícula: 000000000  
* #### Nome do aluno 3 - Matrícula: 000000000  
* #### Nome do aluno 5 - Matrícula: 000000000  
* #### Nome do aluno 6 - Matrícula: 000000000  

## INSTRUÇÕES DE COMO EXECUTAR O PROJETO

* Necessário ter o PHP 8.0^
* Baixar o Wamp, Xamp ou ter o Mysql server instalado
* Baixar o composer para o PHP 8.0^

### Comandos
Para ter o projeto na maquina é necessário acessar a pasta onde deseja ter o projeto e rodar: <br>
 `git clone https://github.com/nykk0/chef.git`

Logo após, acessar a pasta ` cd .\chef\`
E executar o comando `composer update`

com isso feito iremos configurar o nosso ambiente com o aquivo pré montado "*.env.example*". Iremos copia-lo e gerar o *.env* com o comando `copy .env.example .env`.

Também é necessario gerar a chave da aplicação para que possamos executa-la.
`php artisan key:generate`

#### *Para a proxima etapa é necessario ter certeza de que o Wamp, Xamp ou Mysql Server esteja sendo executado corretamente*

Após configurarmos o nosso ambiente e instalar as dependencias necessarias,iremos gerar o nosso banco de dados com o comando `php artisan migrate`

Agora iremos executar a nossa aplicação com o comando `php artisan serve`.

ele irá mostrar o link de onde sua aplicação estará rodando.Sendo o mais comum: [http://127.0.0.1:8000].

#### *DICA: é possivel acessar tambem clicando com CRTL + botão direito do mouse em cima do link que aparece no CMD*
<br>
<br>


# FUNCIONALIDADES

### USUÁRIOS 
* Cadastro de usuários  -> RegisterController -> register();
* Edição de usuários  -> RegisterController -> updateUser();
* Troca de senha  -> RegisterController -> updateUser();
* Login  -> RegisterController -> login();
* Logout  -> RegisterController -> logout();

#### *OBS: a senha do usuário é criptografada com o algoritmo BCrypt. (Tudo gerenciavel no menu de configurações)*


### INVENTÁRIO
* Cadastro de itens no inventário  -> InventarioController -> store();
* Exclusão de itens do inventário  -> InventarioController -> destroy();
* Busca de itens no inventário  -> InventarioController -> 
* Entrada e baixa de itens   -> InventarioController -> saida() e entrada();
* Conversão de unidade de compra para unidade de saída  -> store();

#### * OBS: o inventário contém paginação de itens.<br>  *
Também apresenta alerta caso o item atinja a quantidade mínima no estoque.*


### RECEITAS
* Cadastro de receitas  -> ReceitaController -> store();
* Edição de receitas  -> ReceitaController -> update();
* Exclusão de receitas  -> ReceitaController -> destroy();
* Exibição de informações por meio de modal

#### *OBS: as receitas estão vinculadas ao inventário, portanto é necessário cadastrar previamente os itens no inventário!*


### ENCOMENDAS
* Cadastro de encomendas  -> EncomendaController -> store();
* Exclusão de encomendas  ->EncomendaController -> destroy();
* Filtro de encomendas por status, data inicial e data final  -> EncomendaService -> listarComFiltros();
* Gerenciamento de status -> EncomendaController -> processar(); 
 

#### *OBS: para utilizar corretamente a funcionalidade de encomendas, é necessário cadastrar previamente as receitas.*
*Quando o status estiver em andamento, será realizada a baixa automática no inventário*<br>  
*Os valores são importados e calculados a partir dos registros da tela de receitas.*
*É possível incluir mais de uma receita em uma mesma encomenda.*


### CALENDÁRIO
#### A tela será utilizada especialmente para o controle das encomendas no dia a dia, listando todos os dias que possuem encomendas registradas, em vermelho, com seus respectivos status e valores. 
#### As funções de calendario podem ser encontradas em CalendarioController.

*OBS: o calendário mostra a data atual em laranja.*  
