<?php


use App\Rules\NRIC;
use App\Services\Signups\SignupServices;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

Route::group([
    "prefix" => "tools",
], function(){
    // Routes for tooling.
    Route::get("hash/{id}", function( $id ){
        dd( sessioned_hash ( $id ) );
    });
});
Route::group([
    "prefix" => "tests",
], function(){
    // Routes for testing.
});
