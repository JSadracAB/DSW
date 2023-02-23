<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommunityLinkController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

Route::get('community/{channel}', [CommunityLinkController::class, 'index']);

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
Route::match(
    ['get', 'post'],
    '/test-match/{name?}',
    function (Request $request, $name = 'desconocido') {

        if ($request->isMethod('get')) {
            return "Bienvenido $name" . "<br>" .
                "Metodo de entrada: GET";
        } else {
            return "Bienvenido $name" . "<br>" .
                "Metodo de entrada: POST";
        }
    }
);

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

/*
|--------------------------------------------------------------------------
| ACTIVIDAD A39 - EJERCICIO 4
|--------------------------------------------------------------------------
*/

Route::get('/consultas ', function () {

    echo '<h1>Tarea A39 - Ejercicio 4</h1>';

    /* 
    -- Todos los usuarios que tengan en el nombre la cadena "Fer".
    $query = DB::table('users')
        ->where('name', 'like', '%Fer%')
        ->get();


    -- Todos los usuarios que tengan en el correo la palabra "laravel" y la cadena "com".
    $query = DB::table('users')
        ->where([
            ['email', 'like', '%laravel%'],
            ['email', 'like', '%com%']
        ])
        ->get();


    -- Todos los usuarios que tengan en el correo la palabra "laravel" o la palabra "com".
    $query = DB::table('users')
        ->where('email', 'like', '%laravel%')
        ->orWhere('email', 'like', '%com%')
        ->get();


    -- Haz un insert en la tabla usuarios.
    DB::table('users')->insert([
        'name' => fake()->name(),
        'email' => fake()->unique()->safeEmail(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
    ]);


    -- Haz un insert de dos usuarios al mismo tiempo en la tabla usuarios.
    DB::table('users')->insert([
        [
            'name' => 'usuarioA',
            'email' => fake()->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ],
        [
            'name' => 'usuarioB',
            'email' => fake()->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ] 
    ]);


    -- Haz un insert utilizando el método insertGetId.
    $id = DB::table('users')->insertGetId(
        [
            'name' => 'usuarioC',
            'email' => fake()->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ]
    );
    echo 'Usuario insertado, Id: ' . $id;


    -- Actualiza el correo del usuario con id=2.
    $affected = DB::table('users')
        ->where('id', 2)
        ->update(['email' => 'email_actualizado@gmail.com']);
    echo 'Registros cambiados: ' . $affected;


    -- Borra el usuario con id 3.
    $deleted = DB::table('users')->where('id', 3)->delete();
    echo 'Usuarios borrados: ' . $deleted;

    -- Mostrar resultados en navegador
    if (count($query) > 0) {
        foreach ($query as $user) {
            echo $user->name . '<br>';
        }
    } else {
        echo 'No hay resultados';
    }
*/
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
