<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Route::get('/', 'SiteController@index')->name('home');

Route::post('create','SiteController@pollCreate')->name('createPoll');

Route::post('vote', 'SiteController@vote');

Route::post('login','Auth\LoginController@login')->name('login');

Route::post('register', 'Auth\RegisterController@register')->name('register');

Route::post('logout', 'Auth\LoginController@logout')->name('logout');


/*
 *
 Route::get('/elo',function(){
	$poll = App\Poll::with('options')->whereHas('expires', function($q){
		$q->where('expires', '>', Carbon\Carbon::now());
	})->get();
	return $poll;
});
*/
/*
 * test snippets for implementing cookie I hope we find uses for it one day
 *
 * Route::get('/coo', function (){
    $cookie = cookie()->make('young','made on this day','600');
    return response('made')->withCookie($cookie);
});

Route::get('getcoo', function(){
    if (Cookie::get('young')){ return Cookie::get('young'); } else{ return 'notuhng sert';}
});*/

/* // Authentication Routes...
        $this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
        $this->post('login', 'Auth\LoginController@login');
        $this->post('logout', 'Auth\LoginController@logout')->name('logout');

        // Registration Routes...
        $this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
        $this->post('register', 'Auth\RegisterController@register');
*/