<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario • SENA Empresa ERP</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('general/assets/img/cefaempresa.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('general/assets/img/cefaempresa.png') }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --sena-green: #39A900;
            --sena-green-hover: #2b8000;
            --sena-neon: #62E31D;
            --sena-navy-dark: #00131E;
            --sena-navy-mid: #001A29;
            --sena-navy-light: #002336;
        }

        body {
            font-family: 'Nunito', 'Open Sans', sans-serif;
            background: radial-gradient(circle at 10% 20%, rgba(57, 169, 0, 0.15), transparent 40%),
                        radial-gradient(circle at 90% 80%, rgba(0, 50, 77, 0.3), transparent 50%),
                        linear-gradient(135deg, var(--sena-navy-dark) 0%, var(--sena-navy-mid) 50%, var(--sena-navy-light) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
            color: #333;
        }

        .register-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.45);
            overflow: hidden;
            width: 100%;
            max-width: 1000px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .register-banner {
            background: linear-gradient(135deg, rgba(0, 26, 41, 0.95) 0%, rgba(0, 35, 54, 0.95) 100%),
                        url('{{ asset("general/assets/img/cefaempresa.png") }}') center/cover no-repeat;
            color: #ffffff;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            border-right: 4px solid var(--sena-green);
        }

        .register-banner::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle at 30% 30%, rgba(98, 227, 29, 0.12), transparent 60%);
            pointer-events: none;
        }

        .register-form-container {
            padding: 45px 40px;
            background: #ffffff;
        }

        .form-control {
            border-radius: 12px;
            padding: 11px 16px 11px 45px;
            border: 1.5px solid #e0e0e0;
            font-size: 14px;
            transition: all 0.25s ease;
        }

        .form-control:focus {
            border-color: var(--sena-green);
            box-shadow: 0 0 0 0.25rem rgba(57, 169, 0, 0.18);
        }

        .input-group-text-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            color: #888;
            font-size: 15px;
            transition: color 0.25s ease;
        }

        .form-group-custom:focus-within .input-group-text-icon {
            color: var(--sena-green);
        }

        .btn-sena {
            background: linear-gradient(135deg, #001A29 0%, #002D44 100%);
            color: #ffffff;
            font-weight: 700;
            border-radius: 12px;
            padding: 13px 24px;
            font-size: 15px;
            border: 2px solid #39A900;
            box-shadow: 0 6px 20px rgba(0, 26, 41, 0.35);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-sena:hover {
            background: linear-gradient(135deg, #39A900 0%, #2b8000 100%);
            color: #ffffff;
            border-color: #62E31D;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(57, 169, 0, 0.45);
        }

        .back-home-btn {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .back-home-btn:hover {
            color: var(--sena-neon);
            transform: translateX(-4px);
        }
    </style>
</head>
<body>

    <div class="register-card">
        <div class="row g-0">
            
            <!-- Left Banner -->
            <div class="col-lg-5 register-banner">
                <div>
                    @php
                        $targetRedirect = request('redirect', old('redirect', $redirect ?? ''));
                        $isSGC = !empty($targetRedirect) && str_contains(strtolower($targetRedirect), 'sgc');
                        $backUrl = $isSGC ? url('/sgc') : url('/');
                        $backText = $isSGC ? 'Volver al Módulo SGC' : 'Volver al Portal Principal';
                    @endphp
                    <a href="{{ $backUrl }}" class="back-home-btn mb-4">
                        <i class="fas fa-arrow-left"></i> {{ $backText }}
                    </a>

                    <div class="d-flex align-items-center mb-3 mt-2">
                        <img src="{{ asset('general/assets/img/cefaempresa.png') }}" alt="Logo SENA Empresa" class="bg-white rounded-circle p-2 shadow-sm me-3" style="width: 58px; height: 58px; object-fit: contain;">
                        <div>
                            <h3 class="fw-bold mb-0 text-white fs-4">SENA EMPRESA</h3>
                            <span class="fs-7 fw-semibold" style="color: var(--sena-neon);">Crear Cuenta en el ERP</span>
                        </div>
                    </div>

                    <p class="text-white-50 fs-6 leading-relaxed mb-4">
                        Regístrate para acceder a los módulos de gestión, control de turnos y procesos del Centro Agroindustrial <strong>"La Angostura"</strong>.
                    </p>
                </div>

                <div class="border-top border-secondary border-opacity-50 pt-4">
                    <p class="text-white-50 fs-7 mb-2">¿Ya tienes una cuenta registrada?</p>
                    <a href="{{ route('login', ['redirect' => $targetRedirect]) }}" class="btn btn-outline-light rounded-pill px-4 py-2 fs-7 fw-bold">
                        <i class="fas fa-right-to-bracket me-1" style="color: var(--sena-neon) !important;"></i> Iniciar Sesión
                    </a>
                </div>
            </div>

            <!-- Right Form: Registration -->
            <div class="col-lg-7 register-form-container d-flex flex-column justify-content-between">
                <div>
                    <div class="mb-4">
                        <h4 class="fw-bold text-dark mb-1">Registro de Nuevo Usuario</h4>
                        <p class="text-muted fs-7 mb-0">Completa tus datos para crear tu usuario en la plataforma.</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger border-0 rounded-3 shadow-sm mb-3 py-2 px-3 fs-7" role="alert">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="fas fa-exclamation-triangle text-danger fs-6"></i>
                                <strong>Corrige los siguientes errores:</strong>
                            </div>
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register.post') }}" method="POST">
                        @csrf
                        <input type="hidden" name="redirect" value="{{ old('redirect', $redirect ?? request('redirect')) }}">

                        <!-- Nombre Completo -->
                        <div class="mb-3 position-relative form-group-custom">
                            <label for="nombre_completo" class="form-label fw-semibold text-secondary fs-7 mb-1">Nombre Completo</label>
                            <div class="position-relative">
                                <i class="fas fa-user input-group-text-icon"></i>
                                <input type="text" id="nombre_completo" name="nombre_completo" value="{{ old('nombre_completo') }}" class="form-control @error('nombre_completo') is-invalid @enderror" placeholder="Ej: Juan Pérez Morales" required autofocus>
                            </div>
                        </div>

                        <!-- Nombre de Usuario -->
                        <div class="mb-3 position-relative form-group-custom">
                            <label for="nombre_usuario" class="form-label fw-semibold text-secondary fs-7 mb-1">Nombre de Usuario (Nickname)</label>
                            <div class="position-relative">
                                <i class="fas fa-id-badge input-group-text-icon"></i>
                                <input type="text" id="nombre_usuario" name="nombre_usuario" value="{{ old('nombre_usuario') }}" class="form-control @error('nombre_usuario') is-invalid @enderror" placeholder="Ej: jperez" required>
                            </div>
                        </div>

                        <!-- Correo Electrónico -->
                        <div class="mb-3 position-relative form-group-custom">
                            <label for="correo" class="form-label fw-semibold text-secondary fs-7 mb-1">Correo Electrónico Institucional</label>
                            <div class="position-relative">
                                <i class="fas fa-envelope input-group-text-icon"></i>
                                <input type="email" id="correo" name="correo" value="{{ old('correo') }}" class="form-control @error('correo') is-invalid @enderror" placeholder="usuario@soy.sena.edu.co" required>
                            </div>
                        </div>

                        <!-- Password y Confirmación en Grid -->
                        <div class="row g-2 mb-4">
                            <div class="col-md-6">
                                <div class="position-relative form-group-custom">
                                    <label for="password" class="form-label fw-semibold text-secondary fs-7 mb-1">Contraseña</label>
                                    <div class="position-relative">
                                        <i class="fas fa-lock input-group-text-icon"></i>
                                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Mínimo 8 caracteres" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group-custom">
                                    <label for="password_confirmation" class="form-label fw-semibold text-secondary fs-7 mb-1">Confirmar Contraseña</label>
                                    <div class="position-relative">
                                        <i class="fas fa-shield-check input-group-text-icon"></i>
                                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Repite la contraseña" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-sena w-100 mb-3">
                            <i class="fas fa-user-plus me-1" style="color: var(--sena-neon);"></i>
                            <span>Crear mi Cuenta en SENA Empresa</span>
                        </button>

                        <!-- Enlace directo al Login -->
                        <div class="text-center mt-3">
                            <span class="text-muted fs-7">¿Ya tienes una cuenta registrada?</span>
                            <a href="{{ route('login', ['redirect' => $targetRedirect]) }}" class="fw-bold text-decoration-none ms-1" style="color: var(--sena-green);">Inicia sesión aquí</a>
                        </div>
                    </form>
                </div>

                <div class="text-center pt-3 border-top mt-3">
                    <p class="text-muted fs-8 mb-0">
                        Centro de Formación Agroindustrial <strong>"La Angostura"</strong> • SENA Empresa &copy; {{ date('Y') }}
                    </p>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
