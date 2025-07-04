<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FamilyMemberController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/family-members/create', [FamilyMemberController::class, 'create'])->name('family-members.create');
    Route::post('/family-members', [FamilyMemberController::class, 'store'])->name('family-members.store');
    Route::get('/family-members/{familyMember}/edit', [FamilyMemberController::class, 'edit'])->name('family-members.edit');
    Route::put('/family-members/{familyMember}', [FamilyMemberController::class, 'update'])->name('family-members.update');
    Route::delete('/family-members/{familyMember}', [FamilyMemberController::class, 'destroy'])->name('family-members.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/community-tree', [DashboardController::class, 'communityTree'])->name('community.tree');

require __DIR__.'/auth.php';
