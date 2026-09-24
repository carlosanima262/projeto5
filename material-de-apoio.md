# Material de apoio — CodeIgniter 3 e PostgreSQL

Isso não é um passo a passo pronto — é só uma orientação dos conceitos que você vai precisar pesquisar e entender para fazer o projeto. Consultar a documentação oficial é parte normal do trabalho, use sem receio:

- Guia oficial do CodeIgniter 3: https://codeigniter.com/userguide3/
- Documentação do PostgreSQL: https://www.postgresql.org/docs/

## Como o CodeIgniter organiza o código (padrão MVC)

O CodeIgniter separa o projeto em três tipos de arquivo, dentro da pasta `application/`:

- **Controllers** (`application/controllers/`): recebem a requisição do navegador e decidem o que fazer. Cada método público de um controller normalmente corresponde a uma URL (ex: um método `index()` na classe `Medicos` atende `seusite.com/medicos`).
- **Models** (`application/models/`): concentram o acesso ao banco de dados (buscar, inserir, atualizar, excluir registros).
- **Views** (`application/views/`): os arquivos HTML/PHP que geram a tela mostrada ao usuário. O controller busca os dados (via model) e "carrega" a view passando esses dados para ela.

Um fluxo típico: usuário acessa uma URL → o Controller correspondente é chamado → ele pede os dados ao Model → ele carrega a View passando esses dados → a View gera o HTML final.

## Conectando o CodeIgniter ao PostgreSQL

A configuração do banco fica em `application/config/database.php`. O CodeIgniter 3 tem suporte nativo a PostgreSQL — procure pelo driver `postgre` (não é `pgsql`, é o nome específico que o CodeIgniter usa) na configuração.

Você também vai precisar garantir que a extensão do PHP para PostgreSQL (`pgsql` ou `pdo_pgsql`) esteja habilitada no seu ambiente.

## Diferenças entre PostgreSQL e MySQL que valem a pena saber

Se você só teve contato com MySQL até agora, alguns pontos mudam no PostgreSQL:

- Para criar uma coluna que numera automaticamente (equivalente ao `AUTO_INCREMENT` do MySQL), o PostgreSQL usa o tipo `SERIAL`.
- Nomes de tabelas e colunas em PostgreSQL são sensíveis a maiúsculas/minúsculas **se você usar aspas duplas** ao criar. O mais simples é sempre criar em letras minúsculas e nunca usar aspas duplas — assim você evita dor de cabeça.
- O PostgreSQL tem um tipo `BOOLEAN` de verdade (não precisa simular com `TINYINT(1)` como às vezes se faz no MySQL).
- Para guardar dados semi-estruturados (como os "dados antes/depois" da tabela de auditoria), o PostgreSQL tem o tipo `JSONB`, que é uma boa opção — você pode gravar um JSON com `json_encode()` no PHP antes de salvar.
- Depois de um `INSERT`, se você quiser recuperar o `id` gerado, o PostgreSQL usa `RETURNING id` na própria query (ou, usando o Query Builder do CodeIgniter, o método `insert_id()` também funciona).

## Sobre a "auditoria de ações"

A ideia é simples: toda vez que um médico for criado, editado ou excluído, um novo registro deve ser gravado numa tabela separada contando o que aconteceu. Pense nela como um "diário de bordo" do sistema — muito comum em sistemas de saúde, onde é importante saber quem alterou o quê e quando (rastreabilidade).

Não existe uma única forma "certa" de implementar isso — pode ser um método no seu Model que você chama manualmente depois de cada operação, por exemplo. O importante é que o registro seja fiel ao que realmente aconteceu.
