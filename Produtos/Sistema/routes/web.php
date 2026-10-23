<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;

Route::redirect('/', '/produtos');

Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
Route::get('/produtos/criar', [ProdutoController::class, 'create'])->name('produtos.create');
Route::post('/produtos', [ProdutoController::class, 'store'])->name('produtos.store');
Route::get('/produtos/{id}/editar', [ProdutoController::class, 'edit'])->whereNumber('id')->name('produtos.edit');
Route::get('/produtos/{id}', [ProdutoController::class, 'show'])->whereNumber('id')->name('produtos.show');
Route::put('/produtos/{id}', [ProdutoController::class, 'update'])->whereNumber('id')->name('produtos.update');
Route::patch('/produtos/{id}', [ProdutoController::class, 'update'])->whereNumber('id');
Route::delete('/produtos/{id}', [ProdutoController::class, 'destroy'])->whereNumber('id')->name('produtos.destroy');
