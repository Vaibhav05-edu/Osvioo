<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\User\MediaKitController;

Route::get('/test-mediakit', function() {
    $user = User::first();
    Auth::login($user);
    return app(MediaKitController::class)->create();
});
