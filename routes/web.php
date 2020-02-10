<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return redirect()->route('home');
});

/*Route::middleware(['auth', 'verified'])->group(function () {*/
    Route::get('/dashboard', 'HomeController@index')->name('home');
    Route::get('/view/document', 'HomeController@viewDoc')->name('viewDocument');

    Route::get('/facilities', 'FacilitiesController@index')->name('facilities');
    Route::get('/facilities/{facility}', 'FacilitiesController@show')->name('facilities.show');
    Route::delete('/facilities/{facility}', 'FacilitiesController@destroy')->name('facilities.destroy');
    Route::post('/facilities', 'FacilitiesController@store')->name('facilities.store');

    Route::get('/facilities/{facility}/visits/view', 'FacilityVisitController@viewVisits')->name('facilities.visits');
    Route::post('/facilities/{facility}/visit', 'FacilityVisitController@visit')->name('facilities.visit');
    Route::post('/facilities/{facility}/visit/upload-doc', 'FacilityVisitController@uploadDoc')->name('facilities.uploadDoc');
    Route::get('/facilities/visit/{facilityVisit}/summary', 'FacilityVisitController@summary')->name('visits.summary');


    Route::post('/facilities/add-docs/{facility}', 'FacilitiesController@addDocs')->name('facilities.add-docs');
    Route::post('/applications/save', 'FacilitiesController@saveNewApplication')->name('saveApplication');

    Route::get('/districtsByProvince/{id}', 'DistrictsController@districtsByProvince');
    Route::get('/sectorsByDistrict/{id}', 'SectorsController@sectorsByDistrict');

    Route::get('/app-types/documents/{id}', 'ApplicationTypeController@appTypeDocs')->name('appTypeDocs');
    Route::get('/applications', 'ApplicationTypeController@appTypeDocs')->name('appTypeDocs');
    Route::get('/my/applications', 'UserApplicationController@index')->name('userApplication');
    Route::get('/facility/documents/{userApplication}/{applicationType}/{user}', 'FacilityDocumentController@find')->name('reviewDocs');
    Route::get('/facility/documents/{document}', 'FacilityDocumentController@viewDoc')->name('viewDoc');

    Route::post('/facility/{facility}/documents/renew', 'FacilityDocumentRenewingController@renew')->name('renew.facility.doc');

    Route::prefix('admin')->group(function () {

        Route::get('/applications/share/to/me', 'ApplicationShareController@index')->name('my.shared.app.all');

        Route::get('/categories', 'CategoriesController@index')->name('categories.all');
        Route::post('/categories', 'CategoriesController@store')->name('category.store');
        Route::get('/categories/{category}', 'CategoriesController@show')->name('category.show');
        Route::delete('/categories/{category}', 'CategoriesController@destroy')->name('category.destroy');

        Route::get('/positions', 'PositionController@index')->name('positions.all');
        Route::post('/positions', 'PositionController@store')->name('positions.store');
        Route::get('/positions/{position}', 'PositionController@show')->name('positions.show');
        Route::delete('/positions/{position}', 'PositionController@destroy')->name('positions.destroy');

        Route::get('/services', 'ServicesController@index')->name('services.all');
        Route::post('/services', 'ServicesController@store')->name('services.store');
        Route::get('/services/{service}', 'ServicesController@show')->name('services.show');
        Route::delete('/services/{service}', 'ServicesController@destroy')->name('services.destroy');

        Route::get('/users', 'UsersController@index')->name('users');
        Route::post('/users', 'UsersController@store')->name('users.store');
        Route::get('/users/{user}', 'UsersController@show')->name('users.show');
        Route::delete('/users/{user}', 'UsersController@destroy')->name('users.destroy');

        Route::get('/documents', 'DocumentController@index')->name('documents.all');
        Route::post('/documents', 'DocumentController@store')->name('documents.store');
        Route::get('/documents/{document}', 'DocumentController@show')->name('documents.show');
        Route::delete('/documents/{document}', 'DocumentController@destroy')->name('documents.destroy');

        Route::get('/app-types', 'ApplicationTypeController@index')->name('app-types.all');
        Route::post('/app-types', 'ApplicationTypeController@store')->name('app-types.store');
        Route::get('/app-types/{applicationType}', 'ApplicationTypeController@show')->name('app-types.show');
        Route::delete('/app-types/{applicationType}', 'ApplicationTypeController@destroy')->name('app-types.destroy');

        Route::get('/facilities', 'FacilitiesController@adminFacilities')->name('adminFacilities');
        Route::post('/updateReview/{userApplication}', 'UserApplicationController@updateReview')->name('updateReview');

        Route::post('/facilities/licence/update/{facility}', 'FacilitiesController@updateLicence')->name('licence.update');
        Route::get('/summary/report', 'ReportsController@summary')->name('summary');


        Route::get('/applications/{application}/comments', 'UserApplicationCommentController@applicationComments')
            ->name('applicationComments');
        Route::post('/applications/{userApplication}/comments', 'UserApplicationCommentController@store')
            ->name('applicationComment.save');

        Route::get('/facility/{facility}/documents/renew', 'FacilityDocumentRenewingController@showRenew')
            ->name('renewal');
        Route::post('/facility/licence/{renewing}/documents/renew', 'FacilityDocumentRenewingController@updateRenew')
            ->name('updateRenew');

        Route::get('/reports/expiring', 'FacilityReportController@expiring')->name('expiring');
        Route::post('/applications/{application}/change/status', 'UserApplicationController@changeStatus')->name('changeStatus');

    });
//});






