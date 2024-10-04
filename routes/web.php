<?php

use App\Livewire\AddUser;
use App\Livewire\AdminLoginForm;
use App\Livewire\CustomerSatisfactionSurvey;

use App\Livewire\Dashboard;
use App\Livewire\EditAdmin;
use App\Livewire\EditSubAdmin;
use App\Livewire\EditUser;
use App\Livewire\EmailConfirmation;
use App\Livewire\SubAdminDashboard;
use App\Livewire\SubAdminLoginForm;
use App\Livewire\Survey2;
use App\Livewire\SurveyExpired;
use App\Livewire\SurveySent;
use App\Livewire\UserClientsStatusList;
use App\Livewire\UserDashboard;
use App\Livewire\UserList;
use App\Livewire\UserStatusList;
use Illuminate\Support\Facades\Route;
use App\Livewire\LoginForm;
use App\Livewire\SignupForm;
use App\Livewire\IdsGroupCreate;
use App\Livewire\IdsGroupList;
use App\Livewire\IdsGroupEdit;

Route::get('/login', LoginForm::class)->name('login');
Route::get('/admin/login', AdminLoginForm::class)->name('admin.login');
Route::get('/subadmin/login', SubAdminLoginForm::class)->name('subadmin.login');
Route::get('/signup', SignupForm::class)->name('signup');

Route::get('/survey/{token}', Survey2::class);
Route::get('/survey/success/{client}', EmailConfirmation::class );
Route::get('/survey/failed/{client}', SurveyExpired::class );


Route::middleware(['auth'])->group(function () {
    Route::get('/survey', CustomerSatisfactionSurvey::class);
    Route::get('/user/dashboard', UserDashboard::class);
    Route::get('/clients', UserClientsStatusList::class );
    Route::get('/user/edit/{userId}', EditUser::class)->name('users.edit.user');
    Route::get('/sent/{email}', SurveySent::class );
});


Route::middleware('auth:admin')->group(function(){
    Route::get('/admin/dashboard', Dashboard::class );
    Route::get('/admin/user/{userId}/edit', EditUser::class)->name('users.edit');
    Route::get('/admin/edit/{adminId}', EditAdmin::class)->name('admins.edit');
    Route::get('/users', UserList::class);
    Route::get('/users-status', UserStatusList::class);
    Route::get('/add-users', AddUser::class);
    Route::get('/ids-groups', IdsGroupList::class)->name('ids-group.list');
    Route::get('/ids-groups/create', IdsGroupCreate::class)->name('ids-group.create');
    Route::get('/ids-groups/{group}/edit', IdsGroupEdit::class)->name('ids-group.edit');

});

Route::group(['middleware' => ['auth:subadmin']], function () {
    Route::get('/subadmin/dashboard', SubAdminDashboard::class)->name('subadmin.dashboard');
    
    
});

Route::middleware(['auth:admin,subadmin'])->group(function() {  
    
    
    Route::get('/subadmin/edit/{subAdminId}', EditSubAdmin::class)->name('subadmin.edit');
});