<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\BufferedOutput;

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

Route::get('migrate', function () {
	$page = '';
	$output = new BufferedOutput();
	Artisan::call('migrate', [], $output);;
	$page .= '<pre>' . $output->fetch() . '</pre>';
	$page .= '<p></p>';
	$page .= '<a href="javascript:history.back()">Go Back</a> | <a href="/">Home</a>';
	$page .= '<hr>';
	$page .= date('Y-m-d H:i:s');    // dS D y g:i A
	return $page;
});

Route::get('optimize', function () {
	$page = '';
	$output = new BufferedOutput();

	Artisan::call('cache:clear', [], $output);;
	$page .= '<pre>' . $output->fetch() . '</pre>';
	$page .= '<p></p>';
	Artisan::call('route:clear', [], $output);;
	$page .= '<pre>' . $output->fetch() . '</pre>';
	$page .= '<p></p>';
	Artisan::call('config:clear', [], $output);;
	$page .= '<pre>' . $output->fetch() . '</pre>';
	$page .= '<p></p>';
	Artisan::call('view:clear', [], $output);;
	$page .= '<pre>' . $output->fetch() . '</pre>';
	$page .= '<p></p>';
	Artisan::call('optimize:clear', [], $output);
	$page .= '<pre>' . $output->fetch() . '</pre>';
	$page .= '<p></p>';

	$page .= '<a href="javascript:history.back()">Go Back</a> | <a href="/">Home</a>';
	$page .= '<hr>';
	$page .= date('Y-m-d H:i:s');    // dS D y g:i A
	return $page;
});

Route::post('refresh-csrf', function () { // https://stackoverflow.com/a/44123313/8054241 & https://stackoverflow.com/a/31451123/8054241
	return csrf_token();
});

Route::get('/', function () {
    return redirect('/dashboard');
    return view('welcome');
});

Route::middleware(['web', 'auth', 'auth.session'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
    
    Route::get('/profile', function () {
			return view('profile.show');
	})->name('profile');

		Route::match(['get','post'],'users/{id?}', 'App\Http\Controllers\UserController@index');
		Route::get('users/{id}/delete', 'App\Http\Controllers\UserController@delete');
		Route::match(['get','post'],'courier/{id?}', 'App\Http\Controllers\courierController@index');
		Route::get('courier/{id}/delete', 'App\Http\Controllers\courierController@delete');
});