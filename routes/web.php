<?php


use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BannedPlayerController;
use App\Http\Controllers\DataResetController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\GameSettingController;
use App\Http\Controllers\LogViewerController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PlayerNickHistoryController;
use App\Http\Controllers\PlayerSicilController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\WarningPlayerController;
use Illuminate\Support\Facades\Artisan;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {return redirect('sign-in');})->middleware('guest');


Route::get('sign-up', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('sign-up', [RegisterController::class, 'store'])->middleware('guest');
Route::get('sign-in', [SessionsController::class, 'create'])->middleware('guest')->name('login');
Route::post('sign-in', [SessionsController::class, 'store'])->middleware('guest');
Route::post('verify', [SessionsController::class, 'show'])->middleware('guest');
Route::post('reset-password', [SessionsController::class, 'update'])->middleware('guest')->name('password.update');
Route::get('verify', function () {
	return view('sessions.password.verify');
})->middleware('guest')->name('verify'); 
Route::get('/reset-password/{token}', function ($token) {
	return view('sessions.password.reset', ['token' => $token]);
})->middleware('guest')->name('password.reset');
Route::get('password-reset-form', [SessionsController::class, 'showPasswordResetForm'])->middleware('guest')->name('password-reset-form');
Route::post('password-reset-process', [SessionsController::class, 'passwordResetProcess'])->middleware('guest')->name('password-reset-process');
Route::post('sign-out', [SessionsController::class, 'destroy'])->middleware('auth')->name('logout');
Route::get('profile', [ProfileController::class, 'create'])->middleware('auth')->name('profile');

Route::group(['middleware' => 'auth'], function () {
	Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
	Route::resource('users',UserController::class);
	Route::resource('players',PlayerController::class);
	// BannedPlayerController için resource route tanımlaması, 'create' hariç.
	Route::resource('banned-players', BannedPlayerController::class);
	Route::resource('game_settings', GameSettingController::class);
	// 'create' metodu için özel route tanımlaması, Player modeli ile.
	Route::post('/banned-players/unban/{id}', [BannedPlayerController::class,'unban'])->name('banned-players.unban');
	Route::get('exceptions',[PlayerController::class,'ExceptionsIndex'])->name('exceptions.index');
	Route::post('/exceptions/update/{id}',[PlayerController::class,'updateException'])->name('exceptions.update');
	Route::get('banned-players/create/{player}', [BannedPlayerController::class, 'createWithPlayer'])->name('banned-players.createWithPlayer');
	Route::resource('warning-players', WarningPlayerController::class);
	Route::get('warning-players/create/{player}', [WarningPlayerController::class, 'createWithPlayer'])->name('warning-players.createWithPlayer');
	Route::resource('messages', MessageController::class);
	Route::resource('donations', DonationController::class);
	Route::resource('nick-histories', PlayerNickHistoryController::class);

	Route::resource('sicils', PlayerSicilController::class);

	Route::resource('site-settings', SiteSettingController::class);
	Route::put('/site-settings', [SiteSettingController::class, 'update'])->name('site-settings.update');
	Route::get('not-banned-players', [BannedPlayerController::class,'showNotBannedPlayers'])->name('banned-players.not-banned-players');
	Route::get('/logs/all', [LogViewerController::class, 'index'])->name('logs.all');
	Route::get('generate', function (){
		Artisan::call('storage:link');
		echo 'ok';
	});
	Route::post('/reset-player-sicils', [DataResetController::class, 'resetPlayerSicils'])->name('reset.player-sicils');
	Route::post('/reset-players', [DataResetController::class, 'resetPlayers'])->name('reset.players');
Route::post('/reset-banned-players', [DataResetController::class, 'resetBannedPlayers'])->name('reset.banned-players');
Route::post('/unban-all-players', [DataResetController::class, 'unbanAllPlayers'])->name('unban.all-players');
Route::post('/reset-warning-players', [DataResetController::class, 'resetWarningPlayers'])->name('reset.warning-players');
Route::post('/reset-messages', [DataResetController::class, 'resetMessages'])->name('reset.messages');
Route::post('/delete-users-except-admin', [DataResetController::class, 'deleteUserExceptAdmin'])->name('delete.users-except-admin');
});