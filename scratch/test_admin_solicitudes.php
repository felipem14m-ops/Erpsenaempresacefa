<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Modules\SGC\Http\Controllers\SolicitudController;
use App\Models\User;
use Illuminate\Http\Request;
use Modules\SGC\Models\Solicitud;

$user = User::first();
if ($user) {
    auth()->login($user);
}

$controller = new SolicitudController();

echo "Testing indexAdmin():\n";
$req = Request::create('/sgc/admin/solicitudes', 'GET');
$res = $controller->indexAdmin($req);
echo "View name: " . $res->name() . "\n";
$html = $res->render();
echo "Rendered HTML length: " . strlen($html) . " bytes\n";

$sol = Solicitud::first();
if ($sol) {
    echo "\nTesting showAdmin({$sol->id}):\n";
    $resShow = $controller->showAdmin($sol->id);
    echo "Show View name: " . $resShow->name() . "\n";
    $htmlShow = $resShow->render();
    echo "Rendered Show HTML length: " . strlen($htmlShow) . " bytes\n";
}

echo "\nSUCCESS! All Admin Solicitudes tests passed.\n";
