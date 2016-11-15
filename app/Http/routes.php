<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/test',['uses'=>'HomeController@getTest']);


// frontend
Route::get('/usf', function() {
    return view('frontend.index');
});
Route::get('/usf-soon', function() {
    return view('frontend.index-pdf');
});

Route::get('/notification', function() {
    return view('templates.navbars.notification-mobile');
});

// Route::get('/add', function() {
//     return view('auth.add_email_socmed');
// });

// Route::get('/admin-profile', function() {
//     return view('.index');
// });

Route::group(['prefix'=>'users','as'=>'user'],function(){
    Route::get('/{user_id}/update',['uses'=>'UserController@getUpdate','as'=>'.update']);
    Route::post('/{user_id}/update',['uses'=>'UserController@postUpdate','as'=>'.update.post']);
    Route::post('/create_panelist',['uses'=>'UserController@postCreatePanelist','as'=>'.create_panelist.post']);
    Route::post('/{user_id}/edit_profile',['uses'=>'UserController@postEditProfile','as'=>'.edit_profile.post']);
    Route::post('/{user_id}/edit_profile/name',['uses'=>'UserController@postEditProfileName','as'=>'.edit_profile.name.post']);
    Route::post('/{user_id}/edit_profile/email',['uses'=>'UserController@postEditProfileEmail','as'=>'.edit_profile.email.post']);
    Route::post('/{user_id}/edit_profile/new_password',['uses'=>'UserController@postEditProfileNewPassword','as'=>'.edit_profile.new_password.post']);
    Route::post('/{user_id}/edit_profile/change_password',['uses'=>'UserController@postEditProfileChangePassword','as'=>'.edit_profile.change_password.post']);
    Route::get('/create',['uses'=>'UserController@getCreate','as'=>'.create']);
    Route::post('/create',['uses'=>'UserController@postCreate','as'=>'.create.post']);
    Route::post('/{user_id}/delete',['uses'=>'UserController@postDelete','as'=>'.delete.post']);
    Route::get('/{user_id}',['uses'=>'UserController@getRead','as'=>'.read']);
    Route::get('/',['uses'=>'UserController@getIndex','as'=>'']);
    Route::post('/update-picture',['uses'=>'UserController@postUpdatePicture','as'=>'.update_picture.post']);
    Route::get('/disconnect_socmed/{source}',['uses'=>'UserController@getDisconnectSocmed','as'=>'.disconnect_socmed']);

    Route::get('/{user_id}/sync_facebook_account',['uses'=>'UserController@getSyncFacebookAccount','as'=>'.sync_facebook_account']);
    Route::get('/{user_id}/sync_twitter_account',['uses'=>'UserController@getSyncTwitterAccount','as'=>'.sync_twitter_account']);
    Route::get('/{user_id}/sync_google_plus_account',['uses'=>'UserController@getSyncGooglePlusAccount','as'=>'.sync_google_plus_account']);
});

//auth
Route::group(['prefix'=>'auth','namespace'=>'Auth','as'=>'auth.'],function(){
    Route::get('redirect_twitter',['uses'=>'AuthController@getRedirectTwitter','as'=>'redirect_twitter']);
    Route::get('twitter_callback',['uses'=>'AuthController@getTwitterCallback','as'=>'twitter_callback']);
    Route::get('twitter_registration',['uses'=>'AuthController@getTwitterRegistration','as'=>'twitter_registration']);

    Route::get('facebook_redirect',['uses'=>'AuthController@getFacebookRedirect','as'=>'facebook_redirect']);
    Route::get('facebook_callback',['uses'=>'AuthController@getFacebookCallback','as'=>'facebook_callback']);
    Route::get('facebook_registration',['uses'=>'AuthController@getFacebookRegistration','as'=>'facebook_registration']);

    Route::get('google_plus_redirect',['uses'=>'AuthController@getGooglePlusRedirect','as'=>'google_plus_redirect']);
    Route::get('google_plus_callback',['uses'=>'AuthController@postGooglePlusCallback','as'=>'google_plus_callback']);
    Route::get('google_plus_registration',['uses'=>'AuthController@getGooglePlusRegistration','as'=>'google_plus_registration']);

    Route::post('add_socmed_email/{source}',['uses'=>'AuthController@postAddSocmedEmail','as'=>'add_socmed_email.post']);
    Route::get('add_socmed_email/{source}',['uses'=>'AuthController@getAddSocmedEmail','as'=>'add_socmed_email']);

    Route::post('integrate_socmed_email/{source}',['uses'=>'AuthController@postIntegrateSocmedEmail','as'=>'integrate_socmed_email.post']);
    Route::post('login_basic',['uses'=>'AuthController@postLoginBasic','as'=>'login_basic.post']);
    Route::post('logout',['uses'=>'AuthController@postLogout','as'=>'logout.post']);
    Route::get('login',['uses'=>'AuthController@getLogin','as'=>'login']);
    Route::post('register',['uses'=>'AuthController@postRegister','as'=>'register.post']);
    Route::get('forgot_password',['uses'=>'AuthController@getForgotPassword','as'=>'forgot_password']);
    Route::post('forgot_password',['uses'=>'AuthController@postForgotPassword','as'=>'forgot_password']);
    Route::get('reset_password/{token}',['uses'=>'AuthController@getResetPassword','as'=>'reset_password']);
    Route::post('reset_password/{token}',['uses'=>'AuthController@postResetPassword','as'=>'reset_password.post']);

    //we use the id to hide the token from user
    Route::get('/confirmation_email_sent/{id}',['uses'=>'AuthController@getConfirmationEmailSent','as'=>'confirmation_email_sent']);
    //we use the id to hide the token from user
    Route::post('/resend_confirmation_email/{id}',['uses'=>'AuthController@postResendConfirmationEmail','as'=>'resend_confirmation_email.post']);

    Route::get('/confirmation_token/{token}',['uses'=>'AuthController@getConfirmationToken','as'=>'confirmation_token']);
});

//CRUD article
Route::group(['prefix'=>'articles','as'=>'article'],function(){
    Route::get('{article_id}/mark',['as'=>'.mark','uses'=>'ArticleController@getMark']);
    Route::get('{article_id}/unmark',['as'=>'.unmark','uses'=>'ArticleController@getUnmark']);
    Route::get('{article_id}/vote',['as'=>'.vote','uses'=>'ArticleController@getVote']);
    Route::get('{article_id}/unvote',['as'=>'.unvote','uses'=>'ArticleController@getUnvote']);
    Route::post('{article_id}/close',['as'=>'.close.post','uses'=>'ArticleController@postClose']);
    Route::get('{article_id}/update_summary',['as'=>'.update_summary','uses'=>'ArticleController@getUpdateSummary']);
    Route::post('{article_id}/update_summary',['as'=>'.update_summary.post','uses'=>'ArticleController@postUpdateSummary']);
    Route::post('/{article_id}/delete_summary',['as'=>'.delete_summary.post','uses'=>'ArticleController@postDeleteSummary']);
    Route::get('create',['as'=>'.create','uses'=>'ArticleController@getCreate']);
    Route::post('create',['as'=>'.create.post','uses'=>'ArticleController@postCreate']);
    Route::get('/{article_id}/update',['as'=>'.update','uses'=>'ArticleController@getUpdate']);
    Route::post('/{article_id}/update',['as'=>'.update.post','uses'=>'ArticleController@postUpdate']);
    Route::post('/{article_id}/delete',['as'=>'.delete.post','uses'=>'ArticleController@postDelete']);
    Route::get('mine',['as'=>'.mine','uses'=>'ArticleController@getMine']);
    Route::get('{id}',['as'=>'.read','uses'=>'ArticleController@getRead' ]);
    Route::get('/{article_id}/share_link',['as'=>'.share_link','uses'=>'ArticleController@getShareLink']);
    Route::post('/{article_id}/change_privacy',['as'=>'.change_privacy.post','uses'=>'ArticleController@postChangePrivacy']);
});

//CRUD comment
Route::group(['prefix'=>'comments','as'=>'comment'],function (){
    Route::post('create/{article_id}',['as'=>'.create.post','uses'=>'CommentController@postCreate']);
    Route::post('/{comment_id}/delete',['as'=>'.delete','uses'=>'CommentController@postDelete']);
    Route::get('/{comment_id}/hide',['as'=>'.hide','uses'=>'CommentController@getHide']);
    Route::get('/{comment_id}/unhide',['as'=>'.unhide','uses'=>'CommentController@getUnhide']);
    Route::get('/{comment_id}/vote',['as'=>'.vote','uses'=>'CommentController@getVote']);
    Route::get('/{comment_id}/unvote',['as'=>'.unvote','uses'=>'CommentController@getUnvote']);
});

Route::group(['prefix'=>'article_categories','as'=>'article_category'],function(){
    Route::get('/{article_category_id}/update',['as'=>'.update','uses'=>'ArticleCategoryController@getUpdate']);
    Route::post('/{article_category_id}/update',['as'=>'.update.post','uses'=>'ArticleCategoryController@postUpdate']);
    Route::get('/{article_category_id}/delete',['as'=>'.delete','uses'=>'ArticleCategoryController@getDelete']);
    Route::get('/create',['as'=>'.create','uses'=>'ArticleCategoryController@getCreate']);
    Route::post('/create',['as'=>'.create.post','uses'=>'ArticleCategoryController@postCreate']);
    Route::get('/',['uses'=>'ArticleCategoryController@getIndex']);
});

Route::group(['prefix'=>'images','as'=>'image','namespace'=>'Image'],function(){
    Route::group(['prefix'=>'articles','as'=>'.article'],function(){
        Route::post('/{article_id}/upload',['as'=>'.upload','uses'=>'ArticleController@postUpload']);
        Route::post('/{article_id}/delete',['as'=>'.delete','uses'=>'ArticleController@postDelete']);
    });
});


Route::group(['as'=>'home'],function(){
    Route::get('/panelists',['as'=>'.panelist','uses'=>'HomeController@getPanelists']);
    Route::post('/contact',['as'=>'.contact.post','uses'=>'HomeController@postContact']);
    Route::get('/',['uses'=>'HomeController@getHome']);
    Route::get('/howto',['uses'=>'HomeController@getHowto','as'=>'.howto']);
    Route::get('/settings',['uses'=>'HomeController@getSettings','as'=>'.setting']);
    Route::get('/notification-redirect/object_id/{object_id}/object_type/{object_type}/action/{action}',
        ['uses'=>'HomeController@getNotificationRedirect','as'=>'.notification_redirect']);
    Route::get('/about',['uses'=>'HomeController@getAbout','as'=>'.about']);
    Route::get('/tos',['uses'=>'HomeController@getTos','as'=>'.tos']);
    Route::get('/help',['uses'=>'HomeController@getHelp','as'=>'.help']);
    Route::get('/privacy-policy',['uses'=>'HomeController@getPolicy','as'=>'.privacy-policy']);
    Route::get('/ucp-rules',['uses'=>'HomeController@getRules','as'=>'.ucp-rules']);
    Route::get('/contact',['uses'=>'HomeController@getContact','as'=>'.contact']);
    Route::get('/notifications',['uses'=>'HomeController@getNotification','as'=>'.notification']);
});

Route::group(['domain'=>'twitter.com','as'=>'twitter'],function(){
    Route::get('/intent/tweet',['as'=>'.tweet']);
});

Route::group(['as'=>'api.v1','namespace'=>'Api\V1','prefix'=>'api/v1'],function(){
    Route::group(['prefix'=>'articles','as'=>'.article'],function(){
        Route::post('/{article_id}/update_share_count',['uses'=>'ArticleController@postUpdateShareCount','as'=>'.update_share_count']);
        Route::get('/{article_id}/uploaded_images',['uses'=>'ArticleController@getUploadedImages','as'=>'.uploaded_images']);
    });
    Route::group(['prefix'=>'users.','as'=>'.user'],function(){
        Route::post('/create_panelist',['uses'=>'UserController@postCreatePanelist','as'=>'.create_panelist']);
    });
});