<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return " Please see the <a href='https://github.com/simaremare/ppw1920-uas'>documentation</a>.";
});

$router->get('/accounts/{username}', 'AccountController@detail');
$router->patch('/accounts', 'AccountController@update');

$router->get('/transactions', 'TransactionController@list');
$router->post('/transactions/issue', 'TransactionController@issue');
$router->get('/transactions/{id}', 'TransactionController@detail');


$router->get('/pasien/{id}','AccountController@pasien');
$router->post('/pasien/','AccountController@pasien');
$router->get('/dokter/{id}','AccountController@dokter');
$router->post('/dokter','AccountController@dokter');

$router->get('/pasien/','AccountController@pasiendetail');