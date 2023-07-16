<?php

use App\Models\Node;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/seeder', function () {
    $tableNames = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();

    foreach ($tableNames as $name) {
        //if you don't want to truncate migrations
        if ($name == 'migrations') {
            continue;
        }
        DB::table($name)->truncate();
    }

    $seeder = new DatabaseSeeder();
    $seeder->run();

    return 'DatabaseSeeder ok!';
});

// Route::get('/swagger', function () {
//     return view('swagger');
// });
//
// Route::get('/errors', function () {
//     return view('errors');
// });

Route::get('/datas', function () {
    $node = Node::find(11);

    dump($node->toArray());
    dump($node->parent()->get()->toArray());
    dump($node->children()->get()->toArray());
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
