<?php

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
    return redirect('http://www.guadalupe.gob.mx');
   
});

Route::get('/test', 'TestController@dbTest');
Route::get('/test2', 'TestController@testDesc');
Route::get('/registrar', 'api\UserController@register');
Route::post('/ppagomulta', 'api\TransitoController@procesaPago');
Route::post('predial/pago/pdf', 'api\PredialController@descargarpdf');
Route::get('/multas/consulta', 'api\TransitoController@consultarMultas');
Route::get('/multas', 'api\TransitoController@consultarMultas');
Route::get('/multas/forma', 'api\TransitoController@consultarForma');
Route::post('/multas/buscar', 'api\TransitoController@consultarResultado');
Route::post('/predial/buscar', 'api\PredialController@buscar');
Route::get('/predial', 'api\PredialController@consulta');
Route::post('/predial/consulta', 'api\PredialController@cuenta');
Route::post('/predial/direccion', 'api\PredialController@direccion');
Route::post('/predial/imprimir', 'api\PredialController@cuenta_pdf');
Route::post('/predial/paynet', 'api\PredialPDF@paynet');
Route::post('/predial/oxxo', 'api\PredialPDF@oxxo');
Route::post('/predial/azteca', 'api\PredialPDF@azteca');
Route::post('/predial/hsbc', 'api\PredialPDF@hsbc');
Route::post('/predial/bbva', 'api\PredialPDF@bbva');
Route::post('/ppagopredial', 'api\DefaultbController@procesaPagopredial');



Route::post('/presupuestos/usuarios_actualizarcuentas', 'api\PresupuestosController@usuarios_actualizarcuentas');
Route::any('/presupuestos/actualizarcuentas', 'api\PresupuestosController@actualizarcuentas');
Route::post('/presupuestos/actualizarsubcuentas', 'api\PresupuestosController@actualizarsubcuentas');