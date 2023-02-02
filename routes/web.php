<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommunityLinkController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('community', [CommunityLinkController::class, 'index'])->middleware('auth');

Route::post('community', [CommunityLinkController::class, 'store'])->middleware('auth');

/*
|--------------------------------------------------------------------------
| ACTIVIDAD A33 - EJERCICIO 1
|--------------------------------------------------------------------------
*/

Route::get('/test/{name?}', function ($name = 'desconocido') {
    return "Bienvenido $name" . "<br>" .
        "Metodo de entrada: GET";
});

Route::post('/test/{name}', function ($name) {
    return "Bienvenido $name" . "<br>" .
        "Metodo de entrada: POST";
});

// Uso Request para identificar el tipo de solicitud
Route::match(['get', 'post'], '/test-match/{name?}', 
function (Request $request, $name = 'desconocido') {

    if ($request->isMethod('get')) {
        return "Bienvenido $name" . "<br>" .
            "Metodo de entrada: GET";
    } else {
        return "Bienvenido $name" . "<br>" .
            "Metodo de entrada: POST";
    }
});

// Si el valor no es numérico, devuelve un error 404
Route::get('/numbers/{value?}', function ($value = null) {
    if ($value == null) {
        return "No ha insertado ningun parametro";
    } else {
        return "El parametro es numérico";
    }
})->whereNumber('value');

// Si el primer valor no esta formado por letras 
// y el segundo valor no esta formado por números, devuelve un error 404
Route::get('/params/{name?}/{number?}', function ($name = 'desconocido', $number = null) {

    echo "Bienvenido $name" . "<br>";

    if ($number == null) {
        echo "No ha insertado ningun parametro";
        return;
    } else {
        echo "El parametro es numérico";
        return;
    }
})->whereAlpha('name')->whereNumber('number');

/*
|--------------------------------------------------------------------------
| ACTIVIDAD A33 - EJERCICIO 2
|--------------------------------------------------------------------------
*/

Route::get('/host', function () {
    return "Tu host es: " . env('DB_HOST');
});

Route::get('/timezone ', function () {
    return "Zona horaria: " . config('app.timezone');
});

/*
|--------------------------------------------------------------------------
| ACTIVIDAD A33 - EJERCICIO 3
|--------------------------------------------------------------------------
*/

Route::view('/inicio', 'A33/home');

$day = date('d');
$month = date('m');
$year = date('y');

// ARRAY ASOCIATIVO
$date = [
    'day' => $day,
    'month' => $month,
    'year' => $year
];

Route::view('/fecha', 'A33/fecha', $date);

/* COMPACT
$date = compact('day', 'month', 'year');
Route::view('/fecha', 'A33/fecha', $date);
*/

/* HELPER WITH
Route::get('/fecha ', function () {
    return view('A33/fecha')
        ->with('day', date('d'))
        ->with('month', date('m'))
        ->with('year', date('y'));
});
*/

// ERRORES
Route::view('/error', 'A33/prueba');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
