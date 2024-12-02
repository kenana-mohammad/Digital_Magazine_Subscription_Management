<?php

use App\Http\Controllers\Dash_Publish\ArticleController;
use App\Http\Controllers\Dashboard\Comments\CommentController;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\Dash_MagazineController;
use App\Http\Controllers\Dashboard\Dash_SubscriptionController;
use App\Http\Controllers\app\Subscription\AppSubscriptionController;

use Illuminate\Bus\Queueable;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix' => 'auth'], function () {
    Route::controller(AuthController::class)->group(function () {
      Route::Post('register','register')->name('auth.register_user');
      Route::Post('login','login')->name('auth.login_user');
//logout
Route::Post('logout','logout')->name('auth.logout')->middleware('auth:api');

    });

});
Route::group(['prefix' => 'dash'], function () {
    
    Route::group(['middleware' => ['auth:api']], function () {


            Route::controller(Dash_MagazineController::class)->group(function () {

            Route::Post('create-magazine','create_magazine')->name('auth.create_magazine');
              //managment magazines only admin uses policy
              Route::group(['middleware' => ['role:admin']], function () {

              Route::get('get-magazines','get_magazines')->name('dash.get_magazines');
              Route::PUT('update-magazine/{magazine}','update_magazine')->name('dash.update_magazine');
              Route::delete('delete-magazine/{magazine}','delete_magazine')->name('dash.delete_magazine');

        // });


    });});
    //add article
    Route::controller(ArticleController::class)->group(function () {
        Route::Post('add-article/{magazine}','add_article')->name('auth.add_article');

    });
    Route::group(['middleware' => ['role:admin']], function () {

        //managment subscripation in dashboard 
        Route::controller(Dash_SubscriptionController::class)->group(function () {
            Route::get('get-subscrations','get_subscraptions')->name('dash.get_subscraptions');
              //change state 
              Route::PUT('change-status-subscripte/{subscription}','change_status_subscripte')->name('dash.change_status_subscripte');
               //delete subscripte
               Route::Delete('delete-subscripte/{subscription}','delete_subscripte')->name('dash.delete_subscripte');
 
        });
        Route::controller(CommentController::class)->group(function () {

        Route::Post('ban-comment/{comment}','ban_comment')->name('auth.bann');
        });
    });
    });
});
Route::group(['prefix' => 'app'], function () {
    
    Route::group(['middleware' => ['auth:api']], function () {
        Route::group(['middleware' => ['role:subscriber']], function () {


            ///subscripe
            Route::controller(AppSubscriptionController::class)->group(function () {
            
            Route::Post('add-subscripe/{magazine}','add_subscripte')->name('auth.subscripte');
            Route::Post('add-payment/{subscription}','payment')->name('auth.payment');
        //get articles 
        Route::get('get-articles/{magazine}','get_articles')->name('auth.articles');
//get  article
Route::get('get-article/{magazine}/{article}','get_article')->name('auth.article');
//add comment
Route::Post('add-comment/{magazine}/{article}','add_comment')->name('auth.add_comment');

                });
            });
    });
});

