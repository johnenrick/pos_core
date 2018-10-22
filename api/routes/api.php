<?php

use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// sleep(2);
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('test', function () {
    echo 'test';
});
Route::get('/', function () {
    echo 'This is the api <br> Server Time: '. date("Y-m-d H:i:s", time());
});
/* Authentication Router */
Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
Route::post('authentication/create', 'AuthenticateController@authenticate');
Route::post('authentication/user', 'AuthenticateController@getAuthenticatedUser');
Route::group(['middleware' => ['jwt.refresh']], function(){
  Route::post('authentication/refresh', 'AuthenticateController@refresh');
});
Route::post('authentication/destroy', 'AuthenticateController@deauthenticate');
/*API Router*/
require_once 'routes_fn.php';
require_once 'api_routes.php';
