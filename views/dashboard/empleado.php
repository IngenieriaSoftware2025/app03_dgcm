<div class="container-fluid p-4">
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success border-0 shadow-sm">
                <h2><i class="bi bi-person-workspace me-2"></i>Panel de Empleado</h2>
                <p class="mb-0">Bienvenido, <strong><?= $usuario['correo'] ?? 'Empleado' ?></strong></p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5>Área de Trabajo</h5>
                    <p>Aquí irán las tareas y funciones específicas para empleados.</p>
                </div>
            </div>
        </div>
    </div>
</div>