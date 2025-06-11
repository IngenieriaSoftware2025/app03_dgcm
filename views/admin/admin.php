<div class="container-fluid p-4">
    <div class="row">
        <div class="col-12">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <h2><i class="bi bi-shield-fill-check me-2"></i>Panel de Administración</h2>
                    <p class="mb-0">Bienvenido, <?= $usuario['correo'] ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- MÓDULOS DE ADMINISTRADOR -->
    <div class="row g-4">
        <!-- GESTIÓN DE USUARIOS -->
        <div class="col-md-6 col-xl-3">
            <div class="card bg-gradient-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>Usuarios</h5>
                            <p>Gestionar usuarios del sistema</p>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-people-fill fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="text-white stretched-link" href="/app03_dgcm/registro">Ver Usuarios</a>
                    <i class="bi bi-arrow-right text-white"></i>
                </div>
            </div>
        </div>

        <!-- GESTIÓN DE ROLES -->
        <div class="col-md-6 col-xl-3">
            <div class="card bg-gradient-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>Roles</h5>
                            <p>Administrar roles del sistema</p>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-award-fill fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="text-white stretched-link" href="/app03_dgcm/roles">Ver Roles</a>
                    <i class="bi bi-arrow-right text-white"></i>
                </div>
            </div>
        </div>

        <!-- GESTIÓN DE PERMISOS -->
        <div class="col-md-6 col-xl-3">
            <div class="card bg-gradient-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>Permisos</h5>
                            <p>Asignar roles a usuarios</p>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-shield-check fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="text-white stretched-link" href="/app03_dgcm/permisos">Ver Permisos</a>
                    <i class="bi bi-arrow-right text-white"></i>
                </div>
            </div>
        </div>

        <!-- APLICACIONES -->
        <div class="col-md-6 col-xl-3">
            <div class="card bg-gradient-danger text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>Aplicaciones</h5>
                            <p>Gestionar aplicaciones</p>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-grid-3x3-gap-fill fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="text-white stretched-link" href="/app03_dgcm/aplicaciones">Ver Aplicaciones</a>
                    <i class="bi bi-arrow-right text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- ESTADÍSTICAS -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-graph-up me-2"></i>Estadísticas del Sistema</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Aquí irían gráficos y estadísticas del sistema...</p>
                </div>
            </div>
        </div>
    </div>
</div>