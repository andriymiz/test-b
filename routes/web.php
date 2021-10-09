<?php

use App\Http\Controllers\Web\TicketController;
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

Route::get('/tickets/{ticket}/confirm', [TicketController::class, 'confirm'])
    ->name('tickets.confirm')
    ->middleware('signed');
