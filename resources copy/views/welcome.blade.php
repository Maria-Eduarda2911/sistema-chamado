<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Chamados</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        body {
            background: #f8fafc;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
        }

        .container {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            width: 100%;
            max-width: 480px;
            text-align: center;
        }

        .logo img {
            height: 64px;
            margin-bottom: 1.5rem;
        }

        .title {
            font-size: 1.875rem;
            color: #1e293b;
            margin-bottom: 2rem;
            font-weight: 700;
            letter-spacing: -0.025em;
        }

        .auth-options {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .auth-button {
            padding: 1rem;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .login {
            background: #3b82f6;
            color: white;
            box-shadow: 0 2px 4px rgba(59, 130, 246, 0.2);
        }

        .login:hover {
            background: #2563eb;
            transform: translateY(-1px);
        }

        .register {
            border: 2px solid #e2e8f0;
            color: #1e293b;
            background: white;
        }

        .register:hover {
            border-color: #94a3b8;
            transform: translateY(-1px);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">
            <img src="https://laravel.com/img/logomark.min.svg" alt="Logo Laravel">
        </div>

        <h1 class="title">Gerenciamento de Chamados</h1>

        <div class="auth-options">
            <a href="{{ route('login') }}" class="auth-button login">Acessar Sistema</a>
        </div>
        <div class="block px-4 py-2 text-xs text-gray-300 font-small hover:bg-gray-100 transition-colors">
            Desenvolvido por: Maria Eduarda
        </div>
    </div>
</body>

</html>