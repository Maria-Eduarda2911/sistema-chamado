<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';

$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = \Illuminate\Http\Request::capture()
);

echo "=== TESTE DE AUTENTICAÇÃO ===\n\n";

// 1. Verificar configuração de sessão
echo "1. Configuração de Sessão:\n";
$config = config('session');
echo "   - Driver: " . $config['driver'] . "\n";
echo "   - Lifetime: " . $config['lifetime'] . " minutos\n";
echo "   - Encrypt: " . ($config['encrypt'] ? 'Sim' : 'Não') . "\n";
echo "   - Secure: " . ($config['secure'] ? 'Sim' : 'Não') . "\n";
echo "   - HTTP Only: " . ($config['http_only'] ? 'Sim' : 'Não') . "\n";
echo "   - Same Site: " . $config['same_site'] . "\n";
echo "   - Cookie Name: " . $config['cookie'] . "\n\n";

// 2. Verificar tabela de sessões
echo "2. Tabela de Sessões:\n";
$exists = \Illuminate\Support\Facades\Schema::hasTable('sessions');
echo "   - Existe: " . ($exists ? 'Sim' : 'Não') . "\n";
if ($exists) {
    $count = \Illuminate\Support\Facades\DB::table('sessions')->count();
    echo "   - Registros: " . $count . "\n";
}
echo "\n";

// 3. Verificar configuração de URL
echo "3. Configuração de URL:\n";
echo "   - APP_URL: " . config('app.url') . "\n";
echo "   - SESSION_DOMAIN: " . (config('session.domain') ?: '(vazio)') . "\n\n";

// 4. Verificar middleware
echo "4. Middlewares Web:\n";
$middlewares = config('app.http.kernel.middlewareGroups.web', []);
foreach ($middlewares ?? [] as $middleware) {
    echo "   - " . class_basename($middleware) . "\n";
}

echo "\n✓ Teste concluído!\n";
