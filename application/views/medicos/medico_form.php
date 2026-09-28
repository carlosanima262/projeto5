<?php
$editando = isset($medico) && !empty($medico);
$situacao_atual = $editando && isset($medico->situacao) ? $medico->situacao : 'ativo';
$cpf_atual = $editando && isset($medico->cpf) ? $medico->cpf : '';
$telefone_atual = $editando && isset($medico->telefone) ? $medico->telefone : '';
$email_atual = $editando && isset($medico->email) ? $medico->email : '';
$acao_formulario = $editando ? 'medicos/update/' . $medico->id : 'medicos/store';
$in_modal = isset($in_modal) && $in_modal;
?>
<?php if (validation_errors()): ?>
    <div class="alert alert-danger" role="alert">
        <?= validation_errors(); ?>
    </div>
<?php endif; ?>

<?= form_open($acao_formulario, array('class' => 'js-medico-form')); ?>
    <div class="mb-3">
        <label for="nome" class="form-label">Nome Completo</label>
        <input type="text" name="nome" id="nome" class="form-control"
            value="<?= html_escape(set_value('nome', $editando ? $medico->nome : '')); ?>" required>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="crm" class="form-label">CRM</label>
            <input type="text" name="crm" id="crm" class="form-control"
                value="<?= html_escape(set_value('crm', $editando ? $medico->crm : '')); ?>" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="especialidade" class="form-label">Especialidade</label>
            <input type="text" name="especialidade" id="especialidade" class="form-control"
                value="<?= html_escape(set_value('especialidade', $editando ? $medico->especialidade : '')); ?>" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="cpf" class="form-label">CPF</label>
            <input type="text" name="cpf" id="cpf" class="form-control"
                value="<?= html_escape(set_value('cpf', $cpf_atual)); ?>" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="telefone" class="form-label">Telefone</label>
            <input type="text" name="telefone" id="telefone" class="form-control"
                value="<?= html_escape(set_value('telefone', $telefone_atual)); ?>" required>
        </div>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" name="email" id="email" class="form-control"
            value="<?= html_escape(set_value('email', $email_atual)); ?>" required>
    </div>
    <div class="mb-3">
        <label for="situacao" class="form-label">Situação</label>
        <select name="situacao" id="situacao" class="form-select" required>
            <option value="ativo" <?= set_select('situacao', 'ativo', $situacao_atual === 'ativo'); ?>>Ativo</option>
            <option value="inativo" <?= set_select('situacao', 'inativo', $situacao_atual === 'inativo'); ?>>Inativo</option>
        </select>
    </div>
    <div class="d-flex justify-content-end gap-2">
        <?php if ($in_modal): ?>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <?php else: ?>
            <a href="<?= site_url('medicos'); ?>" class="btn btn-secondary">Cancelar</a>
        <?php endif; ?>
        <button type="submit" class="btn <?= $editando ? 'btn-warning' : 'btn-primary'; ?>">
            <?= $editando ? 'Atualizar Médico' : 'Cadastrar Médico'; ?>
        </button>
    </div>
<?= form_close(); ?>