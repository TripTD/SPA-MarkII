<?php

Route::get('/spa', function() {
    return view('spa');
});
Route::get('/', 'ClientsController@index');
Route::get('/index', [
    'uses' => 'ClientsController@index',
    'as' => 'Clients.index'
]);

Route::get('/cart', [
    'uses' => 'ClientsController@cart',
    'as' => 'Clients.cart'
]);
Route::post('/sendOrder', [
    'uses' => 'ClientsController@sendOrder',
    'as' => 'Clients.sendOrder'
]);

Route::get('/addToCart/{id}', [
    'uses' => 'ClientsController@addToCart',
    'as' => 'Clients.addToCart'
    ]);
Route::get('/removeFromCart/{id}', [
    'uses' => 'ClientsController@removeFromCart',
    'as' => 'Clients.removeFromCart'
]);



Route::get('/login', [
    'uses' => 'ClientsController@login',
    'as' => 'Clients.login'
]);
Route::post('/postLogin', [
    'uses' => 'AdminsController@postLogin',
    'as' => 'Admins.postLogin'
]);
Route::get('/logout', [
    'uses' => 'AdminsController@logout',
    'as' => 'Admins.logout'
]);

Route::get('/products', ['uses' => 'ProductsController@list', 'as' => 'Products.list'])->middleware(['loggedIn']);
Route::get('/products/{id}', ['uses' => 'ProductsController@destroy', 'as' => 'product.destroy'])->middleware(['loggedIn']);
Route::get('/product/{id}', ['uses' => 'ProductsController@show', 'as' => 'product.show'])->middleware(['loggedIn']);
Route::post('/product', ['uses' => 'ProductsController@store', 'as' => 'product.store'])->middleware(['loggedIn']);
