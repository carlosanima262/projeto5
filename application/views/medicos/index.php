<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Médicos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-4 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>👨‍⚕️ Cadastro de Médicos</h2>
            <div>
                <button type="button" class="btn btn-success btn-lg mt-2" data-url="<?= site_url('medicos/auditoria_conteudo'); ?>" data-bs-toggle="modal" data-bs-target="#modalAuditoria">Ver Auditoria</button>
                <button type="button" class="btn btn-primary" data-form-url="<?= site_url('medicos/create'); ?>" data-modal-title="Cadastrar Médico" data-bs-toggle="modal" data-bs-target="#modalMedico">+ Novo Médico</button>
                <!-- Botão de Sair -->
                <a href="<?= site_url('login/logout'); ?>" class="btn btn-outline-danger" onclick="return confirm('Deseja realmente sair do sistema?');">🚪 Sair</a>
            </div>
        </div>

        <!-- Mensagens de Feedback (Flashdata) -->
        <?php if ($this->session->flashdata('sucesso')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $this->session->flashdata('sucesso'); ?>
            </div>
        <?php endif; ?>

        <!-- Campo de Busca -->
        <form method="GET" action="<?= site_url('medicos'); ?>" class="row g-2 mb-3">
            <div class="col-auto">
                <input type="text" name="busca" class="form-control" placeholder="Buscar por nome ou CRM..." value="<?= htmlspecialchars(isset($busca) ? $busca : ''); ?>">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-secondary">Pesquisar</button>
                <?php if (!empty($busca)): ?>
                    <a href="<?= site_url('medicos'); ?>" class="btn btn-outline-secondary">Limpar</a>
                <?php endif; ?>
            </div>
        </form>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Nome</th>
                                <th>CRM</th>
                                <th>Especialidade</th>
                                <th>Telefone</th>
                                <th>Situação</th>
                                <th>Data Cadastro</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($medicos)): ?>
                                <?php foreach ($medicos as $medico): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($medico->nome); ?></strong></td>
                                        <td><code><?= htmlspecialchars($medico->crm); ?></code></td>
                                        <td><?= htmlspecialchars($medico->especialidade); ?></td>
                                        <td><?= !empty($medico->telefone) ? htmlspecialchars($medico->telefone) : '-'; ?></td>
                                        <td>
                                            <?php 
                                            $situacao = isset($medico->situacao) ? $medico->situacao : 'ativo';
                                            if ($situacao === 'ativo'): 
                                            ?>
                                                <span class="badge bg-success">Ativo</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Inativo</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= !empty($medico->data_cadastro) ? date('d/m/Y H:i', strtotime($medico->data_cadastro)) : '-'; ?></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-warning" data-form-url="<?= site_url('medicos/edit/' . $medico->id); ?>" data-modal-title="Editar Médico #<?= (int) $medico->id; ?>" data-bs-toggle="modal" data-bs-target="#modalMedico">Editar</button>
                                            <button type="button" class="btn btn-sm btn-danger" data-delete-url="<?= site_url('medicos/delete/' . $medico->id); ?>" data-medico-nome="<?= htmlspecialchars($medico->nome, ENT_QUOTES, 'UTF-8'); ?>" data-bs-toggle="modal" data-bs-target="#modalExcluirMedico">
                                                Excluir
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Nenhum médico encontrado.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalAuditoria" tabindex="-1" aria-labelledby="tituloAuditoria" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloAuditoria">Histórico de Auditoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body" id="conteudoAuditoria">
                    <p class="text-muted mb-0">A auditoria será carregada ao abrir.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalMedico" tabindex="-1" aria-labelledby="tituloModalMedico" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModalMedico">Médico</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body" id="conteudoModalMedico">
                    <p class="text-muted mb-0">Carregando formulário...</p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalExcluirMedico" tabindex="-1" aria-labelledby="tituloExcluirMedico" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloExcluirMedico">Excluir médico</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza de que deseja excluir <strong id="nomeMedicoExclusao"></strong>?</p>
                    <div class="alert alert-danger d-none mb-0" id="erroExclusaoMedico" role="alert"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmarExclusaoMedico">Excluir</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var cabecalhosAjax = { 'X-Requested-With': 'XMLHttpRequest' };

        document.getElementById('modalAuditoria').addEventListener('show.bs.modal', function () {
            var conteudo = document.getElementById('conteudoAuditoria');
            var url = document.querySelector('[data-bs-target="#modalAuditoria"]').getAttribute('data-url');

            conteudo.textContent = 'Carregando auditoria...';

            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(function (resposta) {
                    if (!resposta.ok) {
                        throw new Error('Falha ao carregar auditoria.');
                    }
                    return resposta.text();
                })
                .then(function (html) {
                    conteudo.innerHTML = html;
                })
                .catch(function () {
                    conteudo.textContent = 'Não foi possível carregar a auditoria. Tente novamente.';
                });
        });

        var modalMedico = document.getElementById('modalMedico');
        var conteudoModalMedico = document.getElementById('conteudoModalMedico');

        modalMedico.addEventListener('show.bs.modal', function (evento) {
            var acionador = evento.relatedTarget;
            var url = acionador.getAttribute('data-form-url');
            document.getElementById('tituloModalMedico').textContent = acionador.getAttribute('data-modal-title');
            conteudoModalMedico.textContent = 'Carregando formulário...';

            fetch(url, { headers: cabecalhosAjax })
                .then(function (resposta) {
                    if (!resposta.ok) {
                        throw new Error('Falha ao carregar o formulário.');
                    }
                    return resposta.text();
                })
                .then(function (html) {
                    conteudoModalMedico.innerHTML = html;
                })
                .catch(function () {
                    conteudoModalMedico.textContent = 'Não foi possível carregar o formulário. Tente novamente.';
                });
        });

        conteudoModalMedico.addEventListener('submit', function (evento) {
            var formulario = evento.target;
            if (!formulario.matches('form.js-medico-form')) {
                return;
            }
            evento.preventDefault();

            fetch(formulario.action, {
                method: formulario.method.toUpperCase(),
                body: new FormData(formulario),
                headers: cabecalhosAjax
            })
                .then(function (resposta) {
                    if (!resposta.ok) {
                        throw new Error('Falha ao salvar o médico.');
                    }
                    var tipo = resposta.headers.get('content-type') || '';
                    if (tipo.indexOf('application/json') !== -1) {
                        return resposta.json().then(function (resultado) {
                            if (!resultado.success) {
                                throw new Error('Falha ao salvar o médico.');
                            }
                            bootstrap.Modal.getOrCreateInstance(modalMedico).hide();
                            window.location.reload();
                        });
                    }
                    return resposta.text().then(function (html) {
                        conteudoModalMedico.innerHTML = html;
                    });
                })
                .catch(function () {
                    conteudoModalMedico.insertAdjacentHTML('afterbegin', '<div class="alert alert-danger" role="alert">Não foi possível salvar. Verifique os dados e tente novamente.</div>');
                });
        });

        var modalExcluirMedico = document.getElementById('modalExcluirMedico');
        var urlExclusaoMedico = '';
        modalExcluirMedico.addEventListener('show.bs.modal', function (evento) {
            var acionador = evento.relatedTarget;
            urlExclusaoMedico = acionador.getAttribute('data-delete-url');
            document.getElementById('nomeMedicoExclusao').textContent = acionador.getAttribute('data-medico-nome');
            var erro = document.getElementById('erroExclusaoMedico');
            erro.textContent = '';
            erro.classList.add('d-none');
        });

        document.getElementById('confirmarExclusaoMedico').addEventListener('click', function () {
            var botao = this;
            botao.disabled = true;
            fetch(urlExclusaoMedico, { method: 'POST', headers: cabecalhosAjax })
                .then(function (resposta) {
                    if (!resposta.ok) {
                        throw new Error('Falha ao excluir o médico.');
                    }
                    return resposta.json();
                })
                .then(function (resultado) {
                    if (!resultado.success) {
                        throw new Error('Falha ao excluir o médico.');
                    }
                    bootstrap.Modal.getOrCreateInstance(modalExcluirMedico).hide();
                    window.location.reload();
                })
                .catch(function () {
                    var erro = document.getElementById('erroExclusaoMedico');
                    erro.textContent = 'Não foi possível excluir o médico. Tente novamente.';
                    erro.classList.remove('d-none');
                    botao.disabled = false;
                });
        });
    </script>
</body>
</html>