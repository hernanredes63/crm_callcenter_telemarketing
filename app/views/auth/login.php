<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['titulo']; ?></title>
    <style>
        body { font-family: system-ui, sans-serif; background-color: #f3f4f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); width: 100%; max-width: 350px; }
        .login-card h2 { text-align: center; color: #1f2937; margin-top: 0; }
        .form-group { margin-bottom: 1rem; }
        .form-group input { width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 4px; box-sizing: border-box; }
        .btn { width: 100%; padding: 0.75rem; background: #2563eb; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 1rem; font-weight: bold; }
        .btn:hover { background: #1d4ed8; }
        .error { color: #dc2626; font-size: 0.875rem; text-align: center; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>GESTIONA CRM</h2>
        <?php if(isset($data['error'])): ?>
            <div class="error"><?php echo $data['error']; ?></div>
        <?php endif; ?>
        
        <form action="/crm_callcenter/public/auth/login" method="POST">
            <div class="form-group">
                <input type="email" name="email" placeholder="Correo electrónico" required autocomplete="email">
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>