<?php
$medico = isset($medico) ? $medico : null;
if (!is_object($medico)) {
    show_404();
    return;
}
?>
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
                <h4 class="mb-0">Editar Médico #<?= (int) $medico->id; ?></h4>
            </div>
            <div class="card-body">
                <?php $this->load->view('medicos/medico_form', array('medico' => $medico, 'in_modal' => FALSE)); ?>
            </div>
        </div>
    </div>
</body>

</html>