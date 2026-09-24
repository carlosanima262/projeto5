<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Novo Médico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-4 mb-5" style="max-width: 600px;">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Cadastrar Novo Médico</h4>
            </div>
            <div class="card-body">

                <!-- Exibe erros de validação do servidor -->
                <?php if (validation_errors()): ?>
                    <div class="alert alert-danger">
                        <?= validation_errors(); ?>
                    </div>
                <?php endif; ?>

                <?= form_open('medicos/store'); ?>
                    <div class="mb-3">
                        <label class="form-label">Nome Completo *</label>
                        <input type="text" name="nome" class="form-control" value="<?= set_value('nome'); ?>" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">CRM *</label>
                            <input type="text" name="crm" class="form-control" value="<?= set_value('crm'); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Especialidade *</label>
                            <input type="text" name="especialidade" class="form-control" value="<?= set_value('especialidade'); ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Telefone</label>
                            <input type="text" name="telefone" id="telefone" class="form-control" value="<?= set_value('telefone'); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">E-mail</label>
                            <input type="email" name="email" class="form-control" value="<?= set_value('email'); ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Situação *</label>
                        <select name="situacao" class="form-select" required>
                            <option value="ativo" <?= set_select('situacao', 'ativo', TRUE); ?>>Ativo</option>
                            <option value="inativo" <?= set_select('situacao', 'inativo'); ?>>Inativo</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="<?= site_url('medicos'); ?>" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-success">Guardar Médico</button>
                    </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</body>
</html>