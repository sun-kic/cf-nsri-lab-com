<?php

use App\Http\Controllers\DataController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TodayController;
use App\Http\Controllers\KaizenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AboutController;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


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

Route::get('/', [HomeController::class, 'index'])->middleware('auth');

Route::get('/today', [TodayController::class, 'index'])->middleware('auth');
Route::get('/today/route', [TodayController::class, 'route'])->middleware('auth');
Route::post('/today/store',  [TodayController::class, 'store'])->middleware('auth');
Route::get('/today/{today}/edit',  [TodayController::class, 'store'])->middleware('auth');
Route::put('/today/{today}',  [TodayController::class, 'update'])->middleware('auth');

Route::get('/kaizen', [KaizenController::class, 'index'])->middleware('auth');
Route::post('/kaizen/update',  [KaizenController::class, 'store'])->middleware('auth');

Route::get('/data', [DataController::class, 'index'])->middleware('auth');

Route::get('/about', [AboutController::class, 'index'])->middleware('auth');

Route::get('/profile',  [ProfileController::class, 'index'])->middleware('auth');
Route::post('/profile/store',  [ProfileController::class, 'store'])->middleware('auth');
Route::put('/profile/{profile}',  [ProfileController::class, 'update'])->middleware('auth');

// Route::post('/profile/update',  [ProfileController::class, 'store'])->middleware('auth');

Route::get('/register', [UserController::class, 'create'])->middleware('guest');;

Route::post('/users', [UserController::class, 'store']);

// Log User Out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// Show Login Form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// Log In User
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

Route::get('/forgot-password', function () {
    return view('users.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])->with('message', 'メールを送信しました。受信メールをチェックしてください。')
                : back()->withErrors(['email' => __($status)])->with('message', 'エラー発生');
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('users.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');