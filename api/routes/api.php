<?php

use Illuminate\Http\Request;

Route::post('login', 'API\AuthController@login'); // аутентификация
Route::post('register', 'API\AuthController@register'); // регистрация

Route::group(['middleware' => 'auth:api'], function(){
	Route::get('me', 'API\AuthController@me');  // получаем данные текущего пользователя

	Route::get('/news/{news}/comments', 'API\NewsController@getComments');  // получаем комментарии к новости
	
	Route::post('/news/{news}/comments', 'API\NewsController@storeComment');  // сохраняем комментарий к новости

	Route::apiResource('news', 'API\NewsController');  // регистрируем роуты (новость)

	Route::apiResource('comments', 'API\CommentController');  // регистрируем роуты (комментарий)
});
