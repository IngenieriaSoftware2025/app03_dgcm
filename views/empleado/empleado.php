<div class="container-fluid p-4">
    <div class="row">
        <div class="col-12">
            <div class="card bg-warning text-dark mb-4">
                <div class="card-body">
                    <h2><i class="bi bi-person-badge me-2"></i>Panel de Empleado</h2>
                    <p class="mb-0">Bienvenido, <?= $usuario['correo'] ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- MÓDULOS DE EMPLEADO -->
    <div class="row g-4">
        <!-- MI PERFIL -->
        <div class="col-md-6 col-xl-4">
            <div class="card bg-gradient-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>Mi Perfil</h5>
                            <p>Ver y editar mi información</p>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-person-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="text-white stretched-link" href="/app03_dgcm/perfil">Ver Perfil</a>
                    <i class="bi bi-arrow-right text-white"></i>
                </div>
            </div>
        </div>

        <!-- TAREAS ASIGNADAS -->
        <div class="col-md-6 col-xl-4">
            <div class="card bg-gradient-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>Mis Tareas</h5>
                            <p>Tareas asignadas a mí</p>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-list-check fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="text-white stretched-link" href="/app03_dgcm/tareas">Ver Tareas</a>
                    <i class="bi bi-arrow-right text-white"></i>
                </div>
            </div>
        </div>

        <!-- REPORTES -->
        <div class="col-md-6 col-xl-4">
            <div class="card bg-gradient-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>Reportes</h5>
                            <p>Generar reportes de trabajo</p>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-file-earmark-text fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="text-white stretched-link" href="/app03_dgcm/reportes">Ver Reportes</a>
                    <i class="bi bi-arrow-right text-white"></i>
                </div>
            </div>
        </div>
    </div>
</div>