<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Shared\Traits\Instances\Response;

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

Route::group([
    "prefix" => "v1",
], function(){
    Route::get("/", function(){

        return response()->json(
            (new Response() )
                ->httpUnauthorizedResponse()
                ->respond()
            );
    });

    Route::group([
        'prefix' => 'auth',
        'namespace' => 'Auth'
    ], function () {
        Route::post('login', "TokenController@login")->name('auth.login');
        Route::post("define", "UserController@define")->name('create'); // Create user
        Route::post("register", "UserController@register")->name('register'); // Create Entities and user

        Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::get('user', function (Request $request) {

                if ($request->user() === null) {
                    return Response::respond([
                        "code" => 401,
                        "message" => "You are not logged in",
                    ]);
                }

                $user = $request->user();

                return Response::respond([
                    "code" => 200,
                    "message" => "Successfully retrieved user.",
                    "data" => [
                        "user" => $user,
                    ],
                ]);
            });
            Route::post('logout', function (Request $request) {
                $request->user()->currentAccessToken()->delete();
                return Response::respond([
                    "code" => 200,
                    "message" => "Successfully logged out a user."
                ]);
            });
        });
    });

    Route::group([
        'middleware' => 'auth:sanctum'
    ], function(){
        Route::group([
            'prefix' => 'users',
            'namespace' => 'Auth'
        ], function () {
            Route::get("all", "UserController@all");
            Route::post('delete/{id}', 'UserController@delete');
            Route::post("define", "UserController@define");
            Route::get("fetch/{id}", "UserController@fetch");
            Route::get("search", "UserController@search");
        });

        Route::group([
            "prefix" => "entities",
            "namespace" => "Entities"
        ], function () {

            Route::get("all", "EntityController@all");
            Route::post("create", "EntityController@create");
            Route::post('update/{entity_id}', 'EntityController@update');
            Route::post('delete/{entity_id}', 'EntityController@delete');
            Route::get("fetch/{entity_id}", "EntityController@fetch");
            Route::get("search", "EntityController@search");
        });


        Route::group([
            "prefix" => "activities",
            "namespace" => "Activities"
        ], function () {

            Route::get("all", "ActivityController@all");
            Route::post('delete/{id}', 'ActivityController@delete');
            Route::post("define", "ActivityController@define");
            Route::get("fetch/{id}", "ActivityController@fetch");
            Route::get("search", "ActivityController@search");
        });


        Route::group([
            "prefix" => "participants",
            "namespace" => "Participants"
        ], function () {

            Route::get("all", "ParticipantController@all");
            Route::post('delete/{id}', 'ParticipantController@delete');
            Route::post("define", "ParticipantController@define");
            Route::post("creation", "ParticipantController@creation");
            Route::get("fetch/{id}", "ParticipantController@fetch");
            Route::get("search", "ParticipantController@search");
        });


        Route::group([
            "prefix" => "trees",
            "namespace" => "Trees"
        ], function () {

            Route::get("all", "TreeController@all");
            Route::post('delete/{id}', 'TreeController@delete');
            Route::post("define", "TreeController@define");
            Route::get("fetch/{id}", "TreeController@fetch");
            Route::get("search", "TreeController@search");
        });

    });


    Route::group([
        "prefix" => "variables",
        "namespace" => "Variables"
    ], function() {
        Route::get("all", "VariablesController@all" );
        Route::post("delete/{id}", "VariablesController@delete" );
        Route::post("define", "VariablesController@define" );
        Route::get("fetch/{id}", "VariablesController@fetch" );
        Route::get("search", "VariablesController@search" );
        Route::get("of/{type}", "VariablesController@fetchByType" );
    });


});
