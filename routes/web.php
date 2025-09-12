<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\Admin\EntidadeController;

Route::resource('cargos', CargoController::class);
Route::resource('unidades', UnidadeController::class);
Route::resource('funcionarios', FuncionarioController::class);

// rota para a view combinada que criamos
Route::get('admin/entidades', [EntidadeController::class, 'index'])->name('admin.entidades');
