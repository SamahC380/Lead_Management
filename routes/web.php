<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CrudController;
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

Route::get('/home',[AuthController::class,'authFn'])->middleware('auth','verified')->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
//Add New Lead Route to Controller
Route::get('/add_lead',[CrudController::class,'addleadpage'])->name('addleadpage');
Route::post('/addlead',[CrudController::class, 'addleadfn'])->name('addlead');

//Executive Details
Route::get('/execdetails',[CrudController::class,'execdetailfn'])->name('execdetail');
//Edit 
Route::get('/edit_user_page/{id}',[CrudController::class,'EditUserPagefn'])->name('EditUserPage');
Route::get('/edit_lead_page/{id}',[CrudController::class,'EditLeadPagefn'])->name('EditLeadPage');
Route::post('/Edit_Lead/{id}',[CrudController::class,'EditLeadfn'])->name('EditLead');
Route::post('/Edit_User/{id}',[CrudController::class,'EditUserfn'])->name('EditUser');

//Delete
Route::get('/delete_lead/{id}',[CrudController::class,'DeleteLeadfn'])->name('DeleteLead');
Route::get('/delete_user/{id}',[CrudController::class,'DeleteUserfn'])->name('DeleteUser');
require __DIR__.'/auth.php';
