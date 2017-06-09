<?php


$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['prefix' => 'v1'], function ($api) {

    $api->group(['namespace' => 'App\Http\Controllers\Api\V1\Customer'], function ($api) {

        $api->any('/customer/index', 'CustomerController@Index');
    });

    $api->group(['namespace' => 'App\Http\Controllers\Api\V1\Search'], function ($api) {
        $api->any('/search/index', 'SearchController@Index');
    });

});

