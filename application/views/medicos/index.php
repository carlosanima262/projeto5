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
                <a href="<?= site_url('medicos/auditoria'); ?>" class="btn btn-info text-white">📋 Ver Auditoria</a>
                <a href="<?= site_url('medicos/create'); ?>" class="btn btn-primary">+ Novo Médico</a>
                <!-- Botão de Sair -->
                <a href="<?= site_url('login/logout'); ?>" class="btn btn-outline-danger" onclick="return confirm('Deseja realmente sair do sistema?');">🚪 Sair</a>
            </div>
        </div>

        <!-- Mensagens de Feedback (Flashdata) -->
        <?php if ($this->session->flashdata('sucesso')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $this->session->flashdata('sucesso'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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
                                            <a href="<?= site_url('medicos/edit/' . $medico->id); ?>" class="btn btn-sm btn-warning">Editar</a>
                                            <a href="<?= site_url('medicos/delete/' . $medico->id); ?>" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirm('Tem certeza de que deseja excluir o médico <?= htmlspecialchars($medico->nome); ?>?');">
                                                Excluir
                                            </a>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>