<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/admin/login', function () {
    Auth::loginUsingId(User::first()->id);

    return redirect(route('filament.admin.pages.dashboard'));
})->name('filament.admin.auth.login');
