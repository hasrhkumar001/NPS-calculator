<?php

use App\Livewire\AddUser;
use App\Livewire\AdminLoginForm;
use App\Livewire\CustomerSatisfactionSurvey;

use App\Livewire\Dashboard;
use App\Livewire\EditAdmin;
use App\Livewire\EditSubAdmin;
use App\Livewire\EditUser;
use App\Livewire\EmailConfirmation;
use App\Livewire\NewSidebar;
use App\Livewire\ProfileDetail;
use App\Livewire\SubAdminDashboard;
use App\Livewire\SubAdminLoginForm;
use App\Livewire\SubadminUsersStatus;
use App\Livewire\Survey2;
use App\Livewire\SurveyExpired;
use App\Livewire\SurveySent;
use App\Livewire\UserClientsStatusList;
use App\Livewire\UserDashboard;
use App\Livewire\UserList;
use App\Livewire\UserStatusList;
use Illuminate\Support\Facades\Route;
use App\Livewire\LoginForm;

use App\Livewire\IdsGroupCreate;
use App\Livewire\IdsGroupList;
use App\Livewire\IdsGroupEdit;
use App\Http\Middleware\RoleMiddleware;

Route::get('/', function () {
   
    return redirect( route('login') );
});

Route::get('/login', LoginForm::class)->name('login');
// Route::get('/admin/login', AdminLoginForm::class)->name('admin.login');
// Route::get('/subadmin/login', SubAdminLoginForm::class)->name('subadmin.login');

Route::get('profile/{userId}',ProfileDetail::class)->name('profile.detail') ;
Route::get('/customersatifactionsurvey/{token}', Survey2::class);
Route::get('/survey/success', EmailConfirmation::class );
Route::get('/survey/failed', SurveyExpired::class );
Route::get('/newsidebar',NewSidebar::class);


Route::middleware(['auth'])->group(function () {
    Route::get('/survey', CustomerSatisfactionSurvey::class);
    Route::get('/user/edit/{userId}', EditUser::class)->name('users.edit.user');
    Route::get('/sent/{email}', SurveySent::class );
    Route::get('/admin/user/{userId}/edit', EditUser::class)->name('users.edit');

});


Route::middleware(RoleMiddleware::class.':1')->group(function(){
    Route::get('/user', UserDashboard::class);
    Route::get('/survey-status', UserClientsStatusList::class );
});

Route::middleware(RoleMiddleware::class.':2')->group(function(){
    Route::get('/subadmin', SubAdminDashboard::class)->name('subadmin.dashboard');
    Route::get('/users-surveys-status', SubadminUsersStatus::class);
    Route::get('/subadmin/edit/{subAdminId}', EditSubAdmin::class)->name('subadmin.edit');
});

Route::middleware(RoleMiddleware::class.':3')->group(function(){
    Route::get('/admin', Dashboard::class );
    Route::get('/admin/edit/{adminId}', EditAdmin::class)->name('admins.edit');
    Route::get('/users', UserList::class);
    Route::get('/all-surveys-status', UserStatusList::class);
    Route::get('/add-users', AddUser::class);
    Route::get('/ids-groups', IdsGroupList::class)->name('ids-group.list');
    Route::get('/ids-groups/create', IdsGroupCreate::class)->name('ids-group.create');
    Route::get('/ids-groups/{group}/edit', IdsGroupEdit::class)->name('ids-group.edit');
});

Route::group(['middleware' => ['auth:subadmin']], function () {
    
    
});

Route::middleware(['auth:admin,subadmin'])->group(function() {  
    
    

});