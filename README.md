# <p align="center">CHEF</p>

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
* Cadastro de usuários  
* Edição de usuários  
* Troca de senha  
* Login  
* Logout  

#### *OBS: a senha do usuário é criptografada com o algoritmo BCrypt.*


### INVENTÁRIO
* Cadastro de itens no inventário  
* Exclusão de itens do inventário  
* Busca de itens no inventário  
* Entrada e baixa de itens  
* Conversão de unidade de compra para unidade de saída  

#### * OBS: o inventário contém paginação de itens.<br>  *
Também apresenta alerta caso o item atinja a quantidade mínima no estoque.*


### RECEITAS
* Cadastro de receitas  
* Edição de receitas  
* Exclusão de receitas  
* Exibição de informações por meio de modal  

#### *OBS: as receitas estão vinculadas ao inventário, portanto é necessário cadastrar previamente os itens no inventário!*


### ENCOMENDAS
* Cadastro de encomendas  
* Exclusão de encomendas  
* Filtro de encomendas por status, data inicial e data final  
* Gerenciamento de status  
* Quando o status estiver em andamento, será realizada a baixa automática no inventário  

#### *OBS: para utilizar corretamente a funcionalidade de encomendas, é necessário cadastrar previamente as receitas.*<br>  
*Os valores são importados e calculados a partir dos registros da tela de receitas.  
É possível incluir mais de uma receita em uma mesma encomenda.*


### CALENDÁRIO
#### A tela será utilizada especialmente para o controle das encomendas no dia a dia, listando todos os dias que possuem encomendas registradas, em vermelho, com seus respectivos status e valores.  

*OBS: o calendário mostra a data atual em laranja.*  
