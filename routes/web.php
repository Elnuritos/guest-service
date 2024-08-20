<?php

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
    return view('welcome');
});
Route::get('/api/documentation', function () {
    $documentation = 'default';
    $urlToDocs = url(config('l5-swagger.documentations.'.$documentation.'.docs_url', 'docs'));
    $useAbsolutePath = true;
    return view('l5-swagger::index', compact('documentation', 'urlToDocs', 'useAbsolutePath'));
});
