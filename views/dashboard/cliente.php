<div class="container-fluid p-4">
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info border-0 shadow-sm">
                <h2><i class="bi bi-person-heart me-2"></i>Panel de Cliente</h2>
                <p class="mb-0">Bienvenido, <strong><?= $usuario['correo'] ?? 'Cliente' ?></strong></p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5>Mi Cuenta</h5>
                    <p>Aquí podrás ver tu perfil y hacer pedidos.</p>
                </div>
            </div>
        </div>
    </div>
</div>