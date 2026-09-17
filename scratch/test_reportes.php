<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Modules\SGC\Http\Controllers\ReportesController;
use Illuminate\Http\Request;

$controller = new ReportesController();

echo "Testing index():\n";
$response = $controller->index(Request::create('/sgc/reportes', 'GET'));
echo "Index View Name: " . $response->name() . "\n";
echo "Index Data Keys: " . implode(', ', array_keys($response->getData())) . "\n";
$html = $response->render();
echo "Rendered Index Length: " . strlen($html) . " bytes\n";

echo "\nTesting generar() for PDF:\n";
$reqPdf = Request::create('/sgc/reportes/generar', 'POST', [
    'tipo_reporte' => 'listado_maestro',
    'formato' => 'pdf',
    'fecha_inicio' => '2024-01-01',
    'fecha_fin' => '2024-01-18',
    'proceso_id' => 'todos'
]);
$resPdf = $controller->generar($reqPdf);
echo "PDF View Name: " . $resPdf->name() . "\n";
$htmlPdf = $resPdf->render();
echo "Rendered PDF View Length: " . strlen($htmlPdf) . " bytes\n";

echo "\nTesting generar() for Excel:\n";
$reqExcel = Request::create('/sgc/reportes/generar', 'POST', [
    'tipo_reporte' => 'solicitudes',
    'formato' => 'excel',
    'fecha_inicio' => '2024-01-01',
    'fecha_fin' => '2024-01-18',
    'proceso_id' => 'todos'
]);
$resExcel = $controller->generar($reqExcel);
echo "Excel Response Type: " . get_class($resExcel) . "\n";

echo "\nSUCCESS! All tests passed.\n";
