<?php require_once __DIR__ . '/../layout/header.php'; ?>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<!-- Encabezado de la página -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold text-dark d-flex align-items-center">
            <i class="bi bi-person-vcard text-secondary me-2 fs-3"></i> Usuarios
        </h4>
        <small class="text-muted ms-1">Gestiona los usuarios del sistema</small>
    </div>
    <a href="/crm_callcenter/public/users/create" class="btn btn-primary btn-sm px-3 fw-medium">
        <i class="bi bi-person-plus-fill me-1"></i> Nuevo Usuario
    </a>
</div>

<!-- Contenedor Principal (Card) -->
<div class="card border-0 shadow-sm">
    <!-- Card Header estilo panel -->
    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
        <i class="bi bi-shield-check text-muted me-2"></i>
        <span class="fw-bold text-dark mb-0">Usuarios registrados</span>
        <span class="badge bg-secondary ms-2" style="font-size: 0.75rem;"><?php echo count($data['users']); ?></span>
    </div>
    
    <!-- Card Body con Tabla -->
    <div class="card-body p-4">
        <div class="table-responsive">
            <table id="tablaUsuarios" class="table table-hover align-middle w-100" style="font-size: 0.85rem;">
                <thead class="text-muted" style="border-bottom: 2px solid #dee2e6;">
                    <tr>
                        <th class="fw-bold pb-3">Nombre</th>
                        <th class="fw-bold pb-3">Email</th>
                        <th class="fw-bold pb-3">Rol</th>
                        <th class="fw-bold pb-3">Estado</th>
                        <th class="fw-bold pb-3 text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($data['users'])): ?>
                        <?php foreach($data['users'] as $user): ?>
                            <tr>
                                <!-- Nombre -->
                                <td class="fw-medium text-dark"><?php echo htmlspecialchars($user['nombre']); ?></td>
                                
                                <!-- Email -->
                                <td class="text-muted"><?php echo htmlspecialchars($user['email']); ?></td>
                                
                                <!-- Rol -->
                                <td>
                                    <?php 
                                        $rol = htmlspecialchars($user['role']);
                                        $badgeClass = (strtolower($rol) === 'admin' || strtolower($rol) === 'administrador') ? 'bg-primary' : 'bg-secondary';
                                    ?>
                                    <span class="badge <?php echo $badgeClass; ?> text-capitalize px-2 py-1">
                                        <?php echo $rol; ?>
                                    </span>
                                </td>
                                
                                <!-- Estado -->
                                <td>
                                    <span class="badge bg-success rounded-pill px-2 py-1">Activo</span>
                                </td>
                                
                                <!-- Acciones (Ojito, Lápiz, Basurero) -->
                                <td class="text-end pe-3">
                                    <div class="d-inline-flex gap-1">
                                        <!-- Ver -->
                                        <a href="/crm_callcenter/public/users/show/<?php echo $user['id']; ?>" class="btn btn-sm btn-outline-info px-2 py-1" title="Ver Detalles">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        
                                        <!-- Editar -->
                                        <a href="/crm_callcenter/public/users/edit/<?php echo $user['id']; ?>" class="btn btn-sm btn-outline-primary px-2 py-1" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        
                                        <!-- Eliminar -->
                                        <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                            <form action="/crm_callcenter/public/users/delete/<?php echo $user['id']; ?>" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar a este usuario? Esta acción no se puede deshacer.');">
                                                <button type="submit" class="btn btn-sm btn-outline-danger px-2 py-1" title="Eliminar">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <!-- Botón bloqueado para el usuario activo -->
                                            <button class="btn btn-sm btn-outline-secondary px-2 py-1 disabled" title="No puedes eliminarte a ti mismo">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- jQuery y DataTables JS para la interactividad (Buscador y Paginación) -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tablaUsuarios').DataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "pageLength": 25,
            "ordering": true,
            "order": [[0, 'asc']] // Ordenar por nombre por defecto
        });
    });
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>