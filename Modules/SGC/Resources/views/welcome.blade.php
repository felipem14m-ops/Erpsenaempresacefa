<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>SGC • Sistema de Gestión de Calidad | SENA Empresa</title>
    <meta name="description" content="Sistema de Gestión de Calidad (SGC) - Plataforma oficial de documentación de calidad del Centro de Formación Agroindustrial La Angostura, SENA Regional Huila.">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('modules/sgc/img/Logo.png') }}">

    <!-- Google Fonts: Outfit (Titulares limpios) & Plus Jakarta Sans (Texto de lectura) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=Sora:wght@600;700;800&family=Space+Grotesk:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & FontAwesome Icons -->
    <link href="https://sicefa.com.co/general/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            /* SENA Palette */
            --sena-green: #39A900;
            --sena-green-dark: #007832;
            --sena-green-darker: #004d20;
            --sena-green-light: #22c55e;
            --sena-green-soft: #f0fdf4;
            --sena-green-subtle: #dcfce7;
            --sena-green-glow: rgba(57, 169, 0, 0.2);
            
            /* Backgrounds & Neutrals */
            --sena-dark: #121212;
            --sena-dark-footer: #18181b;
            --sena-slate: #0f172a;
            --sena-text-main: #1e293b;
            --sena-muted: #64748b;
            --sena-border: #e2e8f0;
            --sena-border-subtle: #eef2f6;

            /* Chips & States */
            --chip-borrador-bg: #f1f5f9;
            --chip-borrador-text: #475569;
            --chip-revision-bg: #fef3c7;
            --chip-revision-text: #d97706;
            --chip-vigente-bg: #dcfce7;
            --chip-vigente-text: #15803d;
            --chip-obsoleto-bg: #fee2e2;
            --chip-obsoleto-text: #dc2626;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #ffffff;
            color: var(--sena-text-main);
            line-height: 1.6;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* Distinctive Typography */
        h1, h2, h3, h4, h5, h6, .font-heading {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.025em;
        }

        /* ======= TRANSLUCENT & HIGHLIGHT TYPOGRAPHY ======= */
        .hero-title-main {
            font-family: 'Outfit', 'Space Grotesk', sans-serif;
            font-weight: 800;
            font-size: clamp(2.3rem, 4.5vw, 3.8rem);
            line-height: 1.12;
            letter-spacing: -0.035em;
            color: #0f172a;
        }

        /* Estilo de Letras Translúcidas con Gradiente de Luz */
        .hero-translucent-text {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.98) 0%, rgba(0, 77, 32, 0.92) 50%, rgba(57, 169, 0, 0.96) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
            text-shadow: 0 4px 20px rgba(0, 23, 36, 0.05);
        }

        .text-sena-green {
            color: var(--sena-green) !important;
        }

        .text-sena-green-translucent {
            background: linear-gradient(135deg, #007832 0%, #39A900 60%, #4ade80 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
            filter: drop-shadow(0 4px 16px rgba(57, 169, 0, 0.28));
        }

        /* Pills de Sección Suaves */
        .pill-section-tag {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 5px 16px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .pill-oficial {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.76rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            background: #fbfdeb;
            border: 1.2px solid #facc15;
            color: #4d7c0f;
            box-shadow: 0 2px 8px rgba(250, 204, 21, 0.15);
        }

        /* Botones Principales */
        .btn-sena-cta-primary {
            background-color: var(--sena-green);
            color: #ffffff !important;
            font-weight: 700;
            font-size: 0.95rem;
            padding: 13px 28px;
            border-radius: 12px;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 8px 20px -4px rgba(57, 169, 0, 0.35);
            transition: all 0.28s ease;
            text-decoration: none;
        }

        .btn-sena-cta-primary:hover {
            background-color: var(--sena-green-dark);
            transform: translateY(-2px);
            box-shadow: 0 12px 24px -4px rgba(57, 169, 0, 0.45);
        }

        .btn-sena-cta-outline {
            background-color: #ffffff;
            color: var(--sena-green) !important;
            font-weight: 700;
            font-size: 0.95rem;
            padding: 12px 26px;
            border-radius: 12px;
            border: 2px solid var(--sena-green);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.28s ease;
            text-decoration: none;
        }

        .btn-sena-cta-outline:hover {
            background-color: #f0fdf4;
            transform: translateY(-2px);
        }

        /* Hero Right Pastel Green Box */
        .hero-mint-canvas {
            background: #e3f4e1;
            border-radius: 28px;
            width: 100%;
            position: relative;
            display: flex;
            flex-direction: column;
            padding: 24px;
            box-shadow: inset 0 2px 6px rgba(255, 255, 255, 0.6);
        }

        .hero-docs-scroll {
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-height: 380px;
            overflow-y: auto;
            padding-right: 4px;
        }

        .hero-docs-scroll::-webkit-scrollbar {
            width: 5px;
        }

        .hero-docs-scroll::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        .hero-docs-scroll::-webkit-scrollbar-thumb {
            background: rgba(57, 169, 0, 0.3);
            border-radius: 10px;
        }

        .hero-floating-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 16px 20px;
            width: 100%;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.04), 0 2px 5px rgba(0, 0, 0, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.95);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            cursor: pointer;
        }

        .hero-floating-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 28px rgba(57, 169, 0, 0.12);
            border-color: #86efac;
        }

        /* Section Containers & Padding */
        .section-sgc-container {
            max-width: 1360px;
            margin: 0 auto;
            padding-left: 24px;
            padding-right: 24px;
        }

        .py-sgc {
            padding-top: 100px;
            padding-bottom: 100px;
        }

        .py-sgc-roles {
            padding-top: 100px;
            padding-bottom: 130px;
        }

        /* Status Chips */
        .status-chip {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .status-chip-vigente {
            background-color: var(--chip-vigente-bg);
            color: var(--chip-vigente-text);
        }

        .status-chip-revision {
            background-color: var(--chip-revision-bg);
            color: var(--chip-revision-text);
        }

        .status-chip-borrador {
            background-color: var(--chip-borrador-bg);
            color: var(--chip-borrador-text);
        }

        /* Funcionalidades Clave Card con Iluminación Verde Intensa */
        .func-card-item {
            background: #ffffff;
            border-radius: 20px;
            padding: 34px 28px;
            border: 1.5px solid #eef2f6;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            height: 100%;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
        }

        .func-card-item:hover {
            transform: translateY(-8px) scale(1.015);
            border-color: #22c55e !important;
            box-shadow: 0 16px 40px rgba(34, 197, 94, 0.28), 0 0 30px rgba(57, 169, 0, 0.45) !important;
        }

        .func-card-item:hover .func-icon-square {
            background: linear-gradient(135deg, #39A900 0%, #22c55e 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 0 25px rgba(34, 197, 94, 0.6) !important;
            transform: scale(1.1);
        }

        .func-card-item:hover h4 {
            color: var(--sena-green) !important;
        }

        .func-icon-square {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background-color: #eefbf1;
            color: var(--sena-green);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.45rem;
            margin-bottom: 22px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* Listado Maestro Search & Table */
        .table-docs-container {
            background: #ffffff;
            border-radius: 28px;
            padding: 34px 38px;
            border: 2px solid #86efac;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.04), 0 0 24px rgba(134, 239, 172, 0.22);
            max-width: 1220px;
            margin: 0 auto;
            width: 100%;
            transition: all 0.3s ease;
        }

        .table-docs-container:hover {
            border-color: #4ade80;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.06), 0 0 32px rgba(57, 169, 0, 0.25);
        }

        .doc-code-highlight {
            color: #16a34a !important;
            font-weight: 800;
            letter-spacing: -0.01em;
            font-size: 0.95rem;
        }

        .filter-search-box {
            position: relative;
        }

        .filter-search-box i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .filter-search-box input {
            padding-left: 42px;
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            height: 46px;
            font-size: 0.92rem;
            transition: all 0.25s ease;
        }

        .filter-search-box input:focus {
            border-color: var(--sena-green);
            box-shadow: 0 0 0 4px rgba(57, 169, 0, 0.18);
        }

        .filter-select {
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            height: 46px;
            font-size: 0.92rem;
            color: #334155;
            transition: all 0.25s ease;
        }

        .filter-select:focus {
            border-color: var(--sena-green);
            box-shadow: 0 0 0 4px rgba(57, 169, 0, 0.18);
        }

        .btn-filter-search {
            background-color: var(--sena-green);
            color: #ffffff;
            font-weight: 700;
            height: 46px;
            border-radius: 12px;
            padding: 0 24px;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(57, 169, 0, 0.25);
            transition: all 0.25s ease;
        }

        .btn-filter-search:hover {
            background-color: var(--sena-green-dark);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(57, 169, 0, 0.35);
        }

        .table-custom-docs {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-custom-docs thead th {
            background-color: #fafbfc;
            color: #475569;
            font-weight: 800;
            font-size: 0.78rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            padding: 16px 20px;
            border-bottom: 1.5px solid #e2e8f0;
            white-space: nowrap;
        }

        .table-custom-docs tbody td {
            padding: 18px 20px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            font-size: 0.92rem;
            color: #475569;
            transition: background-color 0.2s ease;
        }

        .table-custom-docs tbody tr:last-child td {
            border-bottom: none;
        }

        .table-custom-docs tbody tr:hover td {
            background-color: #f0fdf4 !important;
        }

        .btn-action-icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1.2px solid #e2e8f0;
            background-color: #ffffff;
            color: #64748b;
            transition: all 0.2s ease;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-action-icon:hover {
            background-color: #dcfce7;
            color: #166534;
            border-color: #86efac;
            transform: scale(1.08);
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.2);
        }

        .pagination-sena-pill {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.88rem;
            font-weight: 700;
            color: #334155;
            background: #f8fafc;
            border: 1.2px solid #e2e8f0;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            user-select: none;
        }

        .pagination-sena-pill.active {
            background-color: #22c55e !important;
            color: #ffffff !important;
            border-color: #22c55e !important;
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.35);
        }

        .pagination-sena-pill:hover:not(.active) {
            background-color: #e2e8f0;
            color: #0f172a;
        }

        /* Roles del Sistema Cards con Iluminación Verde Intensa */
        .role-system-card {
            background: #ffffff;
            border-radius: 22px;
            padding: 36px 28px;
            border: 1.5px solid #e8edf2;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            height: 100%;
            transition: all 0.32s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .role-system-card:hover {
            transform: translateY(-8px) scale(1.02);
            border-color: #22c55e !important;
            box-shadow: 0 20px 42px rgba(34, 197, 94, 0.28), 0 0 32px rgba(57, 169, 0, 0.45) !important;
        }

        .role-system-card:hover .role-icon-box {
            background: linear-gradient(135deg, #39A900 0%, #22c55e 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 0 25px rgba(34, 197, 94, 0.6) !important;
            transform: scale(1.1);
        }

        .role-system-card:hover h4 {
            color: var(--sena-green) !important;
        }

        .role-icon-box {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            background-color: #eefbf1;
            color: var(--sena-green);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 22px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* Call To Action Dark Green Gradient Banner - Separado y Más Abajo */
        .cta-darkgreen-banner {
            background: linear-gradient(180deg, #01471d 0%, #003615 100%);
            color: #ffffff;
            padding: 95px 24px;
            text-align: center;
            position: relative;
            box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.05);
        }

        .btn-cta-yellow {
            background-color: #facc15;
            color: #0f172a !important;
            font-weight: 800;
            font-size: 1rem;
            padding: 14px 36px;
            border-radius: 12px;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
            transition: all 0.25s ease;
        }

        .btn-cta-yellow:hover {
            background-color: #eab308;
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.35);
        }

        /* Dark Modern Footer */
        .footer-sgc-dark {
            background-color: #121212;
            color: #9ca3af;
            padding-top: 60px;
            padding-bottom: 30px;
        }

        .footer-sgc-dark h5 {
            color: #ffffff;
            font-weight: 800;
            font-size: 1.4rem;
            margin-bottom: 14px;
        }

        .footer-author-tag {
            color: #eab308;
            font-weight: 800;
            font-size: 0.78rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .footer-divider {
            border-color: rgba(255, 255, 255, 0.1);
            margin: 35px 0 25px 0;
        }

        /* ==========================================================================
           ANIMACIONES INTERACTIVAS Y EFECTOS DE ENTRADA AL SCROLL (WOW EFFECTS)
           ========================================================================== */
        
        /* Animaciones iniciales de carga para el Hero */
        @keyframes heroSlideInLeft {
            0% {
                opacity: 0;
                transform: translate3d(-70px, 0, 0);
            }
            100% {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        @keyframes heroSlideInRight {
            0% {
                opacity: 0;
                transform: translate3d(70px, 0, 0);
            }
            100% {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        @keyframes heroItemCascade {
            0% {
                opacity: 0;
                transform: translate3d(0, 25px, 0);
            }
            100% {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        .anim-hero-left {
            animation: heroSlideInLeft 0.95s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .anim-hero-right {
            animation: heroSlideInRight 1.05s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .anim-hero-card-1 { animation: heroItemCascade 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.2s forwards; opacity: 0; }
        .anim-hero-card-2 { animation: heroItemCascade 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.35s forwards; opacity: 0; }
        .anim-hero-card-3 { animation: heroItemCascade 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.5s forwards; opacity: 0; }
        .anim-hero-card-4 { animation: heroItemCascade 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.65s forwards; opacity: 0; }

        /* Clases de Revelado al Scroll (Scroll Reveal Observer) */
        .reveal-from-left {
            opacity: 0;
            transform: translate3d(-60px, 0, 0);
            will-change: transform, opacity;
            transition: opacity 0.85s cubic-bezier(0.16, 1, 0.3, 1), transform 0.85s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .reveal-from-right {
            opacity: 0;
            transform: translate3d(60px, 0, 0);
            will-change: transform, opacity;
            transition: opacity 0.85s cubic-bezier(0.16, 1, 0.3, 1), transform 0.85s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .reveal-from-bottom {
            opacity: 0;
            transform: translate3d(0, 45px, 0);
            will-change: transform, opacity;
            transition: opacity 0.85s cubic-bezier(0.16, 1, 0.3, 1), transform 0.85s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .reveal-scale-up {
            opacity: 0;
            transform: scale(0.93) translate3d(0, 30px, 0);
            will-change: transform, opacity;
            transition: opacity 0.9s cubic-bezier(0.16, 1, 0.3, 1), transform 0.9s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* Estado Activo cuando el elemento entra en pantalla */
        .is-revealed {
            opacity: 1 !important;
            transform: translate3d(0, 0, 0) scale(1) !important;
        }

        /* Escalonamiento (Stagger) para tarjetas */
        .stagger-delay-1 { transition-delay: 0.1s !important; }
        .stagger-delay-2 { transition-delay: 0.2s !important; }
        .stagger-delay-3 { transition-delay: 0.3s !important; }
        .stagger-delay-4 { transition-delay: 0.4s !important; }
        .stagger-delay-5 { transition-delay: 0.5s !important; }
        .stagger-delay-6 { transition-delay: 0.6s !important; }
    </style>
</head>

<body>

    <!-- ======= NAVBAR INSTITUCIONAL SGC ======= -->
    <nav class="navbar navbar-expand-xl bg-white border-bottom shadow-sm sticky-top py-2">
        <div class="container-fluid px-3 px-xl-5" style="max-width: 1380px;">
            <!-- Brand Logo SENA & SGC -->
            <a class="navbar-brand d-flex align-items-center gap-3 text-decoration-none me-0" href="{{ url('/sgc') }}">
                <img src="{{ asset('modules/sgc/img/Logo.png') }}" alt="Logo SENA" style="height: 38px; width: auto; object-fit: contain;">
                <div class="d-none d-sm-block border-end" style="height: 26px;"></div>
                <div class="d-flex flex-column justify-content-center">
                    <div class="d-flex align-items-center gap-2 lh-1">
                        <span class="fw-bold text-dark fs-5 font-heading">SGC</span>
                        <span class="fw-bold text-success" style="font-size: 13px;">• SENA EMPRESA</span>
                    </div>
                    <small class="text-muted mt-1" style="font-size: 11px;">Gestión de Calidad • CFA La Angostura</small>
                </div>
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler border-0 shadow-none p-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSGC">
                <i class="fas fa-bars-staggered text-dark fs-5"></i>
            </button>

            <!-- Navbar Collapse Content -->
            <div class="collapse navbar-collapse" id="navbarSGC">
                <!-- Center Navigation Hub -->
                <div class="mx-auto my-2 my-xl-0 d-flex justify-content-center">
                    <div class="bg-light border rounded-pill p-1 shadow-sm d-inline-flex align-items-center gap-1">
                        <a class="nav-link fw-bold text-dark rounded-pill px-3 py-1 d-inline-flex align-items-center gap-2 text-nowrap" href="#inicio">
                            <i class="fas fa-house-chimney text-success"></i>
                            <span>Inicio</span>
                        </a>
                        <a class="nav-link fw-semibold text-secondary rounded-pill px-3 py-1 d-inline-flex align-items-center gap-2 text-nowrap" href="#funcionalidades">
                            <i class="fas fa-layer-group text-success"></i>
                            <span>Funcionalidades</span>
                        </a>
                        <a class="nav-link fw-semibold text-secondary rounded-pill px-3 py-1 d-inline-flex align-items-center gap-2 text-nowrap" href="#listado-maestro">
                            <i class="fas fa-book-bookmark text-success"></i>
                            <span>Listado Maestro</span>
                        </a>
                        <a class="nav-link fw-semibold text-secondary rounded-pill px-3 py-1 d-inline-flex align-items-center gap-2 text-nowrap" href="#roles">
                            <i class="fas fa-users-gear text-success"></i>
                            <span>Roles</span>
                        </a>
                    </div>
                </div>

                <!-- Right Action Zone -->
                <div class="d-flex align-items-center justify-content-center justify-content-xl-end gap-2 pt-2 pt-xl-0">
                    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3" title="Volver al Portal ERP">
                        <i class="fas fa-arrow-left me-1"></i> Portal ERP
                    </a>

                    @auth
                        <div class="dropdown">
                            <button class="btn btn-sm btn-success text-white rounded-pill px-3 dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" style="background-color: var(--sena-green); border: none;">
                                <i class="fas fa-user-circle"></i>
                                <span>{{ Auth::user()->full_name }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 p-2 mt-2">
                                <li>
                                    <div class="px-3 py-2 bg-light rounded-2 mb-2">
                                        <small class="text-muted d-block" style="font-size: 11px;">Rol asignado:</small>
                                        <strong class="text-dark fs-7">{{ Auth::user()->primary_role ?? 'Usuario SGC' }}</strong>
                                    </div>
                                </li>
                                <li><a class="dropdown-item fw-semibold rounded-2 py-2" href="{{ route('sgc.dashboard') }}"><i class="fas fa-gauge-high me-2 text-success"></i> Mi Dashboard</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger fw-semibold rounded-2 py-2" href="{{ route('logout') }}"><i class="fas fa-arrow-right-from-bracket me-2"></i> Salir</a></li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login', ['redirect' => '/sgc']) }}" class="btn btn-sm btn-success text-white rounded-pill px-3 shadow-sm" style="background-color: var(--sena-green); border: none;">
                            <i class="fas fa-right-to-bracket me-1"></i> Iniciar Sesión
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- ======= MAIN CONTENT ======= -->
    <main>

        <!-- ======= SECCIÓN 1: INICIO (HERO SECTION) ======= -->
        <section id="inicio" class="py-5 overflow-hidden" style="background: linear-gradient(180deg, #f7fcf8 0%, #ffffff 100%);">
            <div class="section-sgc-container py-lg-4">
                <div class="row align-items-center g-5">
                    
                    <!-- Left Column: Title & Text (Slide-in-Left) -->
                    <div class="col-lg-6 text-center text-lg-start anim-hero-left">
                        <!-- Oficial Badge Pill -->
                        <div class="mb-4">
                            <span class="pill-oficial">
                                <i class="fas fa-circle" style="font-size: 7px; color: var(--sena-green);"></i>
                                PLATAFORMA OFICIAL DE DOCUMENTACIÓN DE CALIDAD
                            </span>
                        </div>

                        <!-- Main Heading with Translucent Effect -->
                        <h1 class="hero-title-main mb-4">
                            <span class="hero-translucent-text">Toda la documentación de calidad de</span> 
                            <span class="text-sena-green-translucent">SENA Empresa</span> 
                            <span class="hero-translucent-text">en un solo lugar</span>
                        </h1>

                        <!-- Subtitle -->
                        <p class="fs-6 text-secondary mb-4 pb-2 leading-relaxed" style="max-width: 540px; font-weight: 400; color: #475569 !important;">
                            Bienvenido al Sistema de Gestión de Calidad (SGC) del Centro de Formación Agroindustrial La Angostura. Centralizamos, controlamos y agilizamos el ciclo de vida de los documentos oficiales para aprendices, instructores y líderes de área.
                        </p>

                        <!-- Action Buttons -->
                        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start gap-3">
                            @auth
                                <a href="{{ route('sgc.dashboard') }}" class="btn-sena-cta-primary">
                                    <span>Ir al Dashboard</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            @else
                                <a href="{{ route('login', ['redirect' => '/sgc']) }}" class="btn-sena-cta-primary">
                                    <span>Iniciar Sesión</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            @endauth

                            <a href="#listado-maestro" class="btn-sena-cta-outline">
                                Explorar Documentos Públicos
                            </a>
                        </div>
                    </div>

                    <!-- Right Column: Hero Visual Mint Canvas with Active Documents (Slide-in-Right) -->
                    <div class="col-lg-6 anim-hero-right">
                        <div class="hero-mint-canvas shadow-sm">
                            
                            <!-- Header Bar inside Mint Canvas -->
                            <div class="d-flex align-items-center justify-content-between mb-3 px-1">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-white text-success shadow-sm rounded-pill px-3 py-1 font-heading fw-bold" style="font-size: 11px; border: 1px solid #bbf7d0;">
                                        <i class="fas fa-certificate text-success me-1"></i> Documentos Vigentes Oficiales
                                    </span>
                                </div>
                                <span class="badge bg-success text-white rounded-pill px-2 py-1" style="font-size: 11px; background-color: var(--sena-green) !important;">
                                    4 Activos
                                </span>
                            </div>

                            <!-- Scrollable Container of Active Documents -->
                            <div class="hero-docs-scroll">
                                
                                <!-- Document 1: Guía de Aprendizaje -->
                                <div class="hero-floating-card anim-hero-card-1" onclick="document.getElementById('listado-maestro').scrollIntoView({behavior: 'smooth'})" title="Ver en Listado Maestro">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="far fa-file-lines text-success fs-5"></i>
                                            <span class="fw-bold text-dark font-heading" style="font-size: 0.95rem;">Guía de Aprendizaje - Agro</span>
                                        </div>
                                        <span class="status-chip status-chip-vigente">VIGENTE</span>
                                    </div>
                                    <div class="border-top pt-2 d-flex align-items-center justify-content-between text-muted" style="font-size: 11px;">
                                        <span>Código: MC-GA-032</span>
                                        <span>Versión: 4.0</span>
                                        <span>Líder: Calidad</span>
                                    </div>
                                </div>

                                <!-- Document 2: Manual de Calidad y BPM -->
                                <div class="hero-floating-card anim-hero-card-2" onclick="document.getElementById('listado-maestro').scrollIntoView({behavior: 'smooth'})" title="Ver en Listado Maestro">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="far fa-file-lines text-success fs-5"></i>
                                            <span class="fw-bold text-dark font-heading" style="font-size: 0.95rem;">Manual de Calidad y BPM</span>
                                        </div>
                                        <span class="status-chip status-chip-vigente">VIGENTE</span>
                                    </div>
                                    <div class="border-top pt-2 d-flex align-items-center justify-content-between text-muted" style="font-size: 11px;">
                                        <span>Código: SGC-MN-01</span>
                                        <span>Versión: 2.1</span>
                                        <span>Líder: Agroindustria</span>
                                    </div>
                                </div>

                                <!-- Document 3: Procedimiento de Desinfección -->
                                <div class="hero-floating-card anim-hero-card-3" onclick="document.getElementById('listado-maestro').scrollIntoView({behavior: 'smooth'})" title="Ver en Listado Maestro">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="far fa-file-lines text-success fs-5"></i>
                                            <span class="fw-bold text-dark font-heading" style="font-size: 0.95rem;">Procedimiento de Desinfección Lácteos</span>
                                        </div>
                                        <span class="status-chip status-chip-vigente">VIGENTE</span>
                                    </div>
                                    <div class="border-top pt-2 d-flex align-items-center justify-content-between text-muted" style="font-size: 11px;">
                                        <span>Código: SGC-PR-02</span>
                                        <span>Versión: 2.0</span>
                                        <span>Líder: Pecuaria</span>
                                    </div>
                                </div>

                                <!-- Document 4: Formato de Control en Cosecha -->
                                <div class="hero-floating-card anim-hero-card-4" onclick="document.getElementById('listado-maestro').scrollIntoView({behavior: 'smooth'})" title="Ver en Listado Maestro">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="far fa-file-lines text-success fs-5"></i>
                                            <span class="fw-bold text-dark font-heading" style="font-size: 0.95rem;">Formato de Control en Cosecha</span>
                                        </div>
                                        <span class="status-chip status-chip-vigente">VIGENTE</span>
                                    </div>
                                    <div class="border-top pt-2 d-flex align-items-center justify-content-between text-muted" style="font-size: 11px;">
                                        <span>Código: SGC-FT-04</span>
                                        <span>Versión: 1.3</span>
                                        <span>Líder: Agrícola</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ======= SECCIÓN 2: FUNCIONALIDADES CLAVE (IMAGE 1) ======= -->
        <section id="funcionalidades" class="py-sgc bg-white overflow-hidden">
            <div class="section-sgc-container">
                
                <!-- Centered Header -->
                <div class="text-center mb-5 pb-2 reveal-from-bottom">
                    <span class="pill-section-tag mb-3">SISTEMA INTELIGENTE</span>
                    <h2 class="display-6 fw-bold font-heading text-dark mb-2" style="font-size: clamp(2rem, 3.5vw, 2.5rem);">
                        Funcionalidades Clave
                    </h2>
                    <p class="text-muted fs-6 mx-auto mb-0" style="max-width: 650px;">
                        Herramientas innovadoras diseñadas para el control total de la calidad en nuestra sede agroindustrial
                    </p>
                </div>

                <!-- 6 Cards Grid (3 columns x 2 rows) -->
                <div class="row g-4">
                    <!-- Card 1: Carga de Documentos -->
                    <div class="col-lg-4 col-md-6 col-12 reveal-from-left stagger-delay-1">
                        <div class="func-card-item">
                            <div class="func-icon-square">
                                <i class="bi bi-cloud-arrow-up"></i>
                            </div>
                            <h4 class="fw-bold font-heading fs-5 text-dark mb-2">Carga de Documentos</h4>
                            <p class="text-muted fs-7 mb-0 leading-relaxed">
                                Registro con metadatos completos y clasificación precisa por proceso.
                            </p>
                        </div>
                    </div>

                    <!-- Card 2: Control de Versiones -->
                    <div class="col-lg-4 col-md-6 col-12 reveal-from-bottom stagger-delay-2">
                        <div class="func-card-item">
                            <div class="func-icon-square">
                                <i class="bi bi-bezier2"></i>
                            </div>
                            <h4 class="fw-bold font-heading fs-5 text-dark mb-2">Control de Versiones</h4>
                            <p class="text-muted fs-7 mb-0 leading-relaxed">
                                Historial completo con versión vigente única garantizada en tiempo real.
                            </p>
                        </div>
                    </div>

                    <!-- Card 3: Flujo de Aprobación -->
                    <div class="col-lg-4 col-md-6 col-12 reveal-from-right stagger-delay-3">
                        <div class="func-card-item">
                            <div class="func-icon-square">
                                <i class="bi bi-list-check"></i>
                            </div>
                            <h4 class="fw-bold font-heading fs-5 text-dark mb-2">Flujo de Aprobación</h4>
                            <p class="text-muted fs-7 mb-0 leading-relaxed">
                                Ciclo de vida estructurado: Borrador &rarr; En Revisión &rarr; Vigente &rarr; Obsoleto.
                            </p>
                        </div>
                    </div>

                    <!-- Card 4: Listado Maestro -->
                    <div class="col-lg-4 col-md-6 col-12 reveal-from-left stagger-delay-4">
                        <div class="func-card-item">
                            <div class="func-icon-square">
                                <i class="bi bi-list-task"></i>
                            </div>
                            <h4 class="fw-bold font-heading fs-5 text-dark mb-2">Listado Maestro</h4>
                            <p class="text-muted fs-7 mb-0 leading-relaxed">
                                Publicación automática organizada por proceso institucional del SENA.
                            </p>
                        </div>
                    </div>

                    <!-- Card 5: Acceso por Roles -->
                    <div class="col-lg-4 col-md-6 col-12 reveal-from-bottom stagger-delay-5">
                        <div class="func-card-item">
                            <div class="func-icon-square">
                                <i class="bi bi-person-lock"></i>
                            </div>
                            <h4 class="fw-bold font-heading fs-5 text-dark mb-2">Acceso por Roles</h4>
                            <p class="text-muted fs-7 mb-0 leading-relaxed">
                                Permisos diferenciados y seguridad estricta para cada tipo de usuario.
                            </p>
                        </div>
                    </div>

                    <!-- Card 6: Reportes y Trazabilidad -->
                    <div class="col-lg-4 col-md-6 col-12 reveal-from-right stagger-delay-6">
                        <div class="func-card-item">
                            <div class="func-icon-square">
                                <i class="bi bi-bar-chart-line"></i>
                            </div>
                            <h4 class="fw-bold font-heading fs-5 text-dark mb-2">Reportes y Trazabilidad</h4>
                            <p class="text-muted fs-7 mb-0 leading-relaxed">
                                Seguimiento completo e inalterable de toda actividad documental.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- ======= SECCIÓN 3: LISTADO MAESTRO DE DOCUMENTOS (IMAGE 2) ======= -->
        <section id="listado-maestro" class="py-sgc overflow-hidden" style="background-color: #f8faf8;">
            <div class="section-sgc-container">
                
                <!-- Centered Header -->
                <div class="text-center mb-5 pb-2 reveal-from-bottom">
                    <span class="pill-section-tag mb-3">CONSULTA EN LÍNEA</span>
                    <h2 class="display-6 fw-bold font-heading text-dark mb-2" style="font-size: clamp(2rem, 3.5vw, 2.5rem);">
                        Listado Maestro
                    </h2>
                    <p class="text-muted fs-6 mx-auto mb-0" style="max-width: 680px;">
                        Consulta y descarga de documentos vigentes del Sistema de Gestión de Calidad del Centro Agroindustrial
                    </p>
                </div>

                <!-- Table Card Container -->
                <div class="table-docs-container reveal-scale-up">
                    
                    <!-- Search & Filter Controls Bar -->
                    <div class="row g-3 mb-4 align-items-center">
                        <div class="col-lg-5 col-md-12">
                            <div class="filter-search-box">
                                <i class="fas fa-magnifying-glass"></i>
                                <input type="text" id="filterSearchInput" class="form-control" placeholder="Buscar documento..." onkeyup="filterDocsTable()">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-5">
                            <select id="filterProcessSelect" class="form-select filter-select" onchange="filterDocsTable()">
                                <option value="TODOS">Todos los procesos</option>
                                @if(isset($procesos) && $procesos->count() > 0)
                                    @foreach($procesos as $proc)
                                        <option value="{{ $proc->nombre }}">{{ $proc->nombre }}</option>
                                    @endforeach
                                @else
                                    <option value="Gestión Estratégica">Gestión Estratégica</option>
                                    <option value="Evaluación y Control">Evaluación y Control</option>
                                    <option value="Gestión Documental">Gestión Documental</option>
                                    <option value="Mejora Continua">Mejora Continua</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-4">
                            <select id="filterStateSelect" class="form-select filter-select" onchange="filterDocsTable()">
                                <option value="TODOS">Estado: Todos</option>
                                <option value="Vigente" selected>Vigente</option>
                                <option value="En Revisión">En Revisión</option>
                                <option value="Borrador">Borrador</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <button class="btn-filter-search w-100" onclick="filterDocsTable()">
                                <i class="fas fa-magnifying-glass"></i>
                                <span>Buscar</span>
                            </button>
                        </div>
                    </div>

                    <!-- Clean Responsive Table -->
                    <div class="table-responsive">
                        <table class="table-custom-docs" id="mainDocsTable">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Nombre del Documento</th>
                                    <th>Proceso</th>
                                    <th>Versión</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($documentosVigentes) && $documentosVigentes->count() > 0)
                                    @foreach($documentosVigentes as $doc)
                                        @php
                                            $verNum = $doc->versionActual->numero_version ?? '1.0';
                                            $procNombre = $doc->proceso->nombre ?? 'General';
                                            $docFecha = $doc->fecha_publicacion ? $doc->fecha_publicacion->format('Y-m-d') : ($doc->fecha_elaboracion ? $doc->fecha_elaboracion->format('Y-m-d') : date('Y-m-d'));
                                            $estadoUpper = strtoupper($doc->estado);
                                        @endphp
                                        <tr class="doc-row-item" data-code="{{ $doc->codigo }}" data-name="{{ $doc->nombre }}" data-process="{{ $procNombre }}" data-state="{{ ucfirst($doc->estado) }}">
                                            <td><span class="doc-code-highlight">{{ $doc->codigo }}</span></td>
                                            <td><strong class="text-dark">{{ $doc->nombre }}</strong></td>
                                            <td>{{ $procNombre }}</td>
                                            <td>v{{ $verNum }}</td>
                                            <td><span class="status-chip status-chip-vigente">{{ $estadoUpper }}</span></td>
                                            <td>{{ $docFecha }}</td>
                                            <td class="text-end">
                                                <div class="d-inline-flex gap-2">
                                                    <button class="btn-action-icon" onclick="openDocPreview('{{ $doc->codigo }}', '{{ addslashes($doc->nombre) }}', '{{ addslashes($procNombre) }}', 'v{{ $verNum }}', 'Vigente', '{{ route('sgc.documentos.download', $doc->id) }}')" title="Ver detalles"><i class="far fa-eye"></i></button>
                                                    <a href="{{ route('sgc.documentos.download', $doc->id) }}" class="btn-action-icon d-inline-flex align-items-center justify-content-center text-decoration-none" title="Descargar documento oficial"><i class="fas fa-download text-success"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <!-- Documentos Representativos Iniciales -->
                                    <tr class="doc-row-item" data-code="SGC-DOC-001" data-name="Manual de Calidad" data-process="Gestión Estratégica" data-state="Vigente">
                                        <td><span class="doc-code-highlight">SGC-DOC-001</span></td>
                                        <td><strong class="text-dark">Manual de Calidad</strong></td>
                                        <td>Gestión Estratégica</td>
                                        <td>v3.2</td>
                                        <td><span class="status-chip status-chip-vigente">VIGENTE</span></td>
                                        <td>2026-08-15</td>
                                        <td class="text-end">
                                            <div class="d-inline-flex gap-2">
                                                <button class="btn-action-icon" onclick="openDocPreview('SGC-DOC-001', 'Manual de Calidad', 'Gestión Estratégica', 'v3.2', 'Vigente')" title="Ver detalles"><i class="far fa-eye"></i></button>
                                                <button class="btn-action-icon" onclick="alert('Descargando documento')" title="Descargar documento"><i class="fas fa-download text-success"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Table Pagination and Counter Bar -->
                    <div class="d-flex flex-wrap align-items-center justify-content-between pt-4 mt-2 border-top gap-3">
                        <span class="text-muted fs-7" id="docCountLabel">Mostrando documentos</span>
                        <div class="d-flex align-items-center gap-1" id="welcomeDocPagination">
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- ======= SECCIÓN 4: ROLES DEL SISTEMA (IMAGE 3 TOP) ======= -->
        <section id="roles" class="py-sgc bg-white overflow-hidden">
            <div class="section-sgc-container">
                
                <!-- Centered Header -->
                <div class="text-center mb-5 pb-2 reveal-from-bottom">
                    <span class="pill-section-tag mb-3">PERFILES ACCESIBLES</span>
                    <h2 class="display-6 fw-bold font-heading text-dark mb-2" style="font-size: clamp(2rem, 3.5vw, 2.5rem);">
                        Roles del Sistema
                    </h2>
                    <p class="text-muted fs-6 mx-auto mb-0" style="max-width: 650px;">
                        Estructura jerárquica robusta para asegurar la integridad de la información institucional
                    </p>
                </div>

                <!-- 4 Roles Grid (4 columns: col-xl-3 col-md-6 col-12) -->
                <div class="row g-4">
                    <!-- Role 1: Administrador (Slide-in-Left) -->
                    <div class="col-xl-3 col-md-6 col-12 reveal-from-left stagger-delay-1">
                        <div class="role-system-card">
                            <div class="role-icon-box">
                                <i class="bi bi-person-gear"></i>
                            </div>
                            <h4 class="fw-bold font-heading fs-5 text-dark mb-2">Administrador</h4>
                            <p class="text-muted fs-7 mb-0 leading-relaxed">
                                Control total de la plataforma, configuración global del sistema y asignación de permisos generales.
                            </p>
                        </div>
                    </div>

                    <!-- Role 2: Responsable de Calidad (Slide-in-Bottom) -->
                    <div class="col-xl-3 col-md-6 col-12 reveal-from-bottom stagger-delay-2">
                        <div class="role-system-card">
                            <div class="role-icon-box">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <h4 class="fw-bold font-heading fs-5 text-dark mb-2">Responsable de Calidad</h4>
                            <p class="text-muted fs-7 mb-0 leading-relaxed">
                                Aprobación oficial de documentos, supervisión integral del SGC y trazabilidad periódicas.
                            </p>
                        </div>
                    </div>

                    <!-- Role 3: Líder de Área (Slide-in-Bottom) -->
                    <div class="col-xl-3 col-md-6 col-12 reveal-from-bottom stagger-delay-3">
                        <div class="role-system-card">
                            <div class="role-icon-box">
                                <i class="bi bi-people"></i>
                            </div>
                            <h4 class="fw-bold font-heading fs-5 text-dark mb-2">Líder de Área</h4>
                            <p class="text-muted fs-7 mb-0 leading-relaxed">
                                Creación, actualización y administración de los documentos correspondientes a su proceso.
                            </p>
                        </div>
                    </div>

                    <!-- Role 4: Aprendiz / Instructor (Slide-in-Right) -->
                    <div class="col-xl-3 col-md-6 col-12 reveal-from-right stagger-delay-4">
                        <div class="role-system-card">
                            <div class="role-icon-box">
                                <i class="bi bi-book"></i>
                            </div>
                            <h4 class="fw-bold font-heading fs-5 text-dark mb-2">Aprendiz / Instructor</h4>
                            <p class="text-muted fs-7 mb-0 leading-relaxed">
                                Consulta libre, visualización y descarga directa de documentos vigentes para su formación.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- ======= SECCIÓN 5: CALL TO ACTION BANNER (IMAGE 3 BOTTOM) ======= -->
        <section class="cta-darkgreen-banner reveal-scale-up">
            <div class="section-sgc-container">
                <h2 class="display-5 fw-bold font-heading text-white mb-3" style="font-size: clamp(2rem, 3.5vw, 2.7rem);">
                    ¿Listo para gestionar la calidad?
                </h2>
                <p class="fs-5 mx-auto mb-4 pb-2" style="max-width: 650px; color: #dcfce7; font-weight: 400;">
                    Accede al sistema y consulta los documentos de tu proceso de manera ágil y centralizada.
                </p>
                <div>
                    @auth
                        <a href="{{ route('sgc.dashboard') }}" class="btn-cta-yellow">
                            <i class="fas fa-gauge-high me-1"></i>
                            <span>Ir a mi Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('login', ['redirect' => '/sgc']) }}" class="btn-cta-yellow">
                            <i class="fas fa-user-lock me-1"></i>
                            <span>Iniciar Sesión ahora</span>
                        </a>
                    @endauth
                </div>
            </div>
        </section>

    </main>

    <!-- ======= FOOTER INSTITUCIONAL DARK ======= -->
    <footer class="footer-sgc-dark reveal-from-bottom">
        <div class="section-sgc-container">
            <div class="row align-items-start justify-content-between g-4">
                <!-- Left Column -->
                <div class="col-lg-6">
                    <h5 class="font-heading">SGC SENA</h5>
                    <p class="mb-1 text-white-50" style="font-size: 0.9rem;">Servicio Nacional de Aprendizaje - SENA</p>
                    <p class="mb-1 text-white-50" style="font-size: 0.9rem;">Centro de Formación Agroindustrial La Angostura</p>
                    <p class="mb-0 text-white-50" style="font-size: 0.9rem;">Regional Huila, Colombia.</p>
                </div>

                <!-- Right Column: Autores -->
                <div class="col-lg-6 text-lg-end">
                    <div class="footer-author-tag">DESARROLLADO POR:</div>
                    <p class="mb-0 text-white-50" style="font-size: 0.88rem; max-width: 480px; margin-left: auto;">
                        Andrés Felipe Montes Avirama y Cristian Alejandro Suaza Ruiz — Tecnólogo en ADSO, Ficha 3288036
                    </p>
                </div>
            </div>

            <hr class="footer-divider">

            <!-- Subfooter bottom bar -->
            <div class="d-flex flex-wrap justify-content-between align-items-center text-white-50" style="font-size: 0.8rem;">
                <span>&copy; {{ date('Y') }} Servicio Nacional de Aprendizaje - SENA. Todos los derechos reservados.</span>
                <span>Ficha ADSO 3288036 &nbsp;&bull;&nbsp; Huila, Colombia</span>
            </div>
        </div>
    </footer>

    <!-- ======= MODAL: PREVISUALIZACIÓN DE DOCUMENTO ======= -->
    <div class="modal fade" id="modalDocPreview" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
                <div class="modal-header text-white py-3 px-4" style="background: linear-gradient(135deg, var(--sena-green-dark) 0%, var(--sena-green) 100%);">
                    <div class="d-flex align-items-center gap-2">
                        <i class="far fa-file-lines fs-4"></i>
                        <div>
                            <h6 class="modal-title fw-bold font-heading mb-0" id="modalPreviewTitle">Detalle de Documento</h6>
                            <small class="text-white-75" id="modalPreviewCode">SGC-DOC</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 bg-light">
                    <div class="card border-0 rounded-3 p-3 bg-white mb-3 shadow-sm">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted fs-8">Proceso:</span>
                            <strong class="text-dark fs-8" id="modalPreviewProcess">Gestión Estratégica</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted fs-8">Versión:</span>
                            <strong class="text-dark fs-8" id="modalPreviewVersion">v1.0</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted fs-8">Estado Actual:</span>
                            <span id="modalPreviewStateBadge" class="status-chip status-chip-vigente">Vigente</span>
                        </div>
                    </div>
                    <div class="alert alert-success bg-success bg-opacity-10 border-0 rounded-3 p-3 mb-0 fs-8 text-dark">
                        <i class="fas fa-circle-check text-success me-1"></i> Documento oficial homologado por el Sistema de Gestión de Calidad (ISO 9001:2015).
                    </div>
                </div>
                <div class="modal-footer bg-white py-2">
                    <button type="button" class="btn btn-sm btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cerrar</button>
                    <a id="modalPreviewDownloadBtn" href="#" class="btn btn-sm btn-success text-white rounded-pill px-4" style="background-color: var(--sena-green);"><i class="fas fa-download me-1"></i> Descargar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://sicefa.com.co/general/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Client Scripts for Table Filters, Modal Preview & Scroll Reveal -->
    <script>
        // =========================================================================
        // MOTOR DE ANIMACIONES INTERACTIVAS AL SCROLL (INTERSECTION OBSERVER)
        // =========================================================================
        document.addEventListener('DOMContentLoaded', function () {
            const revealElements = document.querySelectorAll(
                '.reveal-from-left, .reveal-from-right, .reveal-from-bottom, .reveal-scale-up'
            );

            if ('IntersectionObserver' in window) {
                const revealObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-revealed');
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    root: null,
                    threshold: 0.1,
                    rootMargin: '0px 0px -40px 0px'
                });

                revealElements.forEach(el => revealObserver.observe(el));
            } else {
                // Fallback para navegadores antiguos
                revealElements.forEach(el => el.classList.add('is-revealed'));
            }

            // Inicializar contador
            filterDocsTable();
        });

        let currentWelcomePage = 1;
        const welcomePageSize = 8;

        function filterDocsTable(page = 1) {
            currentWelcomePage = page;
            const searchVal = document.getElementById('filterSearchInput').value.toLowerCase().trim();
            const processVal = document.getElementById('filterProcessSelect').value;
            const stateVal = document.getElementById('filterStateSelect').value;
            
            const rows = Array.from(document.querySelectorAll('#mainDocsTable tbody tr'));
            const matchingRows = [];

            rows.forEach(row => {
                const code = (row.getAttribute('data-code') || '').toLowerCase();
                const name = (row.getAttribute('data-name') || '').toLowerCase();
                const process = row.getAttribute('data-process') || '';
                const state = row.getAttribute('data-state') || '';

                const matchesSearch = !searchVal || code.includes(searchVal) || name.includes(searchVal);
                const matchesProcess = processVal === 'TODOS' || process === processVal;
                const matchesState = stateVal === 'TODOS' || state.toLowerCase() === stateVal.toLowerCase();

                if (matchesSearch && matchesProcess && matchesState) {
                    matchingRows.push(row);
                } else {
                    row.style.display = 'none';
                }
            });

            const totalMatches = matchingRows.length;
            const totalPages = Math.ceil(totalMatches / welcomePageSize) || 1;
            if (currentWelcomePage > totalPages) currentWelcomePage = totalPages;

            const startIdx = (currentWelcomePage - 1) * welcomePageSize;
            const endIdx = startIdx + welcomePageSize;

            matchingRows.forEach((row, idx) => {
                if (idx >= startIdx && idx < endIdx) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            const countLabel = document.getElementById('docCountLabel');
            if (countLabel) {
                const showingStart = totalMatches === 0 ? 0 : startIdx + 1;
                const showingEnd = Math.min(endIdx, totalMatches);
                countLabel.textContent = `Mostrando ${showingStart}-${showingEnd} de ${totalMatches} documentos`;
            }

            renderWelcomePagination(totalPages, currentWelcomePage);
        }

        function renderWelcomePagination(totalPages, currentPage) {
            const container = document.getElementById('welcomeDocPagination');
            if (!container) return;

            if (totalPages <= 1) {
                container.innerHTML = '';
                return;
            }

            let html = '';

            // Prev Button
            if (currentPage > 1) {
                html += `<button class="pagination-sena-pill" onclick="filterDocsTable(${currentPage - 1})" title="Anterior"><i class="fas fa-chevron-left" style="font-size: 11px;"></i></button>`;
            }

            // Page Buttons
            for (let i = 1; i <= totalPages; i++) {
                if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                    const activeClass = i === currentPage ? 'active' : '';
                    html += `<button class="pagination-sena-pill ${activeClass}" onclick="filterDocsTable(${i})">${i}</button>`;
                } else if (i === currentPage - 2 || i === currentPage + 2) {
                    html += `<span class="text-muted px-1">...</span>`;
                }
            }

            // Next Button
            if (currentPage < totalPages) {
                html += `<button class="pagination-sena-pill" onclick="filterDocsTable(${currentPage + 1})" title="Siguiente"><i class="fas fa-chevron-right" style="font-size: 11px;"></i></button>`;
            }

            container.innerHTML = html;
        }

        function openDocPreview(code, name, process, version, state, downloadUrl) {
            document.getElementById('modalPreviewTitle').textContent = name;
            document.getElementById('modalPreviewCode').textContent = code;
            document.getElementById('modalPreviewProcess').textContent = process;
            document.getElementById('modalPreviewVersion').textContent = version;
            
            const badge = document.getElementById('modalPreviewStateBadge');
            badge.textContent = state;
            badge.className = 'status-chip ' + (state === 'Vigente' ? 'status-chip-vigente' : (state === 'En Revisión' ? 'status-chip-revision' : 'status-chip-borrador'));

            const downloadBtn = document.getElementById('modalPreviewDownloadBtn');
            if (downloadBtn) {
                if (downloadUrl) {
                    downloadBtn.href = downloadUrl;
                    downloadBtn.style.display = 'inline-flex';
                } else {
                    downloadBtn.style.display = 'none';
                }
            }

            const modal = new bootstrap.Modal(document.getElementById('modalDocPreview'));
            modal.show();
        }
    </script>
</body>
</html>
