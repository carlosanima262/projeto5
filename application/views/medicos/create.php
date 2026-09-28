<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Médico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <main class="container mt-4 mb-5" style="max-width: 600px;">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h1 class="h4 mb-0">Cadastrar Novo Médico</h1>
            </div>
            <div class="card-body">
                <?php $this->load->view('medicos/medico_form', array('medico' => null, 'in_modal' => FALSE)); ?>
            </div>
        </div>
    </main>
</body>
</html>