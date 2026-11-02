<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0 fw-bold text-dark">
        <i class="bi bi-pencil-square me-1 opacity-75"></i> Editar Usuario
    </h5>
    <a href="/crm_callcenter/public/users" class="btn btn-outline-secondary btn-sm px-3 bg-white">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="/crm_callcenter/public/users/update/<?php echo $data['user']['id']; ?>" method="POST">
                    
                    <div class="mb-3">
                        <label class="form-label text-uppercase fw-bold text-muted" style="font-size: 0.70rem;">Nombre Completo <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" class="form-control form-control-sm" required 
                               value="<?php echo htmlspecialchars($data['user']['nombre']); ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-uppercase fw-bold text-muted" style="font-size: 0.70rem;">Correo Electrónico <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control form-control-sm" required 
                               value="<?php echo htmlspecialchars($data['user']['email']); ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-uppercase fw-bold text-muted" style="font-size: 0.70rem;">Nueva Contraseña</label>
                        <input type="password" name="password" class="form-control form-control-sm" placeholder="••••••••">
                        <div class="form-text" style="font-size: 0.75rem;">Dejar en blanco para conservar la contraseña actual.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-uppercase fw-bold text-muted" style="font-size: 0.70rem;">Rol del Sistema <span class="text-danger">*</span></label>
                        <?php $rolActual = $data['user']['role']; ?>
                        <select name="role" class="form-select form-select-sm text-muted" required>
                            <option value="admin" <?php echo $rolActual === 'admin' ? 'selected' : ''; ?>>Administrador</option>
                            <option value="supervisor" <?php echo $rolActual === 'supervisor' ? 'selected' : ''; ?>>Supervisor</option>
                            <option value="agente" <?php echo $rolActual === 'agente' ? 'selected' : ''; ?>>Agente</option>
                            <option value="vendedor" <?php echo $rolActual === 'vendedor' ? 'selected' : ''; ?>>Vendedor</option>
                            <option value="marketing" <?php echo $rolActual === 'marketing' ? 'selected' : ''; ?>>Marketing</option>
                        </select>
                    </div>

                    <div class="text-end border-top pt-3">
                        <button type="submit" class="btn btn-primary px-4 py-2 text-white" style="background-color: #6f42c1; border-color: #6f42c1;">
                            <i class="bi bi-save me-1"></i> Actualizar Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>