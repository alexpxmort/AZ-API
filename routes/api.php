<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Mail\TestMail;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('/mail/send/{to}/{subject}/{text}',function($to,$subject,$text){

    $details = [
        'text'=>$text,
        'subject'=>$subject,
        'email'=>$to
    ];

    try{
        Mail::to($to)->send(new TestMail($details));
    }catch (Exception $e){
        return  [
            'msg'=>$e->getMessage()
        ];
    }


    return  [
        'msg'=>'route mail works'
    ];
});


Route::get('/mailniver/send/{to}/{nome}/{grupo}',function($to,$nome,$grupo){

    $details = [
        'subject'=>'FELIZ ANIVERSÁRIO!!!',
        'email'=>$to,
        'nome'=>$nome,
        'grupo'=>$grupo
    ];

    try{
        Mail::to($to)->send(new TestMail($details));
    }catch (Exception $e){
        return  [
            'msg'=>$e->getMessage()
        ];
    }


    return  [
        'msg'=>'route mail niver works'
    ];
});




//auth
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'Auth\AuthController@login');
 
    Route::post('register', 'Auth\AuthController@register');

    Route::get('/test',function(){
        return  [
            'msg'=>'route works'
        ];
    });
    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::get('logout', 'Auth\AuthController@logout');
    });

    //password resetting
    Route::group([
        'namespace' => 'Auth',
        'middleware' => 'api',
        'prefix' => 'password'
    ], function () {
        Route::post('request', 'PasswordResetController@store');
        Route::get('request/{token}', 'PasswordResetController@show')->name('password_reset.show');
        Route::post('reset', 'PasswordResetController@reset');
    });

});

