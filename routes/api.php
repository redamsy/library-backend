<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('register', 'API\PassportController@register');
Route::post('login', 'API\PassportController@login');
Route::group(['middleware' => 'auth:api'], function() {
    //logout user-> revoke token
    Route::post('logout', 'API\PassportController@logout');
    //get logged in user info
    Route::get('me', 'API\PassportController@getAuthenticatedUser');
    //create an admin
    Route::post('admin', 'AdminsController@store');

    // List all authors
    Route::get('authors', 'AuthorsController@index');
    // List single author
    Route::get('author/{id}', 'AuthorsController@show');
    // Create new author
    Route::post('author', 'AuthorsController@store');
    // Update author
    Route::post('author/{id}', 'AuthorsController@update');//only in the case of upload files make the update post not put
    // Delete author
    Route::delete('author/{id}', 'AuthorsController@destroy');

    // List all categories
    Route::get('categories', 'CategoriesController@index');
    // List single category
    Route::get('category/{id}', 'CategoriesController@show');
    // Create new category
    Route::post('category', 'CategoriesController@store');
    // Update category
    Route::put('category/{id}', 'CategoriesController@update');
    // Delete category
    Route::delete('category/{id}', 'CategoriesController@destroy');

    // List all languages
    Route::get('languages', 'LanguagesController@index');
    // List single language
    Route::get('language/{id}', 'LanguagesController@show');
    // Create new language
    Route::post('language', 'LanguagesController@store');
    // Update language
    Route::put('language/{id}', 'LanguagesController@update');
    // Delete language
    Route::delete('language/{id}', 'LanguagesController@destroy');

    // List all publishers
    Route::get('publishers', 'PublishersController@index');
    // List single publisher
    Route::get('publisher/{id}', 'PublishersController@show');
    // Create new publisher
    Route::post('publisher', 'PublishersController@store');
    // Update publisher
    Route::put('publisher/{id}', 'PublishersController@update');
    // Delete publisher
    Route::delete('publisher/{id}', 'PublishersController@destroy');

    // List all series
    Route::get('series', 'SeriesController@index');
    // List single serie
    Route::get('serie/{id}', 'SeriesController@show');
    // Create new serie
    Route::post('serie', 'SeriesController@store');
    // Update serie
    Route::put('serie/{id}', 'SeriesController@update');
    // Delete serie
    Route::delete('serie/{id}', 'SeriesController@destroy');

    // List all clients
    Route::get('clients', 'ClientsController@index');
    // List single client
    Route::get('client/{id}', 'ClientsController@show');
    // Update client
    Route::put('client/{id}', 'ClientsController@update');
    // Delete client
    Route::delete('client/{id}', 'ClientsController@destroy');

    // List all books
    Route::get('books', 'BooksController@index');
    // List single book
    Route::get('book/{id}', 'BooksController@show');
    // Create new book
    Route::post('book', 'BooksController@store');
    // Update book
    Route::post('book/{id}', 'BooksController@update');//only in the case of upload files make the update post not put
    // Delete book
    Route::delete('book/{id}', 'BooksController@destroy');

    // List all bookAuthors
    Route::get('bookAuthors', 'BookAuthorsController@index');
    // Create new bookAuthor
    Route::post('bookAuthor', 'BookAuthorsController@store');
    // Update bookAuthor
    Route::post('bookAuthor/{id}', 'BookAuthorsController@update');
    // Delete bookAuthor
    Route::delete('bookAuthor/{id}', 'BookAuthorsController@destroy');

    // List all bookCategories
    Route::get('bookCategories', 'BookCategoriesController@index');
    // Create new bookCategory
    Route::post('bookCategory', 'BookCategoriesController@store');
    // Update bookCategory
    Route::put('bookCategory/{id}', 'BookCategoriesController@update');
    // Delete bookCategory
    Route::delete('bookCategory/{id}', 'BookCategoriesController@destroy');

    // List all bookClients
    Route::get('bookClients', 'BookClientsController@index');
    // Create new bookClient
    Route::post('bookClient', 'BookClientsController@store');
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
