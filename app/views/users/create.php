<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0 fw-bold text-dark">
        <i class="bi bi-person-plus me-1 opacity-75"></i> Registrar Nuevo Usuario
    </h5>
    <a href="/crm_callcenter/public/users" class="btn btn-outline-secondary btn-sm px-3 bg-white">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="/crm_callcenter/public/users/store" method="POST">
                    
                    <div class="mb-3">
                        <label class="form-label text-uppercase fw-bold text-muted" style="font-size: 0.70rem;">Nombre Completo <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" class="form-control form-control-sm" required placeholder="Ej. Juan Pérez">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-uppercase fw-bold text-muted" style="font-size: 0.70rem;">Correo Electrónico <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control form-control-sm" required placeholder="correo@empresa.com">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-uppercase fw-bold text-muted" style="font-size: 0.70rem;">Contraseña Temporal <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control form-control-sm" required placeholder="••••••••">
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-uppercase fw-bold text-muted" style="font-size: 0.70rem;">Rol del Sistema <span class="text-danger">*</span></label>
                        <select name="role" class="form-select form-select-sm text-muted" required>
                            <option value="">— Seleccionar Rol —</option>
                            <option value="admin">Administrador</option>
                            <option value="supervisor">Supervisor</option>
                            <option value="agente">Agente</option>
                            <option value="vendedor">Vendedor</option>
                            <option value="marketing">Marketing</option>
                        </select>
                    </div>

                    <div class="text-end border-top pt-3">
                        <button type="submit" class="btn btn-primary px-4 py-2 text-white" style="background-color: #6f42c1; border-color: #6f42c1;">
                            <i class="bi bi-check-lg me-1"></i> Guardar Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>