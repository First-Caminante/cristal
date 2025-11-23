<?php

use App\Models\Promocion;
use App\Models\PromocionFoto;
use App\Models\Testimonio;
use App\Http\Controllers\WebController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

Schema::disableForeignKeyConstraints();
PromocionFoto::truncate();
Promocion::truncate();
Testimonio::truncate();
Schema::enableForeignKeyConstraints();

// Crear promoción activa
$promo = Promocion::create([
    'titulo' => 'Promoción de Prueba',
    'descripcion' => 'Esta es una promoción dinámica de prueba.',
    'precio' => 99.90,
    'fecha_inicio' => Carbon::yesterday(),
    'fecha_fin' => Carbon::tomorrow(),
]);

PromocionFoto::create([
    'promo_id' => $promo->id,
    'ruta_foto' => 'promos/prueba.jpg',
]);

echo "Promoción creada: " . $promo->titulo . "\n";

// Crear testimonio visible
$testimonio = Testimonio::create([
    'nombre' => 'Cliente Feliz',
    'comentario' => 'Me encanta este producto, es increíble.',
    'fuente' => 'Facebook',
    'fecha_publicacion' => Carbon::now(),
    'visible' => 1,
]);

echo "Testimonio creado: " . $testimonio->nombre . "\n";

// Renderizar la vista para verificar
$controller = new WebController();
$response = $controller->home();
$html = $response->render();

if (strpos($html, 'Promoción de Prueba') !== false) {
    echo "VERIFICACIÓN EXITOSA: El título de la promoción aparece en la vista.\n";
} else {
    echo "FALLO: El título de la promoción NO aparece en la vista.\n";
}

if (strpos($html, 'Cliente Feliz') !== false) {
    echo "VERIFICACIÓN EXITOSA: El testimonio aparece en la vista.\n";
} else {
    echo "FALLO: El testimonio NO aparece en la vista.\n";
}
