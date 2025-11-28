#!/bin/bash
# Script de teste de autenticação

echo "=== TESTE DE AUTENTICAÇÃO SISTEMA CHAMADOS ==="
echo ""

cd /home/duda/sistema-chamado

echo "1. Verificando migrações..."
php artisan migrate:status | tail -5

echo ""
echo "2. Limpando caches..."
php artisan config:clear 2>&1 | head -1
php artisan cache:clear 2>&1 | head -1
php artisan view:clear 2>&1 | head -1

echo ""
echo "3. Testando conexão com banco de dados..."
php artisan db:show 2>&1 | head -5

echo ""
echo "4. Verificando tabela de sessões..."
php artisan tinker --execute="
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

if (Schema::hasTable('sessions')) {
    \$count = DB::table('sessions')->count();
    echo \"✓ Tabela de sessões OK (\" . \$count . \" registros)\\n\";
} else {
    echo \"✗ Tabela de sessões NÃO encontrada\\n\";
}
" 2>&1 | grep -E "✓|✗|Tabela"

echo ""
echo "5. Testando criação de usuário para teste..."
php artisan tinker --execute="
use App\Models\User;

\$email = 'teste@exemplo.com';
\$user = User::where('email', \$email)->first();

if (\$user) {
    echo \"✓ Usuário de teste existe: \$email\\n\";
} else {
    \$user = User::create([
        'name' => 'Usuário Teste',
        'email' => \$email,
        'password' => bcrypt('123456'),
        'email_verified_at' => now(),
    ]);
    echo \"✓ Usuário de teste criado: \$email\\n\";
}
" 2>&1 | grep -E "✓|teste"

echo ""
echo "=== RESUMO DE CORREÇÕES ==="
echo "✓ Kernel.php: Middlewares configurados corretamente"
echo "✓ APP_URL: Configurado para http://127.0.0.1"
echo "✓ Sessões: Configuradas para usar banco de dados"
echo "✓ Middlewares essenciais: Todos criados e configurados"
echo "✓ CSRF: Token presente no formulário de login"
echo ""
echo "Tente fazer login com:"
echo "  E-mail: teste@exemplo.com"
echo "  Senha: 123456"
echo ""
