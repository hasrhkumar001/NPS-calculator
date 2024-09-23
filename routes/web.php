<?php

use App\Livewire\AddUser;
use App\Livewire\CustomerSatisfactionSurvey;

use App\Livewire\Dashboard;
use App\Livewire\EmailConfirmation;
use App\Livewire\Survey2;
use App\Livewire\UserList;
use App\Livewire\UserStatusList;
use Illuminate\Support\Facades\Route;
use App\Livewire\LoginForm;
use App\Livewire\SignupForm;
use App\Livewire\IdsGroupCreate;
use App\Livewire\IdsGroupList;
use App\Livewire\IdsGroupEdit;

Route::get('/login', LoginForm::class)->name('login');
Route::get('/signup', SignupForm::class)->name('signup');



Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', CustomerSatisfactionSurvey::class);
    Route::get('/survey2', Survey2::class)->name('survey2');
    Route::get('/email-sent/{email}', EmailConfirmation::class )->name('email-sent');;
});


Route::middleware('auth:admin')->group(function(){
    Route::get('/admin/dashboard', Dashboard::class );
    
    Route::get('/users',UserList::class);
    Route::get('/users-status',UserStatusList::class);
    Route::get('/add-users',AddUser::class);
    Route::get('/ids-groups', IdsGroupList::class)->name('ids-group.list');
    Route::get('/ids-groups/create', IdsGroupCreate::class)->name('ids-group.create');
    // Route::get('/ids-groups/{group}/edit', IdsGroupEdit::class)->name('ids-group.edit');
});