<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 • Acceso Denegado | SENA Empresa</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }
        .error-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0, 23, 36, 0.08);
            border: 1px solid #e2e8f0;
            max-width: 520px;
            width: 100%;
            text-align: center;
            padding: 40px 32px;
        }
        .shield-icon-wrapper {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            margin-bottom: 24px;
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.2);
        }
        .btn-sena {
            background-color: #39A900;
            color: #ffffff;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }
        .btn-sena:hover {
            background-color: #2e8b00;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(57, 169, 0, 0.3);
        }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="shield-icon-wrapper">
            <i class="fas fa-shield-halved"></i>
        </div>
        <h1 class="fw-bolder text-dark mb-2" style="font-family: 'Outfit', sans-serif; font-size: 32px; letter-spacing: -0.02em;">403 • Acceso Restringido</h1>
        <p class="text-muted mb-4" style="font-size: 14px; line-height: 1.6;">
            {{ $exception->getMessage() ?: 'No cuentas con los permisos o privilegios autorizados para acceder a este recurso institucional.' }}
        </p>
        <div class="d-flex flex-wrap justify-content-center gap-2">
            <a href="javascript:history.back()" class="btn btn-outline-secondary rounded-3 px-3 py-2 fw-semibold" style="font-size: 14px;">
                <i class="fas fa-arrow-left me-1"></i> Regresar
            </a>
            <a href="{{ route('sgc.dashboard') }}" class="btn-sena" style="font-size: 14px;">
                <i class="fas fa-house"></i> Ir al Dashboard SGC
            </a>
        </div>
        <div class="mt-4 pt-3 border-top text-muted small" style="font-size: 12px;">
            Sistema de Gestión de Calidad • SENA Empresa CFA
        </div>
    </div>
</body>
</html>
