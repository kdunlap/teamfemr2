<?php
use App\Survey;

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


//Route::get('contact','EmailController@index');
//Route::post('contact_request','EmailController@createRegister');

Route::get('/', function () {
    //echo 'Welcome to my site';
    return view('welcome');
});

Route::get('tripdatabase', 'TripDatabaseController@index');
Route::get('literaturebank', 'LiteratureBankController@index');
Route::get('discussionboard', 'discussionboardController@index');

Route::get('/emails',array('as'=>'newRegister','uses'=>'EmailController@index'));
Route::post('/register',array('as'=>'createRegister','uses'=>'EmailController@createRegister'));



Route::get('/users/xml', function() {
	$surveys = Survey::all();
	$xml = new XMLWriter();
	$xml->openMemory();
	$xml->startDocument();
	$xml->startElement('markers');
	foreach($surveys as $survey) {
		$xml->startElement('marker');
		$xml->writeAttribute('id', $survey->id);
		$xml->writeAttribute('teamname', $survey->teamname);
		$xml->writeAttribute('lat', $survey->lat);
		$xml->writeAttribute('lng', $survey->lng);
		$xml->endElement();
	}
	$xml->endElement();
	$xml->endDocument();

	$content = $xml->outputMemory();
	$xml = null;

	return response($content)->header('Content-Type', 'text/xml');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
//sending emails
Route::get('/emails', 'EmailController@index');
Route::get('/emails/test', 'EmailController@index');
Route::get('/emails/register', 'EmailController@index');


Route::group(['middleware' => 'web'], function () {
	Route::get('/tripsurvey', 'TripSurveyController@index');
	Route::get('/tripsurvey/create', 'TripSurveyController@create');
	Route::post('/tripsurvey', 'TripSurveyController@store');
	Route::get('/tripsurvey/{id}', 'TripSurveyController@show');

    Route::auth();

	Route::group([ 'middleware' => 'auth' ], function ()
	{
		Route::get('/home', 'HomeController@index');
		Route::get('/home/{user}', 'HomeController@test');

	});

	Route::group(['middleware' => 'web'], function () {
		Route::get('/litbanksurvey', 'LiteratureBankSurveyController@index');
		Route::get('/litbanksurvey/create', 'LiteratureBankSurveyController@create');
		Route::post('/litbanksurvey', 'LiteratureBankSurveyController@store');
		Route::get('/litbanksurvey/{id}', 'LiteratureBankSurveyController@show');

		Route::auth();

		Route::group(['middleware' => 'auth'], function () {
			Route::get('/home', 'HomeController@index');
			Route::get('/home/{user}', 'HomeController@test');

		});
	});
});

