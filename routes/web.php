<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
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

Route::get('/', [ClientController::class, 'index'])->name('home');
Route::get('/detail-post-{slug}', [ClientController::class, 'detailPost'])->name('detailPost');
Route::post('/detail-post-{slug}', [ClientController::class, 'comment']);
Route::get('/category-{id}', [ClientController::class, 'postCategory'])->name('Category');
Route::get('/about', [ClientController::class, 'About'])->name('about');
Route::get('/contact', [ClientController::class, 'contact'])->name('contact');
Route::post('/contact', [ClientController::class, 'addContact'])->name('send.email');
Route::get('/search', [ClientController::class, 'searchPost'])->name('clinet.search');
Route::get('/login', [ClientController::class, 'login'])->name('login');
Route::post('/login', [ClientController::class, 'checkLogin']);
Route::get('/register', [ClientController::class, 'register'])->name('register');
Route::post('/register', [ClientController::class, 'createRegister']);
Route::get('/logout', [ClientController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [ClientController::class, 'Forgotpassword'])->name('Forgotpassword');
Route::post('/forgot-password', [ClientController::class, 'ForgotpasswordSenMail']);
Route::get('/infor', [ClientController::class, 'infor'])->name('infor');
Route::post('/infor', [ClientController::class, 'updateInfor']);

Route::prefix('ZenBlog-admin')->middleware('admin')->group(function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.home');

    Route::get('listcategory', [AdminController::class, 'listCategory'])->name('listcategory');
    Route::get('addnewcategory', [AdminController::class, 'addNewCategory'])->name('addnewcategory');
    Route::post('addnewcategory', [AdminController::class, 'postCategory'])->name('postcategory');
    Route::get('editcategory-{id}', [AdminController::class, 'editCategory'])->name('editcategory');
    Route::put('editcategory-{id}', [AdminController::class, 'putEditCategory'])->name('updatecategory');
    Route::get('deletecategory-{id}', [AdminController::class, 'deleteCategory'])->name('deletecategory');

    Route::get('listPost', [AdminController::class, 'listPost'])->name('listPost');
    Route::get('addnewPost', [AdminController::class, 'addNewPost'])->name('addnewPost');
    Route::post('addnewPost', [AdminController::class, 'Post'])->name('postPost');
    Route::get('editPost-{slug}={id}', [AdminController::class, 'editPost'])->name('editPost');
    Route::put('editPost-{slug}={id}', [AdminController::class, 'putEditPost'])->name('updatePost');
    Route::get('deletePost-{slug}={id}', [AdminController::class, 'deletePost'])->name('deletePost');

    Route::get('listUser', [AdminController::class, 'listUser'])->name('listUser');
    Route::get('addnewUser', [AdminController::class, 'addNewUser'])->name('addnewUser');
    Route::post('addnewUser', [AdminController::class, 'User'])->name('postUser');
    Route::get('editUser-{id}', [AdminController::class, 'editUser'])->name('editUser');
    Route::put('editUser-{id}', [AdminController::class, 'putEditUser'])->name('updateUser');
    Route::get('deleteUser-{id}', [AdminController::class, 'deleteUser'])->name('deleteUser');

    Route::get('listComment', [AdminController::class, 'listComment'])->name('listComment');
    Route::get('deleteComment-{id}', [AdminController::class, 'deleteComment'])->name('deleteComment');

});

