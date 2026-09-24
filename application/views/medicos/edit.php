<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Médico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5" style="max-width: 600px;">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">Editar Médico #<?= $medico->id; ?></h4>
            </div>
            <div class="card-body">
                <!-- ROTA CORRETA: medicos/update/ID_DO_MEDICO -->
                <form action="<?= site_url('medicos/update/' . $medico->id); ?>" method="post">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" name="nome" id="nome" class="form-control" value="<?= $medico->nome; ?>"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="crm" class="form-label">CRM</label>
                        <input type="text" name="crm" id="crm" class="form-control" value="<?= $medico->crm; ?>"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="especialidade" class="form-label">Especialidade</label>
                        <input type="text" name="especialidade" id="especialidade" class="form-control"
                            value="<?= $medico->especialidade; ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="cpf" class="form-label">CPF</label>
                        <input type="text" name="cpf" id="cpf" class="form-control"
                            value="<?= isset($medico->cpf) ? $medico->cpf : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" name="telefone" id="telefone" class="form-control"
                            value="<?= isset($medico->telefone) ? $medico->telefone : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" name="email" id="email" class="form-control"
                            value="<?= isset($medico->email) ? $medico->email : ''; ?>">
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="<?= site_url('medicos'); ?>" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-warning">Atualizar Médico</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>