<?php

use App\Http\Controllers\AuditsController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('users', [UserController::class, 'index'])->name('users.index');
Route::get('users/create', [UserController::class, 'create'])->name('users.create');
Route::post('users/store', [UserController::class, 'store'])->name('users.store');
Route::get('users/{user}', [UserController::class, 'edit'])->name('users.edit');
Route::delete('users/{user}/destroy', [UserController::class, 'destroy'])->name('users.destroy');
Route::post('users/change-password', [UserController::class, 'change_password'])->name('users.change_password');

Route::get('files', [FileController::class, 'index'])->name('files.index');
Route::get('get-files', [FileController::class, 'get'])->name('files.get');


Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');
Route::post('roles/store', [RoleController::class, 'store'])->name('roles.store');
Route::get('roles/{role}', [RoleController::class, 'edit'])->name('roles.edit');
Route::delete('roles/{role}/destroy', [RoleController::class, 'destroy'])->name('roles.destroy');

Route::get('audits/files', [AuditsController::class, 'files'])->name('audits.files');
Route::get('audits/users', [AuditsController::class, 'users'])->name('audits.users');