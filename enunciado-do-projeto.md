# Projeto prático — Cadastro de Médicos

Segunda etapa do processo. Dessa vez o projeto usa o mesmo tipo de stack que a Gees Healthtech usa em produção: **PHP 5.6 + CodeIgniter 3 + PostgreSQL**, com HTML, CSS e JavaScript. Se é a sua primeira vez com um framework PHP ou com PostgreSQL, isso é esperado — dá uma olhada no arquivo `material-de-apoio.md` antes de começar, ele explica os conceitos básicos que você vai precisar.

## O que você vai construir

Um sistema simples de **cadastro de médicos**, com:

1. Uma tela de **listagem** (tabela com todos os médicos cadastrados).
2. Uma tela de **formulário**, separada da listagem, para cadastrar e editar médicos.
3. **Exclusão** de um médico.
4. Uma tela de **auditoria**, mostrando o histórico de todas as ações (quem criou, editou ou excluiu, quando, e o que mudou).

Não precisa terminar 100% das etapas para ter uma boa avaliação — preferimos ver etapas iniciais bem feitas e funcionando do que tudo pela metade. Se não der tempo de terminar algo, escreva no seu README o que faltou e por quê — isso também é avaliado.

## Cadastro de médicos — campos

| Campo | Observação |
|---|---|
| Nome completo | obrigatório |
| CRM | obrigatório, deve ser único (não pode repetir) |
| Especialidade | obrigatório |
| Telefone | opcional |
| E-mail | opcional, mas se for preenchido precisa ter formato válido |
| Situação | ativo / inativo |
| Data de cadastro | preenchida automaticamente pelo sistema |

## Etapas

### Etapa 0 — Ambiente

Configure um projeto CodeIgniter 3 do zero, conectado a um banco PostgreSQL.

**Pronto quando:** você consegue acessar a página inicial do CodeIgniter no navegador, e tem certeza de que a aplicação consegue se conectar ao banco (por exemplo, rodando uma query simples de teste).

### Etapa 1 — Modelagem do banco

Crie as tabelas no PostgreSQL (via SQL direto ou migrations do CodeIgniter, como preferir):

- `medicos` — com os campos da tabela acima.
- Uma tabela de **auditoria** (pode chamar como quiser, ex: `auditoria_medicos`), guardando pelo menos: qual ação foi feita (criar/editar/excluir), em qual médico, quando, e os dados antes e depois da mudança (uma coluna do tipo `jsonb` é uma boa forma de guardar isso).

**Pronto quando:** as duas tabelas existem no banco e você consegue inserir e consultar dados manualmente para testar.

### Etapa 2 — Listagem

Tela principal do sistema: uma tabela HTML com todos os médicos cadastrados (nome, CRM, especialidade, telefone, situação, e uma coluna de ações com links/botões para editar e excluir). Deve ter um botão ou link visível para "Novo médico", que leva à tela de formulário.

**Bônus (opcional):** campo de busca por nome ou CRM; paginação se a lista crescer.

### Etapa 3 — Formulário (em tela separada)

Uma tela própria — separada da listagem — para cadastrar um médico novo e para editar um médico existente (pode ser a mesma tela reaproveitada para os dois casos, ou duas telas, como preferir).

- Valide os campos obrigatórios **no servidor** (não só no navegador) — o CodeIgniter tem uma biblioteca própria de validação de formulários, vale a pena pesquisar sobre ela.
- Mostre mensagens claras de erro (ex: "CRM já cadastrado") e de sucesso.
- Toda vez que um médico for criado ou editado, grave um registro correspondente na tabela de auditoria.

### Etapa 4 — Exclusão

Um jeito de excluir um médico a partir da tela de listagem, com uma confirmação em JavaScript antes de excluir de fato (evitar clique acidental).

A exclusão também deve gerar um registro de auditoria. Pense se faz sentido apagar o registro do banco de vez, ou só marcar como inativo (isso é uma decisão comum em sistemas da área de saúde, onde geralmente não se quer perder histórico de nada) — qualquer uma das duas abordagens é aceita, mas explique no README qual você escolheu e por quê.

### Etapa 5 — Tela de auditoria

Uma tela que mostra o histórico de ações registrado na Etapa 1/3/4: o que foi feito, em qual médico, quando, e os dados antes/depois da mudança.

### Etapa 6 — Acabamento (bônus, só se sobrar tempo)

- Um CSS simples e organizado (pode usar alguma biblioteca via CDN, como Bootstrap, ou escrever o seu).
- JavaScript adicional: máscara no campo de telefone, validação de campos antes de enviar o formulário, feedback visual (mensagens de sucesso/erro mais elaboradas que um `alert()`).

## Como entregar

Ao final, entregue a pasta completa do projeto (sem a pasta `vendor`, se usar Composer) e um `README.md` curto contando:

- O que você conseguiu terminar.
- O que não deu tempo de fazer, e por quê.
- Alguma decisão que você tomou e acha importante explicar (ex: exclusão lógica x física).

Boa sorte.
