<?php 
/** @var array $auditorias */

function renderizar_json_auditoria($dados) {
    if (empty($dados)) {
        return '<span class="text-muted">-</span>';
    }

    if (is_string($dados)) {
        $descodificado = json_decode($dados, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $dados = $descodificado;
        } else {
            return '<pre><code>' . htmlspecialchars($dados) . '</code></pre>';
        }
    }

    $json_formatado = json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    return '<pre><code>' . htmlspecialchars($json_formatado) . '</code></pre>';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Auditoria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        pre {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            padding: 8px;
            border-radius: 4px;
            max-height: 200px;
            overflow-y: auto;
            font-size: 0.8rem;
            margin-bottom: 0;
            white-space: pre-wrap;
            word-break: break-all;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid mt-4 mb-5 px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 mb-0">📋 Histórico de Auditoria</h2>
            <a href="<?= site_url('medicos'); ?>" class="btn btn-secondary">
                Voltar para Listagem
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Médico ID</th>
                                <th>Ação</th>
                                <th>Usuário / Admin</th>
                                <th>Data/Hora</th>
                                <th style="width: 30%;">Dados Antes</th>
                                <th style="width: 30%;">Dados Depois</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($auditorias)): ?>
                                <?php foreach ($auditorias as $auditoria): ?>
                                    <tr>
                                        <td><strong>#<?= isset($auditoria->id) ? $auditoria->id : '-'; ?></strong></td>
                                        <td><code>#<?= isset($auditoria->medico_id) ? $auditoria->medico_id : '-'; ?></code></td>
                                        <td>
                                            <?php 
                                            $acao = isset($auditoria->acao) ? strtoupper($auditoria->acao) : '';
                                            if ($acao === 'INSERT'): ?>
                                                <span class="badge bg-success">INSERÇÃO</span>
                                            <?php elseif ($acao === 'UPDATE'): ?>
                                                <span class="badge bg-warning text-dark">ALTERAÇÃO</span>
                                            <?php elseif ($acao === 'DELETE'): ?>
                                                <span class="badge bg-danger">EXCLUSÃO</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary"><?= $acao; ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($auditoria->usuario_nome)): ?>
                                                <div><strong><?= htmlspecialchars($auditoria->usuario_nome); ?></strong></div>
                                                <small class="text-muted">ID: <?= $auditoria->usuario_id; ?> | <?= htmlspecialchars($auditoria->usuario_email); ?></small>
                                            <?php else: ?>
                                                <span class="text-muted"><em>Sistema / Antigo</em></span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= isset($auditoria->data_hora) ? date('d/m/Y H:i:s', strtotime($auditoria->data_hora)) : '-'; ?></td>
                                        <td>
                                            <?= renderizar_json_auditoria(isset($auditoria->dados_antes) ? $auditoria->dados_antes : null); ?>
                                        </td>
                                        <td>
                                            <?= renderizar_json_auditoria(isset($auditoria->dados_depois) ? $auditoria->dados_depois : null); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Nenhum registro de auditoria encontrado.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>