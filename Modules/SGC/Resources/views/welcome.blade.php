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

        /* ======= ESTILOS DEL MODAL DE DETALLE Y LÍNEA DE TIEMPO (VERDE SUAVE) ======= */
        .modal-tab-btn {
            color: #64748b;
            font-weight: 600;
            font-size: 14px;
            padding: 8px 18px 12px 18px;
            border: none;
            background: transparent;
            position: relative;
            transition: all 0.2s ease;
        }

        .modal-tab-btn.active {
            color: #0f172a !important;
            font-weight: 700 !important;
        }

        .modal-tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: #16a34a;
            border-radius: 3px 3px 0 0;
        }

        .modal-info-card {
            background-color: #f8fafc;
            border: 1px solid #eef2f6;
            border-radius: 12px;
            padding: 14px 16px;
            height: 100%;
            transition: all 0.2s ease;
        }

        .modal-info-card:hover {
            border-color: #dcfce7;
            background-color: #f0fdf4;
        }

        /* Timeline Vertical Exacto del Diseño Institucional */
        .timeline-v-container {
            position: relative;
            padding-left: 6px;
        }

        .timeline-v-container::before {
            content: '';
            position: absolute;
            top: 10px;
            bottom: 24px;
            left: 17px;
            width: 2px;
            background-color: #e2e8f0;
            z-index: 1;
        }

        .timeline-v-item {
            position: relative;
            padding-left: 34px;
            padding-bottom: 24px;
        }

        .timeline-v-item-last {
            padding-bottom: 6px;
        }

        .timeline-v-dot {
            position: absolute;
            width: 14px;
            height: 14px;
            left: 11px;
            top: 4px;
            border-radius: 50%;
            background-color: #22c55e;
            border: 3px solid #ffffff;
            box-shadow: 0 0 0 1.5px #86efac;
            z-index: 2;
        }

        .btn-timeline-download {
            background-color: #ffffff;
            color: #15803d;
            border: 1.2px solid #bbf7d0;
            font-weight: 600;
            font-size: 12.5px;
            padding: 5px 14px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            text-decoration: none;
            transition: all 0.22s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        .btn-timeline-download:hover {
            background-color: #f0fdf4;
            color: #166534;
            border-color: #86efac;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(34, 197, 94, 0.18);
        }
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
                                <span class="badge bg-success text-white rounded-pill px-2.5 py-1" style="font-size: 11px; background-color: var(--sena-green) !important;">
                                    {{ isset($documentosVigentes) ? $documentosVigentes->count() : 0 }} Activos
                                </span>
                            </div>

                            <!-- Scrollable Container of Active Documents -->
                            <div class="hero-docs-scroll">
                                @forelse($documentosVigentes as $idx => $d)
                                    @php
                                        $vNum = $d->versionActual->numero_version ?? '1.0';
                                        $pNom = $d->proceso->nombre ?? 'General';
                                        $liderNom = $d->responsable->nombre_completo ?? ($d->area->nombre ?? 'Calidad');
                                    @endphp
                                    <div class="hero-floating-card anim-hero-card-{{ ($idx % 4) + 1 }}" onclick="openDocFullModal({{ $d->id }})" title="Ver detalle de {{ $d->nombre }}">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <div class="d-flex align-items-center gap-2 text-truncate me-2">
                                                <i class="far fa-file-lines text-success fs-5 flex-shrink-0"></i>
                                                <span class="fw-bold text-dark font-heading text-truncate" style="font-size: 0.95rem;">{{ $d->nombre }}</span>
                                            </div>
                                            <span class="status-chip status-chip-vigente flex-shrink-0">VIGENTE</span>
                                        </div>
                                        <div class="border-top pt-2 d-flex align-items-center justify-content-between text-muted" style="font-size: 11px;">
                                            <span>Código: <strong>{{ $d->codigo }}</strong></span>
                                            <span>Versión: <strong>v{{ $vNum }}</strong></span>
                                            <span class="text-truncate" style="max-width: 120px;">Líder: {{ $liderNom }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-4 text-center text-muted bg-white rounded-4 border">
                                        <i class="fas fa-folder-open fs-3 text-secondary mb-2 d-block"></i>
                                        <span>No hay documentos vigentes publicados aún.</span>
                                    </div>
                                @endforelse
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
                        <div class="col-lg-6 col-md-12">
                            <div class="filter-search-box">
                                <i class="fas fa-magnifying-glass"></i>
                                <input type="text" id="filterSearchInput" class="form-control" placeholder="Buscar por código o nombre de documento..." onkeyup="filterDocsTable()">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-7">
                            <select id="filterProcessSelect" class="form-select filter-select" onchange="filterDocsTable()">
                                <option value="TODOS">Todos los procesos institucionales</option>
                                @if(isset($procesos) && $procesos->count() > 0)
                                    @foreach($procesos as $proc)
                                        <option value="{{ $proc->nombre }}">{{ $proc->nombre }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-5">
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
                                    <th>Fecha Emisión</th>
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
                                        <tr class="doc-row-item" data-code="{{ $doc->codigo }}" data-name="{{ $doc->nombre }}" data-process="{{ $procNombre }}" data-state="Vigente">
                                            <td><span class="doc-code-highlight">{{ $doc->codigo }}</span></td>
                                            <td><strong class="text-dark">{{ $doc->nombre }}</strong></td>
                                            <td>{{ $procNombre }}</td>
                                            <td><span class="badge bg-light text-dark border font-monospace fw-bold px-2 py-0.5">v{{ $verNum }}</span></td>
                                            <td><span class="status-chip status-chip-vigente">VIGENTE</span></td>
                                            <td>{{ $docFecha }}</td>
                                            <td class="text-end">
                                                <div class="d-inline-flex gap-2">
                                                    <button class="btn-action-icon" onclick="openDocFullModal({{ $doc->id }})" title="Ver detalle de versiones y vista previa"><i class="far fa-eye"></i></button>
                                                    <a href="{{ route('sgc.public.documento.pdf', $doc->id) }}" class="btn-action-icon d-inline-flex align-items-center justify-content-center text-decoration-none" title="Descargar PDF oficial ({{ $doc->codigo }}_{{ $doc->nombre }}_v{{ $verNum }}.pdf)"><i class="fas fa-file-pdf text-success"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr id="emptyDocsRow">
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <div class="py-3">
                                                <i class="fas fa-folder-open fs-2 text-secondary opacity-50 mb-2 d-block"></i>
                                                <span class="fw-semibold">No se encontraron documentos vigentes en el Listado Maestro.</span>
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
                                Control total dero que ahora e la plataforma, configuración global del sistema y asignación de permisos generales.
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

    <!-- ======= MODAL: DETALLE DE METADATOS E HISTORIAL DE VERSIONES (VERDE SUAVE) ======= -->
    <div class="modal fade" id="modalDocPreview" tabindex="-1" aria-labelledby="modalDocPreviewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <!-- Modal Header -->
                <div class="modal-header bg-white border-bottom px-4 py-3 d-flex align-items-center justify-content-between" style="border-color: #eef2f6 !important;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 p-2 bg-white border text-secondary shadow-xs d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; border-color: #e2e8f0 !important; background-color: #f8fafc !important;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-file-earmark-text text-dark" viewBox="0 0 16 16">
                                <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5"/>
                                <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
                            </svg>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold text-dark mb-0 fs-6 font-heading" id="modalPreviewDocHeaderTitle">Detalle del Documento</h5>
                            <p class="text-muted small mb-0" id="modalPreviewDocHeaderSubtitle" style="font-size: 12.5px;">Metadatos e historial de versiones</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Subheader: Navigation Tabs (2 Tabs Only) -->
                <div class="bg-white border-bottom px-4 pt-1" style="border-color: #eef2f6 !important;">
                    <ul class="nav nav-tabs border-0" id="modalDocTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="modal-tab-btn active" id="tab-meta-btn" data-bs-toggle="tab" data-bs-target="#tab-meta-pane" type="button" role="tab">
                                Metadatos
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="modal-tab-btn" id="tab-versiones-btn" data-bs-toggle="tab" data-bs-target="#tab-versiones-pane" type="button" role="tab">
                                Historial de Versiones
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Modal Body -->
                <div class="modal-body px-4 py-4" style="background-color: #ffffff; min-height: 380px;">
                    <div class="tab-content" id="modalDocTabsContent">
                        
                        <!-- TAB 1: METADATOS (Diseño con tarjetas suaves) -->
                        <div class="tab-pane fade show active" id="tab-meta-pane" role="tabpanel">
                            <div class="row g-3">
                                <!-- Código -->
                                <div class="col-md-6">
                                    <div class="modal-info-card">
                                        <small class="text-muted d-block fw-semibold mb-1" style="font-size: 11px;">Código</small>
                                        <span class="fw-bold fs-6 font-monospace" style="color: #39A900;" id="modalMetaCodigo">-</span>
                                    </div>
                                </div>
                                <!-- Estado -->
                                <div class="col-md-6">
                                    <div class="modal-info-card">
                                        <small class="text-muted d-block fw-semibold mb-1" style="font-size: 11px;">Estado</small>
                                        <span class="fw-bold fs-6 text-dark" id="modalMetaEstado">VIGENTE</span>
                                    </div>
                                </div>
                                <!-- Nombre del Documento -->
                                <div class="col-12">
                                    <div class="modal-info-card">
                                        <small class="text-muted d-block fw-semibold mb-1" style="font-size: 11px;">Nombre del Documento</small>
                                        <span class="fw-bold text-dark fs-6 font-heading" id="modalMetaNombre">-</span>
                                    </div>
                                </div>
                                <!-- Proceso -->
                                <div class="col-md-6">
                                    <div class="modal-info-card">
                                        <small class="text-muted d-block fw-semibold mb-1" style="font-size: 11px;">Proceso</small>
                                        <span class="fw-bold text-dark" style="font-size: 13.5px;" id="modalMetaProceso">-</span>
                                    </div>
                                </div>
                                <!-- Área -->
                                <div class="col-md-6">
                                    <div class="modal-info-card">
                                        <small class="text-muted d-block fw-semibold mb-1" style="font-size: 11px;">Área</small>
                                        <span class="fw-bold text-dark" style="font-size: 13.5px;" id="modalMetaArea">-</span>
                                    </div>
                                </div>
                                <!-- Tipo Documental -->
                                <div class="col-md-6">
                                    <div class="modal-info-card">
                                        <small class="text-muted d-block fw-semibold mb-1" style="font-size: 11px;">Tipo Documental</small>
                                        <span class="fw-bold text-dark" style="font-size: 13.5px;" id="modalMetaTipo">-</span>
                                    </div>
                                </div>
                                <!-- Funcionario Responsable -->
                                <div class="col-md-6">
                                    <div class="modal-info-card">
                                        <small class="text-muted d-block fw-semibold mb-1" style="font-size: 11px;">Funcionario Responsable</small>
                                        <span class="fw-bold text-dark" style="font-size: 13.5px;" id="modalMetaResponsable">-</span>
                                    </div>
                                </div>
                                <!-- Descripción / Objeto -->
                                <div class="col-12">
                                    <div class="modal-info-card">
                                        <small class="text-muted d-block fw-semibold mb-1" style="font-size: 11px;">Descripción / Objeto</small>
                                        <p class="mb-0 text-secondary" style="font-size: 13px; line-height: 1.5;" id="modalMetaDescripcion">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 2: HISTORIAL DE VERSIONES (Línea de tiempo institucional) -->
                        <div class="tab-pane fade" id="tab-versiones-pane" role="tabpanel">
                            
                            <!-- CARD SUPERIOR: Mini-resumen de metadatos del documento -->
                            <div class="card border rounded-4 bg-white p-3.5 mb-3 shadow-xs" style="border-color: #e2e8f0 !important;">
                                <!-- Fila superior: Código, Título y Badge de Vigencia -->
                                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 pb-2.5 mb-2.5 border-bottom" style="border-color: #f1f5f9 !important;">
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        <span class="badge px-2.5 py-1.5 fw-bold" style="background-color: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; font-size: 12.5px; border-radius: 6px;" id="modalTimelineBadgeCodigo">
                                            GU-TI-002
                                        </span>
                                        <h6 class="fw-bold text-dark mb-0 font-heading" style="font-size: 16px;" id="modalTimelineDocNombre">
                                            ADSO
                                        </h6>
                                    </div>
                                    <div>
                                        <span class="badge px-3 py-1.5 fw-bold" style="background-color: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; font-size: 12.5px; border-radius: 20px;" id="modalTimelineVigenteBadge">
                                            Vigente (V1.0)
                                        </span>
                                    </div>
                                </div>

                                <!-- Fila de 4 columnas institucionales -->
                                <div class="row g-2 text-start">
                                    <div class="col-6 col-sm-3">
                                        <small class="text-uppercase text-muted fw-bold d-block mb-1" style="font-size: 10px; letter-spacing: 0.5px;">PROCESO</small>
                                        <strong class="text-dark d-block text-truncate" style="font-size: 13.5px;" id="modalTimelineProceso">Tecnología</strong>
                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <small class="text-uppercase text-muted fw-bold d-block mb-1" style="font-size: 10px; letter-spacing: 0.5px;">TIPO DE DOCUMENTO</small>
                                        <strong class="text-dark d-block text-truncate" style="font-size: 13.5px;" id="modalTimelineTipo">Guía</strong>
                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <small class="text-uppercase text-muted fw-bold d-block mb-1" style="font-size: 10px; letter-spacing: 0.5px;">RESPONSABLE DE REVISIÓN</small>
                                        <strong class="text-dark d-block text-truncate" style="font-size: 13.5px;" id="modalTimelineResponsable">Juan Felipe</strong>
                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <small class="text-uppercase text-muted fw-bold d-block mb-1" style="font-size: 10px; letter-spacing: 0.5px;">FECHA ENTRADA VIGENCIA</small>
                                        <strong class="text-dark d-block text-truncate" style="font-size: 13.5px;" id="modalTimelineFecha">16-Sep-2026</strong>
                                    </div>
                                </div>
                            </div>

                            <!-- CARD PRINCIPAL: FILTRO Y LÍNEA DE TIEMPO VERTICAL -->
                            <div class="card border rounded-4 bg-white p-3.5 shadow-xs" style="border-color: #e2e8f0 !important;">
                                <!-- Barra de Filtros -->
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 pb-3 mb-3 border-bottom" style="border-color: #f1f5f9 !important;">
                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                        <span class="fw-bold text-dark" style="font-size: 13px;">Filtrar historial:</span>
                                        <select id="modalVersionTypeFilter" class="form-select form-select-sm bg-white border rounded-3 px-2.5 py-1.5 fw-semibold text-dark shadow-xs" style="font-size: 12.5px; width: auto; min-width: 180px;" onchange="filterModalTimeline()">
                                            <option value="all">Tipo de Cambio: Todos</option>
                                            <option value="inicial">Creación inicial</option>
                                            <option value="contenido">Actualización de contenido</option>
                                            <option value="estado">Cambio de estado</option>
                                            <option value="correccion">Corrección</option>
                                        </select>
                                        <div class="d-inline-flex align-items-center gap-1.5 px-3 py-1.5 border rounded-3 bg-white text-muted shadow-xs" style="font-size: 12px;">
                                            <i class="far fa-calendar-alt text-secondary"></i>
                                            <span id="modalTimelineDateRange">Historial completo</span>
                                        </div>
                                    </div>
                                    <span class="badge bg-light text-muted border rounded-pill px-2.5 py-1" id="modalTimelineCountBadge" style="font-size: 11px;">1 Versión</span>
                                </div>

                                <!-- Contenedor del Timeline Vertical -->
                                <div class="timeline-v-container position-relative px-2 py-1" id="modalTimelineEventsList">
                                    <!-- Inyectado dinámicamente vía JavaScript -->
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer bg-light border-top px-4 py-3 d-flex justify-content-end align-items-center" style="border-color: #eef2f6 !important;">
                    <button type="button" class="btn btn-outline-secondary px-4 rounded-3 fw-semibold" style="font-size: 13px;" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://sicefa.com.co/general/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Client Scripts for Table Filters, Full Modal Preview & Scroll Reveal -->
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
                revealElements.forEach(el => el.classList.add('is-revealed'));
            }

            // Tabs listeners para toggle de clase active
            document.querySelectorAll('#modalDocTabs button[data-bs-toggle="tab"]').forEach(btn => {
                btn.addEventListener('shown.bs.tab', function (e) {
                    document.querySelectorAll('#modalDocTabs .modal-tab-btn').forEach(b => b.classList.remove('active'));
                    e.target.classList.add('active');
                });
            });

            // Inicializar filtro de tabla
            filterDocsTable();
        });

        let currentWelcomePage = 1;
        const welcomePageSize = 8;

        function filterDocsTable(page = 1) {
            currentWelcomePage = page;
            const searchInput = document.getElementById('filterSearchInput');
            const searchVal = searchInput ? searchInput.value.toLowerCase().trim() : '';
            const processSelect = document.getElementById('filterProcessSelect');
            const processVal = processSelect ? processSelect.value : 'TODOS';
            
            const rows = Array.from(document.querySelectorAll('#mainDocsTable tbody tr.doc-row-item'));
            const matchingRows = [];

            rows.forEach(row => {
                const code = (row.getAttribute('data-code') || '').toLowerCase();
                const name = (row.getAttribute('data-name') || '').toLowerCase();
                const process = row.getAttribute('data-process') || '';

                const matchesSearch = !searchVal || code.includes(searchVal) || name.includes(searchVal);
                const matchesProcess = processVal === 'TODOS' || process === processVal;

                if (matchesSearch && matchesProcess) {
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

        // =========================================================================
        // APERTURA Y CARGA COMPLETA DEL MODAL DE DETALLE Y LÍNEA DE TIEMPO
        // =========================================================================
        let currentDocVersions = [];

        async function openDocFullModal(docId) {
            // Reset tab al primer tab (Metadatos)
            const firstTabBtn = document.getElementById('tab-meta-btn');
            if (firstTabBtn) {
                const tab = new bootstrap.Tab(firstTabBtn);
                tab.show();
                document.querySelectorAll('#modalDocTabs .modal-tab-btn').forEach(b => b.classList.remove('active'));
                firstTabBtn.classList.add('active');
            }

            // Reset selector de filtro
            const filterSelect = document.getElementById('modalVersionTypeFilter');
            if (filterSelect) filterSelect.value = 'all';

            // Mostrar spinner en la lista de timeline
            const timelineContainer = document.getElementById('modalTimelineEventsList');
            timelineContainer.innerHTML = `
                <div class="text-center py-5 text-muted">
                    <div class="spinner-border spinner-border-sm text-success me-2" role="status"></div>
                    <span>Cargando información y versiones...</span>
                </div>
            `;

            const modalEl = document.getElementById('modalDocPreview');
            const modal = new bootstrap.Modal(modalEl);
            modal.show();

            try {
                const response = await fetch(`{{ url('/sgc/public/documentos') }}/${docId}/detalle`, {
                    headers: { 'Accept': 'application/json' }
                });

                if (!response.ok) throw new Error('Error al consultar datos');

                const data = await response.json();
                if (!data.success) throw new Error('Documento no encontrado');

                const doc = data.documento;
                currentDocVersions = doc.versiones || [];

                // 1. Encabezado principal del modal
                document.getElementById('modalPreviewDocHeaderTitle').textContent = `${doc.codigo} — ${doc.nombre}`;
                document.getElementById('modalPreviewDocHeaderSubtitle').textContent = 'Metadatos e historial de versiones';

                // 2. Tab 1: Metadatos
                document.getElementById('modalMetaCodigo').textContent = doc.codigo;
                document.getElementById('modalMetaEstado').textContent = doc.estado;
                document.getElementById('modalMetaNombre').textContent = doc.nombre;
                document.getElementById('modalMetaProceso').textContent = doc.proceso;
                document.getElementById('modalMetaArea').textContent = doc.area;
                document.getElementById('modalMetaTipo').textContent = doc.tipo_doc;
                document.getElementById('modalMetaResponsable').textContent = doc.responsable;
                document.getElementById('modalMetaDescripcion').textContent = doc.descripcion || 'Prueba de Creacion y publicacion';

                // 3. Tab 2: Mini-resumen superior
                document.getElementById('modalTimelineBadgeCodigo').textContent = doc.codigo;
                document.getElementById('modalTimelineDocNombre').textContent = doc.nombre;
                document.getElementById('modalTimelineVigenteBadge').textContent = `Vigente (${doc.version_actual})`;
                document.getElementById('modalTimelineProceso').textContent = doc.proceso;
                document.getElementById('modalTimelineTipo').textContent = doc.tipo_doc;
                document.getElementById('modalTimelineResponsable').textContent = doc.responsable;
                document.getElementById('modalTimelineFecha').textContent = doc.fecha_vigencia;

                // 4. Contador de versiones
                const countBadge = document.getElementById('modalTimelineCountBadge');
                if (countBadge) {
                    countBadge.textContent = `${currentDocVersions.length} ${currentDocVersions.length === 1 ? 'Versión' : 'Versiones'}`;
                }

                // 5. Renderizar lista de versiones en el Timeline
                renderTimelineList(currentDocVersions, 'all');

            } catch (err) {
                console.error(err);
                timelineContainer.innerHTML = `
                    <div class="text-center py-4 text-danger">
                        <i class="fas fa-exclamation-triangle fs-3 mb-2 d-block"></i>
                        <span>No se pudo cargar la información del documento.</span>
                    </div>
                `;
            }
        }

        // =========================================================================
        // RENDERIZADO DINÁMICO DE LA LÍNEA DE TIEMPO VERTICAL (ESTILO IMAGEN 1)
        // =========================================================================
        function renderTimelineList(versions, filterType = 'all') {
            const container = document.getElementById('modalTimelineEventsList');
            if (!container) return;

            const filtered = versions.filter(v => {
                if (filterType === 'all') return true;
                const tb = (v.tipo_badge || '').toLowerCase();
                if (filterType === 'inicial') return tb.includes('inicial') || tb.includes('creación') || tb.includes('creacion') || v.numero_version == '1.0' || v.numero_version == '1';
                if (filterType === 'contenido') return tb.includes('contenido') || tb.includes('actualización') || tb.includes('actualizacion');
                if (filterType === 'estado') return tb.includes('estado') || tb.includes('vigente') || tb.includes('obsoleto');
                if (filterType === 'correccion') return tb.includes('corrección') || tb.includes('correccion');
                return true;
            });

            if (filtered.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-filter-circle-xmark fs-3 text-secondary opacity-50 mb-2 d-block"></i>
                        <span class="small">No se encontraron versiones para el filtro seleccionado.</span>
                    </div>
                `;
                return;
            }

            let html = '';
            filtered.forEach((v, idx) => {
                const isLast = idx === filtered.length - 1;
                const formato = v.archivo_formato || 'PDF';
                
                html += `
                    <div class="timeline-v-item ${isLast ? 'timeline-v-item-last' : ''}">
                        <!-- Punto Conector de la Línea -->
                        <div class="timeline-v-dot"></div>

                        <!-- Encabezado del Evento: Versión + Badge + Fecha -->
                        <div class="d-flex justify-content-between align-items-center mb-1 flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <strong class="text-dark fw-bold font-heading" style="font-size: 15px;">
                                    Versión ${v.numero_version}
                                </strong>
                                <span class="badge px-2.5 py-0.5 fw-semibold" style="background-color: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; font-size: 11.5px; border-radius: 6px;">
                                    ${v.tipo_badge || 'Creación inicial'}
                                </span>
                            </div>
                            <span class="text-muted" style="font-size: 12.5px;">
                                ${v.fecha_publicacion_formatted || v.fecha_publicacion}
                            </span>
                        </div>

                        <!-- Línea de Autoría: Por: Nombre (Rol) -->
                        <div class="text-secondary fw-semibold mb-1" style="font-size: 13px; color: #475569 !important;">
                            ${v.autor_label || 'Por: ' + v.creador + ' (Resp. Calidad)'}
                        </div>

                        <!-- Cuerpo de la Descripción / Modificaciones -->
                        <p class="mb-2 text-muted" style="font-size: 13.5px; line-height: 1.5; color: #64748b !important;">
                            ${v.descripcion_cambio || 'Prueba de Creacion y publicacion'}
                        </p>

                        <!-- Botón de Descarga adjunto estilo Verde Suave del Sistema -->
                        <div>
                            <a href="${v.download_url}" download="${v.archivo_nombre}" class="btn-timeline-download" title="Descargar adjunto oficial ${v.archivo_nombre}">
                                <i class="fas fa-file-arrow-down text-success"></i>
                                <span>Descargar adjunto (${formato})</span>
                            </a>
                        </div>
                    </div>
                `;
            });

            container.innerHTML = html;
        }

        function filterModalTimeline() {
            const filterVal = document.getElementById('modalVersionTypeFilter').value;
            renderTimelineList(currentDocVersions, filterVal);
        }
    </script>
</body>
</html>
