<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiscTestController;

Route::get('/', function () {
    return view('welcome');
});

// Redirect root disc-test to token step
Route::get('/disc-test', function () {
    return redirect()->route('disc-test.token');
});

// Tahap 1: Token
Route::get('/disc-test/token', [DiscTestController::class, 'showTokenForm'])->name('disc-test.token');
Route::post('/disc-test/token', [DiscTestController::class, 'verifyToken'])->name('disc-test.token.verify');

// Tahap 2: Data Diri
Route::get('/disc-test/data-diri', [DiscTestController::class, 'showDataDiriForm'])->name('disc-test.data-diri');
Route::post('/disc-test/data-diri', [DiscTestController::class, 'storeDataDiri'])->name('disc-test.data-diri.store');

// Tahap 3: Instruksi
Route::get('/disc-test/instruksi', [DiscTestController::class, 'showInstruksi'])->name('disc-test.instruksi');

// Tahap 4: Soal
Route::get('/disc-test/soal', [DiscTestController::class, 'showSoal'])->name('disc-test.soal');
Route::post('/disc-test/soal', [DiscTestController::class, 'storeSoal'])->name('disc-test.soal.store');

// Hasil
Route::get('/disc-test/result/{id}', [DiscTestController::class, 'result'])->name('disc-test.result');

// Admin Routes
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login')->middleware('guest');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit')->middleware('guest');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Tokens
    Route::get('/tokens', [AdminController::class, 'tokens'])->name('tokens');
    Route::post('/tokens/generate', [AdminController::class, 'generateTokens'])->name('tokens.generate');
    
    // Participants
    Route::get('/participants', [AdminController::class, 'participants'])->name('participants');
    Route::get('/participants/{id}', [AdminController::class, 'showParticipant'])->name('participants.show');
    
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});
