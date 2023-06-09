<?php

use RealDriss\ACL\Http\Controllers\Auth\ForgotPasswordController;
use RealDriss\ACL\Http\Controllers\Auth\LoginController;
use RealDriss\ACL\Http\Controllers\Auth\ResetPasswordController;
use RealDriss\ACL\Http\Controllers\UserController;

/**
 * level 0 -> namespace { RealDriss\ACL\Http\Controllers }, middleware { web, core } //general
 * level 0.0 -> prefix { BaseHelper::getAdminPrefix() } /admin
 * level 0.0.0 -> middleware { guest } *authenticated == false
 * level 0.0.1 -> middleware { auth } *authenticated == true
 * level 0.1 -> prefix { BaseHelper::getAdminPrefix() }, middleware { auth }
 * level 0.1.0 -> prefix {}
*/
Route::group(['namespace' => 'RealDriss\ACL\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::group(['prefix' => BaseHelper::getAdminPrefix()], function () {
        Route::group(['middleware' => 'guest'], function () {

            Route::get('login', [LoginController::class, 'showLoginForm'])->name('access.login');
            Route::post('login', [LoginController::class, 'login'])->name('access.login.post');

            Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
                ->name('access.password.request');
            Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
                ->name('access.password.email');

            Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
                ->name('access.password.reset');
            Route::post('password/reset', [ResetPasswordController::class, 'reset'])
                ->name('access.password.reset.post');
        });

        Route::group(['middleware' => 'auth'], function () {
            Route::get('logout', [LoginController::class, 'logout'])
                ->name('access.logout');

            // Route::get('logout', [
            //     'as'         => 'access.logout',
            //     'uses'       => 'Auth\LoginController@logout',
            //     'permission' => false,
            // ]);
        });
    });

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'system'], function () {

            Route::group(['prefix' => 'users', 'as' => 'users.'], function () {

                Route::resource('', 'UserController')->except(['edit', 'update'])->parameters(['' => 'users']);

                Route::delete('items/destroy', [
                    'as'         => 'deletes',
                    'uses'       => 'UserController@deletes',
                    'permission' => 'users.destroy',
                    'middleware' => 'preventDemo',
                ]);

                Route::post('update-profile/{id}', [
                    'as'         => 'update-profile',
                    'uses'       => 'UserController@postUpdateProfile',
                    'permission' => false,
                    'middleware' => 'preventDemo',
                ]);

                Route::post('modify-profile-image/{id}', [
                    'as'         => 'profile.image',
                    'uses'       => 'UserController@postAvatar',
                    'permission' => false,
                ]);

                Route::post('change-password/{id}', [
                    'as'         => 'change-password',
                    'uses'       => 'UserController@postChangePassword',
                    'permission' => false,
                    'middleware' => 'preventDemo',
                ]);

                Route::get('profile/{id}', [
                    'as'         => 'profile.view',
                    'uses'       => 'UserController@getUserProfile',
                    'permission' => false,
                ]);

                Route::get('make-super/{id}', [
                    'as'         => 'make-super',
                    'uses'       => 'UserController@makeSuper',
                    'permission' => ACL_ROLE_SUPER_USER,
                ]);

                Route::get('remove-super/{id}', [
                    'as'         => 'remove-super',
                    'uses'       => 'UserController@removeSuper',
                    'permission' => ACL_ROLE_SUPER_USER,
                    'middleware' => 'preventDemo',
                ]);
            });

            Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
                Route::resource('', 'RoleController')->parameters(['' => 'roles']);

                Route::delete('items/destroy', [
                    'as'         => 'deletes',
                    'uses'       => 'RoleController@deletes',
                    'permission' => 'roles.destroy',
                ]);

                Route::get('duplicate/{id}', [
                    'as'         => 'duplicate',
                    'uses'       => 'RoleController@getDuplicate',
                    'permission' => 'roles.create',
                ]);

                Route::get('json', [
                    'as'         => 'list.json',
                    'uses'       => 'RoleController@getJson',
                    'permission' => 'roles.index',
                ]);

                Route::post('assign', [
                    'as'         => 'assign',
                    'uses'       => 'RoleController@postAssignMember',
                    'permission' => 'roles.edit',
                ]);
            });
        });

    });

    Route::get('admin-theme/{theme}', [UserController::class, 'getTheme'])->name('admin.theme');
});
