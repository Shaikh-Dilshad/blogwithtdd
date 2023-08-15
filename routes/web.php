<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
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
Route::get('blog/create' , [BlogController::class , 'create'])->name('blogs.create');
Route::get('blog/list' , [BlogController::class , 'list'])->name('blogs.list');
Route::post('/store' , [BlogController::class , 'store'])->name('blogs.store');
Route::get('/blog/{id}/edit' ,[BlogController::class , 'edit'])->name('blogs.edit');
Route::put('/blog/update/{id}/' ,[BlogController::class , 'update'])->name('blogs.update');
Route::get('/blog/delete/{id}/' ,[BlogController::class , 'destroy'])->name('blogs.destroy');



