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
    return "Ola Mundo! You are not allowed here";//view('welcome');
});
Route::get('test', function () {
    return "Ola Mundo! You are not allowed here";//view('welcome');
});
/*
  Accessing uploaded files
*/
Route::get('file/icon/{filename}', function ($filename)
{
  $path = storage_path('/icons/' . $filename);
  if (!File::exists($path)) {
      abort(404);
  }
  $file = File::get($path);
  $type = File::mimeType($path);
  $response = Response::make($file, 200);
  $response->header("Content-Type", $type);
  return $response;
});
Route::get('image/discount_image_proof/{filename}', function ($filename)
{
  $path = storage_path('app/discount_image_proof/' . $filename);
  if (!File::exists($path)) {
      abort(404);
  }
  $file = File::get($path);
  $type = File::mimeType($path);
  $response = Response::make($file, 200);
  $response->header("Content-Type", $type);
  return $response;
});
Route::get('file/company/{filename}', function ($filename)
{
  $path = storage_path('/company/' . $filename);
  if (!File::exists($path)) {
      abort(404);
  }
  $file = File::get($path);
  $type = File::mimeType($path);
  $response = Response::make($file, 200);
  $response->header("Content-Type", $type);
  return $response;
});
Route::get('file/q_card/{filename}', function ($filename)
{
  $path = storage_path('/qcards/' . $filename);
  if (!File::exists($path)) {
      abort(404);
  }
  $file = File::get($path);
  $type = File::mimeType($path);
  $response = Response::make($file, 200);
  $response->header("Content-Type", $type);
  return $response;
});
Route::get('file/account_profiles/{filename}', function ($filename)
{
  $path = storage_path('/account_profiles/' . $filename);
  if (!File::exists($path)) {
      abort(404);
  }
  $file = File::get($path);
  $type = File::mimeType($path);
  $response = Response::make($file, 200);
  $response->header("Content-Type", $type);
  return $response;
});
Route::get('/cache', function () {
    $exitCode = Artisan::call('config:cache');
    return 'hey'.$exitCode;

    //
});
Route::get('/clear', function () {
    $exitCode = Artisan::call('config:cache');
    return 'hey'.$exitCode;

    //
});
Route::get('/migrate', function () {
    $exitCode = Artisan::call('migrate');
    return 'hey'.$exitCode;

    //
});

