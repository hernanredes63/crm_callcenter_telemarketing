<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($data['titulo']) ? $data['titulo'] : 'GESTIONA CRM'; ?></title>
    <!-- Bootstrap 5 CSS y Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; background-color: #f8f9fa; }
        
        /* Colores corporativos GESTIONA y Ancho Fijo del Menú */
        .sidebar { 
            min-height: 100vh; 
            background-color: #3b2853; /* Morado oscuro corporativo */
            color: white; 
            /* Bloqueo estricto del ancho para evitar que flexbox lo aplaste */
            width: 250px !important;
            min-width: 160px !important;
            max-width: 160px !important;
            flex-shrink: 0 !important; 
        }
        .sidebar-title { font-weight: 700; font-size: 1.15rem; letter-spacing: 0.5px; }
        .sidebar-subtitle { color: #00d2ff; font-size: 0.8rem; margin-bottom: 20px; }
        
        .sidebar nav a { 
            color: #e2d8f0; 
            text-decoration: none; 
            padding: 10px 16px; 
            display: block; 
            border-radius: 6px; 
            margin-bottom: 4px; 
            font-size: 0.95rem;
            transition: 0.2s; 
        }
        .sidebar nav a:hover { background-color: rgba(255,255,255,0.05); color: white; }
        .sidebar nav a.active { 
            background-color: #0d6efd; /* Azul brillante */
            color: white; 
            font-weight: 500;
        }
        
        .main-content { width: 100%; overflow-x: hidden; }
        .navbar { background-color: white; border-bottom: 1px solid #e5e7eb; }
        .navbar-text-custom { font-size: 0.85rem; color: #4b5563; }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Menú Lateral (Sidebar) -->
        <div class="sidebar p-3 d-none d-md-block">
            <div class="d-flex align-items-center mb-0 mt-2">
                <i class="bi bi-telephone-fill fs-5 me-2"></i>
                <span class="sidebar-title">CRM GESTIONA</span>
            </div>
            <div class="sidebar-subtitle ms-4 ps-1">Telemarketing</div>
            
            <nav class="mt-4">
                <!-- Enlace actualizado a /inicio con validación de estado activo -->
                <a href="/crm_callcenter/public/inicio" class="<?php echo ($_SERVER['REQUEST_URI'] == '/crm_callcenter/public/inicio' || $_SERVER['REQUEST_URI'] == '/crm_callcenter/public/') ? 'active' : ''; ?>">
                    <i class="bi bi-house-door me-2"></i> Inicio
                </a>
                <a href="/crm_callcenter/public/leads" class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'leads') !== false) ? 'active' : ''; ?>">
                    <i class="bi bi-person-fill me-2"></i> Leads
                </a>
                <a href="#"><i class="bi bi-people-fill me-2"></i> Leads Redes</a>
                <a href="#"><i class="bi bi-share me-2"></i> Derivados</a>
                <a href="#"><i class="bi bi-cart-check me-2"></i> Ventas</a>
                <a href="#"><i class="bi bi-graph-up-arrow me-2"></i> Seguimiento Ventas</a>
                <a href="#"><i class="bi bi-calendar3 me-2"></i> Calendario</a>
                <a href="#"><i class="bi bi-bar-chart-line me-2"></i> Reportes</a>
                
                <hr style="border-color: rgba(255,255,255,0.1); margin: 1.5rem 0;">
                
                <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                    <a href="/crm_callcenter/public/users" class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'users') !== false) ? 'active' : ''; ?>">
                        <i class="bi bi-person-badge me-2"></i> Usuarios
                    </a>
                    <a href="#"><i class="bi bi-database me-2"></i> Base / Catálogos</a>
                <?php endif; ?>
            </nav>
        </div>

        <!-- Contenedor Principal -->
        <div class="main-content">
            <!-- Barra Superior (Topbar) -->
            <nav class="navbar navbar-expand px-4 py-2 d-flex justify-content-end">
                <div class="d-flex align-items-center">
                    <span class="me-3 navbar-text-custom">
                        <?php echo ucfirst($_SESSION['user_nombre'] ?? 'Administrador'); ?> · 
                        <?php echo $_SESSION['user_role'] ?? 'admin'; ?>
                    </span>
                    <a href="/crm_callcenter/public/auth/logout" class="btn btn-sm btn-outline-danger px-3">
                        <i class="bi bi-box-arrow-right"></i> Salir
                    </a>
                </div>
            </nav>

            <!-- Área de Contenido Dinámico -->
            <div class="container-fluid p-4">