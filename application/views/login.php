<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema Médico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="card shadow-sm p-4" style="width: 100%; max-width: 400px;">
        <h3 class="text-center mb-4">Acesso ao Sistema</h3>

        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger text-center">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('login/autenticar'); ?>" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" class="form-control" required placeholder="admin@admin.com">
            </div>

            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" name="senha" id="senha" class="form-control" required placeholder="123456">
            </div>

            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
    </div>

</body>
</html>