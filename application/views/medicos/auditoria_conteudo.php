<?php
function renderizar_json_auditoria_modal($dados) {
	if (empty($dados)) {
		return '<span class="text-muted">-</span>';
	}

	if (is_string($dados)) {
		$descodificado = json_decode($dados, true);
		if (json_last_error() === JSON_ERROR_NONE) {
			$dados = $descodificado;
		} else {
			return '<pre><code>' . htmlspecialchars($dados, ENT_QUOTES, 'UTF-8') . '</code></pre>';
		}
	}

	$json_formatado = json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	return '<pre><code>' . htmlspecialchars($json_formatado, ENT_QUOTES, 'UTF-8') . '</code></pre>';
}
?>
<style>
	#modalAuditoria pre {
		max-height: 200px;
		overflow-y: auto;
		white-space: pre-wrap;
		word-break: break-word;
		margin-bottom: 0;
	}
</style>
<div class="table-responsive">
	<table class="table table-striped table-hover align-middle mb-0">
		<thead class="table-dark">
			<tr>
				<th>ID</th>
				<th>Médico ID</th>
				<th>Ação</th>
				<th>Usuário / Admin</th>
				<th>Data/Hora</th>
				<th>Dados Antes</th>
				<th>Dados Depois</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!empty($auditorias)): ?>
				<?php foreach ($auditorias as $auditoria): ?>
					<?php $acao = isset($auditoria->acao) ? strtoupper($auditoria->acao) : ''; ?>
					<tr>
						<td><strong>#<?= isset($auditoria->id) ? (int) $auditoria->id : '-'; ?></strong></td>
						<td><code>#<?= isset($auditoria->medico_id) ? (int) $auditoria->medico_id : '-'; ?></code></td>
						<td>
							<?php if ($acao === 'INSERT'): ?>
								<span class="badge bg-success">INSERÇÃO</span>
							<?php elseif ($acao === 'UPDATE'): ?>
								<span class="badge bg-warning text-dark">ALTERAÇÃO</span>
							<?php elseif ($acao === 'DELETE'): ?>
								<span class="badge bg-danger">EXCLUSÃO</span>
							<?php else: ?>
								<span class="badge bg-secondary"><?= htmlspecialchars($acao, ENT_QUOTES, 'UTF-8'); ?></span>
							<?php endif; ?>
						</td>
						<td>
							<?php if (!empty($auditoria->usuario_nome)): ?>
								<div><strong><?= htmlspecialchars($auditoria->usuario_nome, ENT_QUOTES, 'UTF-8'); ?></strong></div>
								<small class="text-muted">ID: <?= isset($auditoria->usuario_id) ? (int) $auditoria->usuario_id : '-'; ?> | <?= htmlspecialchars(isset($auditoria->usuario_email) ? $auditoria->usuario_email : '', ENT_QUOTES, 'UTF-8'); ?></small>
							<?php else: ?>
								<span class="text-muted"><em>Sistema / Antigo</em></span>
							<?php endif; ?>
						</td>
						<td><?= isset($auditoria->data_hora) ? htmlspecialchars(date('d/m/Y H:i:s', strtotime($auditoria->data_hora)), ENT_QUOTES, 'UTF-8') : '-'; ?></td>
						<td><?= renderizar_json_auditoria_modal(isset($auditoria->dados_antes) ? $auditoria->dados_antes : null); ?></td>
						<td><?= renderizar_json_auditoria_modal(isset($auditoria->dados_depois) ? $auditoria->dados_depois : null); ?></td>
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
