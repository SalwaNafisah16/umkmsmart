<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForumPostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SaveController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'));

/*
|--------------------------------------------------------------------------
| AUTH (Laravel Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| DASHBOARD REDIRECT (SETELAH LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'mahasiswa') {
        return redirect('/dashboard/mahasiswa');
    }

    if ($user->role === 'umkm') {
        return redirect('/umkm/dashboard');
    }

    abort(403);
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| MAHASISWA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {

    // DASHBOARD
    Route::get('/dashboard/mahasiswa',
        [DashboardController::class, 'mahasiswa']
    )->name('dashboard.mahasiswa');

    // POSTINGAN SAYA
    Route::get('/mahasiswa/posts',
        [ForumPostController::class, 'myPosts']
    )->name('mahasiswa.posts');

    // POST DISIMPAN
    Route::get('/mahasiswa/saved',
        [SaveController::class, 'index']
    )->name('mahasiswa.saved');

    // KATALOG PRODUK UMKM
    Route::get('/mahasiswa/produk', function () {
    return view('dashboard.mahasiswa.produk', [
        'products' => \App\Models\Product::where('status','aktif')
            ->latest()
            ->paginate(9)
    ]);
}   )->name('mahasiswa.produk');

  Route::get('/produk/{product}', function (\App\Models\Product $product) {
            return view('dashboard.mahasiswa.detail', compact('product'));
        })->name('mahasiswa.produk.show');
        
        Route::get('/mahasiswa/profile', fn() =>
        view('dashboard.mahasiswa.profile')
        )->name('mahasiswa.profile');

        Route::post('/mahasiswa/profil', 
        [ProfileController::class, 'update']
    )->name('mahasiswa.profile.update');




});

/*
|--------------------------------------------------------------------------
| UMKM
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:umkm'])
    ->prefix('umkm')
    ->name('umkm.')
    ->group(function () {

        // DASHBOARD UMKM
        Route::get('/dashboard',
            [DashboardController::class, 'umkm']
        )->name('dashboard');

        // CRUD PRODUK
        Route::resource('products', ProductController::class);

        // KOMENTAR MASUK
        Route::get('/comments',
            [CommentController::class, 'umkmIndex']
        )->name('comments');

        Route::get('/profile', fn () =>
            view('dashboard.umkm.profile')
        )->name('profile');

        Route::get('/profil', [ProfileController::class,'index'])->name('profil.index');
    Route::post('/profil', [ProfileController::class,'update'])->name('profil.update');

    });



/*
|--------------------------------------------------------------------------
| FORUM & AKSI GLOBAL (LOGIN WAJIB)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // CREATE POST
    Route::post('/forum-post',
        [ForumPostController::class, 'store']
    )->name('forum.post.store');

    // DELETE POST
    Route::delete('/forum-post/{forumPost}',
        [ForumPostController::class, 'destroy']
    )->name('forum.post.destroy');

    // EDIT POST
    Route::get('/forum-post/{forumPost}/edit',
        [ForumPostController::class, 'edit']
    )->name('forum-post.edit');

    // UPDATE POST
    Route::put('/forum-post/{forumPost}',
        [ForumPostController::class, 'update']
    )->name('forum-post.update');

    // KOMENTAR
    Route::post('/comment',
        [CommentController::class, 'store']
    )->name('comment.store');

    // LIKE
    Route::post('/post/{id}/like',
        [LikeController::class, 'toggle']
    )->name('post.like');

    // SAVE / UNSAVE
    Route::post('/post/{id}/save',
        [SaveController::class, 'toggle']
    )->name('post.save');

    Route::get('/profil', [ProfileController::class, 'index'])
        ->name('profil.index');

    // update profil (mahasiswa / umkm)
    Route::post('/profil', [ProfileController::class, 'update'])
        ->name('profil.update');
});

Route::middleware(['auth'])
    ->get('/search', [\App\Http\Controllers\SearchController::class, 'index'])
    ->name('search');



