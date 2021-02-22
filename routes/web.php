<?php
use  App\Http\Controllers\ConexaoApi\ConexaoController;
use  App\Http\Controllers\Flights\FlightsController;
use Illuminate\Support\Facades\Route;


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
    return view('swagger');
});

Route::get('/doc', function () {
    return file_get_contents(public_path('swagger\swagger.json'));
});
