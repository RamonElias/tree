<?php

use App\Http\Controllers\Api\NodeController;
use App\Http\Middleware\Mirror;
use App\Http\Middleware\SetTimezone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/testroute', function (Request $request) {
// return '$->all()';
//
// return $request->all();
// });

Route::group(['middleware' => [SetTimezone::class, Mirror::class]], function () {
    Route::get('/nodes', [NodeController::class, 'index'])
        // ->name('threads.index')->middleware('auth:api');
        ->name('nodes.index');

    Route::get('/nodes_with_children', [NodeController::class, 'nodes_with_children'])
        ->name('nodes.nodes_with_children');

    Route::get('/nodes_without_children', [NodeController::class, 'nodes_without_children'])
        ->name('nodes.nodes_without_children');

    Route::post('/nodes', [NodeController::class, 'store'])
        ->name('nodes.store');

    Route::get('/nodes/{node}', [NodeController::class, 'show'])
        ->name('nodes.show');

    Route::patch('/nodes/{node}', [NodeController::class, 'update'])
        ->name('nodes.update');

    Route::delete('/nodes/{node}', [NodeController::class, 'destroy'])
        ->name('nodes.destroy');
});

Route::fallback(function () {
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
});

// curl -v -H "Accept: application/json" -H "Content-Type:application/json" -H "X-Header-Timezone:America/Caracas" http://localhost:12376/api/nodes | jq | less
// curl -v -H "Accept: application/json" -H "Content-Type:application/json" -H "X-Header-Timezone:America/Los_Angeles" -H "X-Header-Lang:es" http://localhost:12376/api/nodes | jq | less
// curl -v -H "Accept: application/json" -H "Content-Type:application/json" http://localhost:12376/api/nodes | jq | less
// curl -v -H "Accept: application/json" -H "Content-Type:application/json" http://localhost:12376/api/nodes_with_children | jq | less
// curl -v -H "Accept: application/json" -H "Content-Type:application/json" http://localhost:12376/api/nodes_without_children | jq | less
// curl -v -H "Accept: application/json" -H "Content-Type:application/json" http://localhost:12376/api/node/1 | jq | less
// curl -v -H "Accept: application/json" -H "Content-Type:application/json" http://localhost:12376/api/nodes/1 | jq | less
// curl -v -H "Accept: application/json" -H "Content-Type:application/json" http://localhost:12376/api/nodes/57 | jq | less
// curl -v -H "Accept: application/json" -H "Content-Type:application/json" -X POST --data '{"parent":33}' http://localhost:12376/api/nodes | jq | less
// curl -v -H "Accept: application/json" -H "Content-Type:application/json" -X POST --data '{"parent":33}' http://localhost:12376/api/nodes | jq | less
// curl -v -H "Accept: application/json" -H "Content-Type:application/json" -X PUT --data '{"parent":33,"title":"seis siete"}' http://localhost:12376/api/nodes/67 | jq | less
// curl -i -H "Accept: application/json" -H "Content-Type:application/json" -X POST --data '{"account":{"email":"akdgdtk@test.com","screenName":"akdgdtk","type":"NIKE","passwordSettings":{"password":"Starwars1","passwordConfirm":"Starwars1"}},"firstName":"Test","lastName":"User","middleName":"ObiWan","locale":"en_US","registrationSiteId":"520","receiveEmail":"false","dateOfBirth":"1984-12-25","mobileNumber":"9175555555","gender":"male","fuelActivationDate":"2010-10-22","postalCode":"10022","country":"US","city":"Beverton","state":"OR","bio":"This is a test user","jpFirstNameKana":"unsure","jpLastNameKana":"ofthis","height":"80","weight":"175","distanceUnit":"MILES","weightUnit":"POUNDS","heightUnit":"FT/INCHES"}' https://xxx:xxxxx@xxxx-www.xxxxx.com/xxxxx/xxxx/xxxx
