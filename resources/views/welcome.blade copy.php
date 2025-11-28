<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Chamados</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #4f46e5; /* Indigo moderno */
            --primary-hover: #4338ca;
            --bg-color: #f3f4f6;
            --card-bg: #ffffff;
            --text-main: #111827;
            --text-secondary: #6b7280;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            /* Padrão de fundo sutil */
            background-image: radial-gradient(#e5e7eb 1px, transparent 1px);
            background-size: 24px 24px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1.5rem;
        }

        .container {
            background: var(--card-bg);
            border-radius: 1.5rem;
            /* Sombra mais difusa e elegante */
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            padding: 3.5rem 3rem;
            width: 100%;
            max-width: 450px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.5);
            transition: transform 0.3s ease;
        }

        .logo-wrapper {
            background: #fff;
            width: 90px;
            height: 90px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem auto;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid #f3f4f6;
        }

        .logo img {
            height: 48px;
            width: auto;
        }

        .content-header {
            margin-bottom: 2.5rem;
        }

        .title {
            font-size: 1.75rem;
            color: var(--text-main);
            font-weight: 700;
            letter-spacing: -0.025em;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .auth-options {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .auth-button {
            padding: 0.875rem 1.5rem;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            position: relative;
            overflow: hidden;
        }

        .login {
            background: var(--primary-color);
            color: white;
            border: 1px solid transparent;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
        }

        .login:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
        }

        .login:active {
            transform: translateY(0);
        }

        .login svg {
            width: 20px;
            height: 20px;
        }

        /* Rodapé sutil */
        .footer {
            margin-top: 2.5rem;
            font-size: 0.8rem;
            color: #9ca3af;
        }

        @media (max-width: 640px) {
            .container {
                padding: 2.5rem 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo-wrapper">
            <img src="https://laravel.com/img/logomark.min.svg" alt="Logo Laravel">
        </div>

        <div class="content-header">
            <h1 class="title">Portal de Chamados</h1>
            <p class="subtitle">Gerencie suas solicitações e suporte técnico de forma centralizada.</p>
        </div>

        <div class="auth-options">
            <a href="{{ route('login') }}" class="auth-button login">
                <span>Acessar Sistema</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Sistema Corporativo
        </div>
    </div>
</body>

</html>