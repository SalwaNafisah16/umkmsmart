<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ForumPostController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\SaveController;
use App\Http\Controllers\Api\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes - RESTful API untuk Flutter (DPPB)
|--------------------------------------------------------------------------
|
| Routes ini digunakan oleh aplikasi Flutter untuk mengakses data
| dari backend Laravel. Semua response dalam format JSON.
|
*/

// ============================================
// PUBLIC ROUTES (Tanpa Autentikasi)
// ============================================

// Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ============================================
// PROTECTED ROUTES (Wajib Login / Bearer Token)
// ============================================
Route::middleware('auth:sanctum')->group(function () {

    // -----------------------------------------
    // AUTH
    // -----------------------------------------
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // -----------------------------------------
    // FORUM POSTS (Mahasiswa & UMKM)
    // -----------------------------------------
    Route::get('/forum/posts', [ForumPostController::class, 'index']);
    Route::post('/forum/posts', [ForumPostController::class, 'store']);
    Route::get('/forum/posts/{id}', [ForumPostController::class, 'show']);
    Route::put('/forum/posts/{id}', [ForumPostController::class, 'update']);
    Route::delete('/forum/posts/{id}', [ForumPostController::class, 'destroy']);
    Route::get('/forum/my-posts', [ForumPostController::class, 'myPosts']);

    // Like & Save Forum Post
    Route::post('/forum/posts/{id}/like', [LikeController::class, 'toggle']);
    Route::post('/forum/posts/{id}/save', [SaveController::class, 'toggle']);
    Route::get('/forum/saved', [SaveController::class, 'index']);

    // Comments on Forum Post
    Route::get('/forum/posts/{id}/comments', [CommentController::class, 'index']);
    Route::post('/forum/posts/{id}/comments', [CommentController::class, 'store']);

    // -----------------------------------------
    // PRODUCTS (UMKM)
    // -----------------------------------------
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    Route::post('/products/{id}/gambar', [ProductController::class, 'uploadImage']);
    Route::get('/my-products', [ProductController::class, 'myProducts']);

    // Comments on Products
    Route::get('/products/{id}/comments', [CommentController::class, 'productComments']);
    Route::post('/products/{id}/comments', [CommentController::class, 'storeProductComment']);

    // -----------------------------------------
    // PROFILE
    // -----------------------------------------
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::post('/profile', [ProfileController::class, 'update']);
});
