<?php

use App\Http\Controllers\CargoController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\Admin\EntidadeController;
use Illuminate\Support\Facades\Route;

//lembrete: Rotas resource são uma forma rápida e padronizada de declarar o conjunto de rotas CRUD para um recurso
Route::resource('cargo', CargoController::class);
Route::resource('unidade', UnidadeController::class);
Route::resource('funcionario', FuncionarioController::class);

Route::get('/EscolherCFU', [EntidadeController::class, 'index'])->name('EscolherCFU');

