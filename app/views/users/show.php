<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0 fw-bold text-dark">
        <i class="bi bi-person-vcard me-1 opacity-75"></i> Detalles del Usuario
    </h5>
    <a href="/crm_callcenter/public/users" class="btn btn-outline-secondary btn-sm px-3 bg-white">
        <i class="bi bi-arrow-left"></i> Volver al Listado
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-person-fill text-secondary" style="font-size: 2.5rem;"></i>
                    </div>
                    <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($data['user']['nombre']); ?></h5>
                    <span class="badge bg-primary px-3 py-2 text-uppercase" style="background-color: #3b2853 !important;">
                        <?php echo htmlspecialchars($data['user']['role']); ?>
                    </span>
                </div>

                <ul class="list-group list-group-flush border-top">
                    <li class="list-group-item px-0 py-3 d-flex justify-content-between align-items-center">
                        <span class="text-muted fw-bold" style="font-size: 0.8rem; text-transform: uppercase;">ID de Sistema</span>
                        <span class="fw-medium text-dark">#<?php echo $data['user']['id']; ?></span>
                    </li>
                    <li class="list-group-item px-0 py-3 d-flex justify-content-between align-items-center">
                        <span class="text-muted fw-bold" style="font-size: 0.8rem; text-transform: uppercase;">Correo Electrónico</span>
                        <span class="fw-medium text-dark"><?php echo htmlspecialchars($data['user']['email']); ?></span>
                    </li>
                    <li class="list-group-item px-0 py-3 d-flex justify-content-between align-items-center border-bottom-0">
                        <span class="text-muted fw-bold" style="font-size: 0.8rem; text-transform: uppercase;">Estado de Cuenta</span>
                        <span class="fw-medium text-success"><i class="bi bi-check-circle-fill me-1"></i> Activo</span>
                    </li>
                </ul>
            </div>
            <div class="card-footer bg-light text-end py-3 border-0">
                <a href="/crm_callcenter/public/users/edit/<?php echo $data['user']['id']; ?>" class="btn btn-primary px-4" style="background-color: #6f42c1; border-color: #6f42c1;">
                    <i class="bi bi-pencil me-1"></i> Editar Datos
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>