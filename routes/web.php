<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/introduction', ['as' => 'backend.chats.introduction', 'uses' => 'ChatController@introduction']);
Route::get('/notification', ['as' => 'backend.notification', 'uses' => 'HomeController@notification']);
Route::get('/question_second', ['as' => 'backend.chats.question_second', 'uses' => 'ChatController@question_second']);
Route::get('/question_second_api', ['as' => 'backend.chats.question_second_api', 'uses' => 'ChatController@question_second_api']);
Route::get('/question_fourth_api', ['as' => 'backend.chats.question_fourth_api', 'uses' => 'ChatController@question_fourth_api']);

Auth::routes();


Route::group(['prefix' => 'chats'], function () {
    Route::get('/chat_query_list', ['as' => 'backend.chats.chat_query_list', 'uses' => 'ChatController@chat_query_list']);
    Route::get('/chat', ['as' => 'backend.chats.chat', 'uses' => 'ChatController@chat']);
    Route::get('/', ['as' => 'backend.chats.index', 'uses' => 'ChatController@index']);
    Route::get('/create', ['as' => 'backend.chats.create', 'uses' => 'ChatController@create']);
    Route::post('/create', ['as' => 'backend.chats.create', 'uses' => 'ChatController@store']);
    Route::get('/{id}/edit', ['as' => 'backend.chats.edit', 'uses' => 'ChatController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.chats.edit', 'uses' => 'ChatController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.chats.approve', 'uses' => 'ChatController@approve']);
    Route::get('/{id}/delete', ['as' => 'backend.chats.delete', 'uses' => 'ChatController@destroy']);
});

Route::group(['prefix' => 'chat_questions'], function () {
    Route::get('/', ['as' => 'backend.chat_questions.index', 'uses' => 'ChatQuestionController@index']);
    Route::get('/create', ['as' => 'backend.chat_questions.create', 'uses' => 'ChatQuestionController@create']);
    Route::post('/create', ['as' => 'backend.chat_questions.create', 'uses' => 'ChatQuestionController@store']);
    Route::get('/{id}/edit', ['as' => 'backend.chat_questions.edit', 'uses' => 'ChatQuestionController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.chat_questions.edit', 'uses' => 'ChatQuestionController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.chat_questions.approve', 'uses' => 'ChatQuestionController@approve']);
    Route::get('/{id}/delete', ['as' => 'backend.chat_questions.delete', 'uses' => 'ChatQuestionController@destroy']);
});

Route::group(['prefix' => 'chatquestion_options'], function () {
    Route::get('/', ['as' => 'backend.chatquestion_options.index', 'uses' => 'ChatQuestionOptionController@index']);
    Route::get('/create', ['as' => 'backend.chatquestion_options.create', 'uses' => 'ChatQuestionOptionController@create']);
    Route::post('/create', ['as' => 'backend.chatquestion_options.create', 'uses' => 'ChatQuestionOptionController@store']);
    Route::get('/{id}/edit', ['as' => 'backend.chatquestion_options.edit', 'uses' => 'ChatQuestionOptionController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.chatquestion_options.edit', 'uses' => 'ChatQuestionOptionController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.chatquestion_options.approve', 'uses' => 'ChatQuestionOptionController@approve']);
    Route::get('/{id}/delete', ['as' => 'backend.chatquestion_options.delete', 'uses' => 'ChatQuestionOptionController@destroy']);
});
Route::get('/get_latitude_longitude', 'HomeController@get_latitude_longitude')->name('get_latitude_longitude');
Route::get('/get_location_zip', 'HomeController@get_location_zip')->name('get_location_zip');
Route::post('/submit_zip_code', 'HomeController@submit_zip_code')->name('submit_zip_code');

Route::get('get-location-from-ip', function () {
    $ip = \Request::ip();
    $ip = "103.58.40.71";
    $data = \Location::get($ip);
    dd($data->zipCode);
});

Route::get('/prescriptions', 'HomeController@prescriptions')->name('prescriptions');
Route::get('/mock_up', 'HomeController@mock_up')->name('mock_up');
Route::get('/bdeflyer', 'HomeController@bdeflyer')->name('bdeflyer');

Route::get('/loginpage', 'UserController@loginpage')->name('loginpage');
Route::post('/loginpage', 'UserController@loginpagestore')->name('loginpage');
Route::post('/loginpage_password', 'UserController@loginpage_password')->name('loginpage_password');
Route::get('/registerpage', 'UserController@registerpage')->name('registerpage');
Route::group(['prefix' => '/', 'middleware' => ['auth']], function () {
    Route::get('/admindashboard', 'HomeController@admindashboard')->name('admindashboard')->middleware('role:Admin');
    Route::get('/doctordashboard', 'HomeController@doctordashboard')->name('doctordashboard')->middleware('role:Doctor');
    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('auth.logout');
});
Route::get('/apply_for_chemist', 'HomeController@apply_for_chemist')->name('apply_for_chemist');
Route::get('/business_operations', 'HomeController@business_operations')->name('business_operations');
Route::get('/competitive_strength', 'HomeController@competitive_strength')->name('competitive_strength');
Route::get('/research_development', 'HomeController@research_development')->name('research_development');
Route::get('/product_profile', 'HomeController@product_profile')->name('product_profile');
Route::get('/about_us', 'HomeController@about_us')->name('about_us');
Route::get('/terms_conditions', 'HomeController@terms_conditions')->name('terms_conditions');
Route::get('/return_policy', 'HomeController@return_policy')->name('return_policy');

Route::get('/register_generate_otp', 'UserController@register_generate_otp')->name('register_generate_otp');
Route::get('/register_generate_resend_otp', 'UserController@register_generate_resend_otp')->name('register_generate_resend_otp');

// Route::get('/{group_url_name}/{groupcategory_url_name}/{product_name}','FrontendController@product_detail')->name('frontend.product_detail');

// Route::get('/groupcategory_page/{id}','FrontendController@groupcategory_page')->name('frontend.groupcategory_page');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/search/product', 'HomeController@search_product')->name('home.search_product');
Route::get('/chemist_form', 'ChemistController@chemist_form')->name('frontend.chemist_form');
Route::post('/chemist_form', 'ChemistController@chemist_store')->name('frontend.chemist_form');

Route::group(['prefix' => 'socialite'], function () {
    Route::get('/socialite_mobile/{id}', 'SocialiteController@socialite_mobile')->name('socialite.socialite_mobile');
    Route::post('/socialite_mobile/{id}', 'SocialiteController@socialite_mobile_store')->name('socialite.socialite_mobile');
    Route::get('/send_otp', 'SocialiteController@send_otp');
    Route::get('/resend_otp', 'SocialiteController@resend_otp');
    Route::get('/google', 'SocialiteController@redirectToGoogle');
    Route::get('/google/callback', 'SocialiteController@handleGoogleCallback');
    Route::get('/socialite_mobile_facebook/{id}', 'SocialiteController@socialite_mobile_facebook')->name('socialite.socialite_mobile_facebook');
    Route::post('/socialite_mobile_facebook/{id}', 'SocialiteController@socialite_mobile_facebook_store')->name('socialite.socialite_mobile_facebook');
    Route::get('/send_otp_facebook', 'SocialiteController@send_otp_facebook')->name('socialite.send_otp_facebook');
    Route::get('/resend_otp_facebook', 'SocialiteController@resend_otp_facebook')->name('socialite.resend_otp_facebook');
    Route::get('/facebook', 'SocialiteController@redirectToFacebook')->name('socialite.facebook');
    Route::get('/facebook/callback', 'SocialiteController@handleFacebookCallback')->name('socialite.facebook.callback');
});

Route::post('/chemist_register_generate_otp', 'ChemistController@chemist_register_generate_otp')->name('chemist_register_generate_otp');
Route::get('chemist_register_generate_resend_otp', 'ChemistController@chemist_register_generate_resend_otp')->name('chemist_register_generate_resend_otp');

Route::group(['prefix' => 'frontend'], function () {
    Route::get('/registration_under_process', 'ChemistController@registration_under_process')->name('frontend.registration_under_process');
    Route::get('/upload_prescriptions/select_doctor_type', 'UploadprescriptionController@select_doctor_type')->name('frontend.upload_prescriptions.select_doctor_type');
    Route::post('/upload_prescriptions/get_illness', 'UploadprescriptionController@get_illness')->name('frontend.upload_prescriptions.get_illness');
    Route::get('/upload_prescriptions/select_illness', 'UploadprescriptionController@select_illness')->name('frontend.upload_prescriptions.select_illness');
    Route::post('/upload_prescriptions/explain_issue', 'UploadprescriptionController@explain_issue')->name('frontend.upload_prescriptions.explain_issue');
    Route::get('/book_an_appointment', 'FrontendController@book_an_appointment')->name('frontend.book_an_appointment')->middleware('auth');
    Route::post('/book_an_appointment', 'FrontendController@book_an_appointment_store')->name('frontend.book_an_appointment')->middleware('auth');
    Route::get('/scanner_page', 'FrontendController@scanner_page')->name('frontend.scanner_page');
    Route::get('/upload_prescription', 'FrontendController@upload_prescription')->name('frontend.upload_prescription')->middleware('auth');
    Route::post('/upload_prescription_store', 'FrontendController@upload_prescription_store')->name('frontend.upload_prescription_store')->middleware('auth');
    Route::get('/checkout/upload_prescription', 'FrontendController@checkout_upload_prescription')->name('frontend.checkout_upload_prescription')->middleware('auth');
    Route::post('/checkout/upload_prescription', 'FrontendController@checkout_upload_prescription_store')->name('frontend.checkout_upload_prescription')->middleware('auth');
    Route::get('/checkout', 'FrontendController@checkout')->name('frontend.checkout')->middleware('auth');
    Route::get('/buy_now/{id}', 'FrontendController@buy_now')->name('frontend.buy_now')->middleware('auth');
    Route::get('/group_testing_page', 'FrontendController@group_testing_page')->name('frontend.group_testing_page');
    Route::get('/cart', 'FrontendController@cart')->name('frontend.cart');
    Route::get('/aboutus', 'FrontendController@aboutus')->name('frontend.aboutus');
    Route::get('/pincode/check', 'FrontendController@pincode_check')->name('frontend.pincode.check');
    Route::get('/order_tracking/{id}', 'FrontendController@order_tracking')->name('frontend.order_tracking');
    Route::get('/add_address', 'FrontendController@add_address')->name('frontend.add_address');
    Route::get('/payment_gateway', 'FrontendController@payment_gateway')->name('frontend.payment_gateway');
    Route::get('/thanks_page', 'FrontendController@thanks_page')->name('frontend.thanks_page');
    Route::get('/userdashboard', 'FrontendController@userdashboard')->name('frontend.userdashboard');
    Route::post('/apply_for_chemist', 'FrontendController@apply_for_chemist_store')->name('frontend.apply_for_chemist');
    Route::get('/sidebar_filter_data', 'FrontendController@show_pagination_filter_data')->name('frontend.sidebar_filter_data');
    Route::post('/sidebar_filter_data', 'FrontendController@sidebar_filter_data')->name('frontend.sidebar_filter_data');
    Route::get('/get_sidebar_filter_data', 'FrontendController@sidebar_filter_data')->name('frontend.get_sidebar_filter_data');
    Route::get('/prescription_print/{id}', 'FrontendController@prescription_print')->name('frontend.prescription_print');
});

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function () {
    Route::get('/doctor_appointment_list', 'DashboardController@doctor_appointment_list')->name('dashboard.doctor_appointment_list');
    Route::get('/doctor_prescribed_product/{id}', 'DashboardController@doctor_prescribed_product')->name('dashboard.doctor_prescribed_product');
    Route::get('/doctor_prescribed_product/add_to_mycart/{id}', 'DashboardController@doctor_prescribed_product_add_to_mycart')->name('dashboard.doctor_prescribed_product_add_to_mycart');

    Route::get('/changepassword', 'DashboardController@changepassword')->name('dashboard.changepassword');
    Route::post('/changepassword', 'DashboardController@changepassword_store')->name('dashboard.changepassword');
    Route::get('/{id}/order_history', ['as' => 'dashboard.order_history', 'uses' => 'DashboardController@order_history']);
    Route::get('/profile_update', ['as' => 'dashboard.profile_update', 'uses' => 'DashboardController@profile_update']);
    Route::post('/profile_update', ['as' => 'dashboard.profile_update', 'uses' => 'DashboardController@profile_update_store']);
    Route::get('/account_summery', ['as' => 'dashboard.account_summery', 'uses' => 'DashboardController@account_summery']);
    Route::get('/customer_profile', ['as' => 'dashboard.customer_profile', 'uses' => 'DashboardController@customer_profile']);
    Route::get('/delivery_address/{id}', 'DashboardController@delivery_address')->name('dashboard.delivery_address');
    Route::get('/set_as_a_current/{id}', 'DashboardController@set_as_a_current')->name('dashboard.set_as_a_current');
    Route::get('/contact_us', 'DashboardController@contact_us')->name('dashboard.contact_us');
    Route::post('/contact_us', 'DashboardController@contact_us_store')->name('dashboard.contact_us');
    Route::get('/upload_image', 'DashboardController@upload_image')->name('dashboard.upload_image');
    Route::post('/upload_image', 'DashboardController@upload_image_store')->name('dashboard.upload_image');
    Route::get('/user_dashboard', 'DashboardController@user_dashboard')->name('dashboard.user_dashboard');
    Route::get('/edit_address/{id}', 'DashboardController@edit_address')->name('dashboard.edit_address');
    Route::post('/edit_address/{id}', 'DashboardController@edit_address_store')->name('dashboard.edit_address');
    Route::get('/add_address1', 'DashboardController@add_address1')->name('dashboard.add_address1');
    Route::get('/add_address', 'DashboardController@add_address')->name('dashboard.add_address');
    Route::post('/add_address', 'DashboardController@store_add_address')->name('dashboard.add_address');
    Route::get('/diagnostics_faq', ['as' => 'dashboard.diagnostics_faq', 'uses' => 'DashboardController@diagnostics_faq']);
    Route::get('/legal_information', ['as' => 'dashboard.legal_information', 'uses' => 'DashboardController@legal_information']);
    Route::get('/my_prescription', ['as' => 'dashboard.my_prescription', 'uses' => 'DashboardController@my_prescription']);
    Route::get('/subscription', ['as' => 'dashboard.subscription', 'uses' => 'DashboardController@subscription']);
    Route::get('/my_wallet', ['as' => 'dashboard.my_wallet', 'uses' => 'DashboardController@my_wallet']);
    Route::post('/wallet_recharge', 'DashboardController@wallet_recharge')->name('dashboard.wallet_recharge');
    Route::get('/refer_earn', ['as' => 'dashboard.refer_earn', 'uses' => 'DashboardController@refer_earn']);
    Route::get('/offers/{user_id}', ['as' => 'dashboard.offers', 'uses' => 'DashboardController@offers']);
    Route::get('/sales_schemes/{user_id}', ['as' => 'dashboard.sales_schemes', 'uses' => 'DashboardController@sales_schemes']);

    Route::get('/delete_address/{id}', ['as' => 'dashboard.delete_address', 'uses' => 'DashboardController@delete_address']);
    Route::get('/my_profile', ['as' => 'dashboard.my_profile', 'uses' => 'DashboardController@my_profile']);
    Route::post('/backurl_wallet_recharge', ['as' => 'dashboard.backurl_wallet_recharge', 'uses' => 'DashboardController@backurl_wallet_recharge']);

});
Route::get('dashboard/pincode/check', ['as' => 'dashboard.pincode_check', 'uses' => 'DashboardController@pincode_check']);
Route::get('/payment/pay', 'PaymentController@pay')->name('payment.pay');
Route::post('payment_callback', 'PaymentController@payment_callback')->name('payment.payment_callback');

Route::get('/payment/customer_pay', 'CustomerPaymentController@customer_pay')->name('payment.customer_pay');
Route::post('payment_customer_callback', 'CustomerPaymentController@payment_customer_callback')->name('payment.payment_customer_callback');

Route::get('/otp_validation/App', 'UserController@otp_validation_App')->name('otp_validation_App');
Route::post('/otp_validation/App', 'UserController@otp_validation_App')->name('otp_validation_App');
Route::get('/send_otp', 'UserController@send_otp')->name('send_otp');
Route::get('/resend_otp', 'UserController@resend_otp')->name('resend_otp');

Route::get('/frontendlogin', 'UserController@frontendlogin')->name('frontendlogin');

Route::get('/dashboard', 'HomeController@dashboard');

Route::get('/single_product', 'HomeController@single_product');
Route::get('/product_page', 'HomeController@product_page');
Route::post('/registration_varification', 'UserController@registration_varification');
Route::get('/otp_validation', 'UserController@otp_validation');

Route::post('/registerpage', 'UserController@registerpagestore')->name('registerpage');
Route::group(['prefix' => 'users', 'middleware' => ['auth']], function () {

    Route::get('/user/changepassword', ['as' => 'myaccount.changepassword', 'uses' => 'UserController@changepassword']);
    Route::post('/user/changepassword', ['as' => 'myaccount.changepassword', 'uses' => 'UserController@changepasswordpost']);
});

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('auth.logout');
Route::group(['prefix' => 'search'], function () {
    Route::get('/group_product_by_price', ['as' => 'search.group_product_by_price', 'uses' => 'SearchController@group_product_by_price']);
    Route::get('/groupcategory_product_by_price', ['as' => 'search.groupcategory_product_by_price', 'uses' => 'SearchController@groupcategory_product_by_price']);
    Route::get('/all', ['as' => 'search.all', 'uses' => 'SearchController@all']);
});
Route::group(['prefix' => 'chemists'], function () {
    Route::get('/export', ['as' => 'backend.chemists.export', 'uses' => 'ChemistController@export']);
    Route::get('/customer_list_with_add_to_cart', ['as' => 'backend.chemists.customer_list_with_add_to_cart', 'uses' => 'ChemistController@customer_list_with_add_to_cart']);
    
    Route::get('/ChemistWithAddToCardsExport', ['as' => 'backend.chemists.ChemistWithAddToCardsExport', 'uses' => 'ChemistController@ChemistWithAddToCardsExport']);

    Route::get('/chemist_list_with_add_to_cart', ['as' => 'backend.chemists.chemist_list_with_add_to_cart', 'uses' => 'ChemistController@chemist_list_with_add_to_cart']);
    Route::get('/chemist_with_add_to_cart_data/{id}', ['as' => 'backend.chemists.chemist_with_add_to_cart_data', 'uses' => 'ChemistController@chemist_with_add_to_cart_data']);

    Route::get('/', ['as' => 'backend.chemists.index', 'uses' => 'ChemistController@index']);
    Route::get('/chemist_list_without_Party_Code', ['as' => 'backend.chemists.chemist_list_without_Party_Code', 'uses' => 'ChemistController@chemist_list_without_Party_Code']);
    Route::get('/chemist_list_dublicate_entry', ['as' => 'backend.chemists.chemist_list_dublicate_entry', 'uses' => 'ChemistController@chemist_list_dublicate_entry']);
    Route::get('/dl_file_delete_in_bulk', ['as' => 'backend.chemists.dl_file_delete_in_bulk', 'uses' => 'ChemistController@dl_file_delete_in_bulk']);
    Route::get('/view_profile/{id}', ['as' => 'backends.chemists.view_profile', 'uses' => 'ChemistController@view_profile'])->middleware(['auth']);
    Route::get('/create', ['as' => 'backend.chemists.create', 'uses' => 'ChemistController@create']);
    Route::post('/create', ['as' => 'backend.chemists.create', 'uses' => 'ChemistController@store']);
    Route::post('create/App', ['as' => 'backend.chemists.createApp', 'uses' => 'ChemistController@storeApp']);
    Route::get('/{id}/edit', ['as' => 'backend.chemists.edit', 'uses' => 'ChemistController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.chemists.edit', 'uses' => 'ChemistController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.chemists.approve', 'uses' => 'ChemistController@approve']);
    Route::get('/delete/{id}', ['as' => 'backend.chemists.delete', 'uses' => 'ChemistController@destroy']);
    Route::get('/deactivate/{id}', ['as' => 'backend.chemists.deactivate', 'uses' => 'ChemistController@deactivate']);
    Route::get('/activate/{id}', ['as' => 'backend.chemists.activate', 'uses' => 'ChemistController@activate']);

    Route::get('/approved/{id}', ['as' => 'backend.chemists.approved', 'uses' => 'ChemistController@approved']);
    Route::get('/rejected/{id}', ['as' => 'backend.chemists.rejected', 'uses' => 'ChemistController@rejected']);
    Route::get('/payment_reminder_msg/{id}', ['as' => 'backend.chemists.payment_reminder_msg', 'uses' => 'ChemistController@payment_reminder_msg']);
    
});

Route::group(['prefix' => 'add_to_carts'], function () {
    
    Route::get('/customer_re_order/{id}', ['as' => 'backend.add_to_carts.customer_re_order', 'uses' => 'AddToCardController@customer_re_order']);
    Route::get('/re_order/{id}', ['as' => 'backend.add_to_carts.re_order', 'uses' => 'AddToCardController@re_order']);
    Route::get('/list', ['as' => 'backend.add_to_carts.list', 'uses' => 'AddToCardController@list']);
    Route::get('/add_cart', ['as' => 'backend.add_to_carts.add_cart', 'uses' => 'AddToCardController@add_cart']);
    Route::get('/add_cart_user', ['as' => 'backend.add_to_carts.add_cart_user', 'uses' => 'AddToCardController@add_cart_user']);
    Route::get('/add_cart_chemist', ['as' => 'backend.add_to_carts.add_cart_chemist', 'uses' => 'AddToCardController@add_cart_chemist']);
    Route::get('/change_qty', ['as' => 'backend.add_to_carts.change_qty', 'uses' => 'AddToCardController@change_qty']);
    Route::get('/change_qty_user', ['as' => 'backend.add_to_carts.change_qty_user', 'uses' => 'AddToCardController@change_qty_user']);
    Route::get('/change_qty_chemist', ['as' => 'backend.add_to_carts.change_qty_chemist', 'uses' => 'AddToCardController@change_qty_chemist']);
    Route::get('/create', ['as' => 'backend.add_to_carts.create', 'uses' => 'AddToCardController@create']);
    Route::post('/create', ['as' => 'backend.add_to_carts.create', 'uses' => 'AddToCardController@store']);
    Route::post('create/App', ['as' => 'backend.add_to_carts.createApp', 'uses' => 'AddToCardController@storeApp']);
    Route::get('/{id}/edit', ['as' => 'backend.add_to_carts.edit', 'uses' => 'AddToCardController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.add_to_carts.edit', 'uses' => 'AddToCardController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.add_to_carts.approve', 'uses' => 'AddToCardController@approve']);
    Route::get('/remove_cart', ['as' => 'backend.add_to_carts.remove_cart', 'uses' => 'AddToCardController@remove_cart']);
    Route::get('/remove_cart_user', ['as' => 'backend.add_to_carts.remove_cart_user', 'uses' => 'AddToCardController@remove_cart_user']);
    Route::get('/remove_cart_chemist', ['as' => 'backend.add_to_carts.remove_cart_chemist', 'uses' => 'AddToCardController@remove_cart_chemist']);
    Route::get('/add_cart_from_search', ['as' => 'backend.add_to_carts.add_cart_from_search', 'uses' => 'AddToCardController@add_cart_from_search']);
});

Route::group(['prefix' => 'products', 'middleware' => ['auth']], function () {
    Route::get('/export', ['as' => 'backend.products.export', 'uses' => 'ProductController@export']);
    Route::get('/image', ['as' => 'backend.products.image', 'uses' => 'ProductController@image']);
    Route::get('/', ['as' => 'backend.products.index', 'uses' => 'ProductController@index']);
    Route::get('/App', ['as' => 'backend.products.indexApp', 'uses' => 'ProductController@indexApp']);
    Route::get('/create', ['as' => 'backend.products.create', 'uses' => 'ProductController@create']);
    Route::post('/create', ['as' => 'backend.products.create', 'uses' => 'ProductController@store']);
    Route::post('create/App', ['as' => 'backend.products.createApp', 'uses' => 'ProductController@storeApp']);
    Route::get('/{id}/edit', ['as' => 'backend.products.edit', 'uses' => 'ProductController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.products.edit', 'uses' => 'ProductController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.products.approve', 'uses' => 'ProductController@approve']);
    Route::get('/{id}/delete', ['as' => 'backend.products.delete', 'uses' => 'ProductController@destroy']);
});

Route::group(['prefix' => 'groups', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/', ['as' => 'backend.groups.index', 'uses' => 'GroupController@index']);
    Route::get('/App', ['as' => 'backend.groups.indexApp', 'uses' => 'GroupController@indexApp']);
    Route::get('/create', ['as' => 'backend.groups.create', 'uses' => 'GroupController@create']);
    Route::post('/create', ['as' => 'backend.groups.create', 'uses' => 'GroupController@store']);
    Route::post('create/App', ['as' => 'backend.groups.createApp', 'uses' => 'GroupController@storeApp']);
    Route::get('/{id}/edit', ['as' => 'backend.groups.edit', 'uses' => 'GroupController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.groups.edit', 'uses' => 'GroupController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.groups.approve', 'uses' => 'GroupController@approve']);
    Route::get('/{id}/delete', ['as' => 'backend.groups.delete', 'uses' => 'GroupController@destroy']);
});


Route::group(['prefix' => 'brought_also_products', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/', ['as' => 'backend.brought_also_products.index', 'uses' => 'BroughtalsoproductController@index']);
    Route::get('/App', ['as' => 'backend.brought_also_products.indexApp', 'uses' => 'BroughtalsoproductController@indexApp']);
    Route::get('/create', ['as' => 'backend.brought_also_products.create', 'uses' => 'BroughtalsoproductController@create']);
    Route::post('/create', ['as' => 'backend.brought_also_products.create', 'uses' => 'BroughtalsoproductController@store']);
    Route::post('create/App', ['as' => 'backend.brought_also_products.createApp', 'uses' => 'BroughtalsoproductController@storeApp']);
    Route::get('/{id}/edit', ['as' => 'backend.brought_also_products.edit', 'uses' => 'BroughtalsoproductController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.brought_also_products.edit', 'uses' => 'BroughtalsoproductController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.brought_also_products.approve', 'uses' => 'BroughtalsoproductController@approve']);
    Route::get('/{id}/delete', ['as' => 'backend.brought_also_products.delete', 'uses' => 'BroughtalsoproductController@destroy']);
});



Route::group(['prefix' => 'groupcategories', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/', ['as' => 'backend.groupcategories.index', 'uses' => 'GroupcategoryController@index']);
    Route::get('/create', ['as' => 'backend.groupcategories.create', 'uses' => 'GroupcategoryController@create']);
    Route::post('/create', ['as' => 'backend.groupcategories.create', 'uses' => 'GroupcategoryController@store']);
    Route::get('/getImport', ['as' => 'backend.groupcategories.getImport', 'uses' => 'GroupcategoryController@getImport']);
    Route::post('/postImport', ['as' => 'backend.groupcategories.postImport', 'uses' => 'GroupcategoryController@postImport']);
    Route::get('/{id}/edit', ['as' => 'backend.groupcategories.edit', 'uses' => 'GroupcategoryController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.groupcategories.edit', 'uses' => 'GroupcategoryController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.groupcategories.approve', 'uses' => 'GroupcategoryController@approve']);
    Route::get('/{id}/delete', ['as' => 'backend.groupcategories.delete', 'uses' => 'GroupcategoryController@destroy']);
    Route::get('/{id}/is_home', ['as' => 'backend.groupcategories.is_home', 'uses' => 'GroupcategoryController@is_home']);
    Route::get('/{id}/unset_from_home', ['as' => 'backend.groupcategories.unset_from_home', 'uses' => 'GroupcategoryController@unset_from_home']);

});
Route::group(['prefix' => 'sliders', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/', ['as' => 'backend.sliders.index', 'uses' => 'SliderController@index']);
    Route::get('/App_Slider_List', ['as' => 'backend.sliders.App_Slider_List', 'uses' => 'SliderController@App_Slider_List']);
    Route::get('/Add_App_Slider', ['as' => 'backend.sliders.Add_App_Slider', 'uses' => 'SliderController@Add_App_Slider']);
    Route::post('/Add_App_Slider', ['as' => 'backend.sliders.Add_App_Slider', 'uses' => 'SliderController@Add_App_Slider_store']);
    Route::get('/create', ['as' => 'backend.sliders.create', 'uses' => 'SliderController@create']);
    Route::post('/create', ['as' => 'backend.sliders.create', 'uses' => 'SliderController@store']);
    Route::get('/{id}/edit', ['as' => 'backend.sliders.edit', 'uses' => 'SliderController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.sliders.edit', 'uses' => 'SliderController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.sliders.approve', 'uses' => 'SliderController@approve']);
    Route::get('/{id}/delete', ['as' => 'backend.sliders.delete', 'uses' => 'SliderController@destroy']);
});

Route::group(['prefix' => 'manufactures', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/', ['as' => 'backend.manufactures.index', 'uses' => 'ManufactureController@index']);
    Route::get('/create', ['as' => 'backend.manufactures.create', 'uses' => 'ManufactureController@create']);
    Route::post('/create', ['as' => 'backend.manufactures.create', 'uses' => 'ManufactureController@store']);
    Route::get('/{id}/edit', ['as' => 'backend.manufactures.edit', 'uses' => 'ManufactureController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.manufactures.edit', 'uses' => 'ManufactureController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.manufactures.approve', 'uses' => 'ManufactureController@approve']);
    Route::get('/{id}/delete', ['as' => 'backend.manufactures.delete', 'uses' => 'ManufactureController@destroy']);
});

Route::group(['prefix' => 'payment_gateways', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/', ['as' => 'backend.payment_gateways.index', 'uses' => 'PaymentGatewayController@index']);
    Route::get('/create', ['as' => 'backend.payment_gateways.create', 'uses' => 'PaymentGatewayController@create']);
    Route::post('/create', ['as' => 'backend.payment_gateways.create', 'uses' => 'PaymentGatewayController@store']);
    Route::get('/{id}/edit', ['as' => 'backend.payment_gateways.edit', 'uses' => 'PaymentGatewayController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.payment_gateways.edit', 'uses' => 'PaymentGatewayController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.payment_gateways.approve', 'uses' => 'PaymentGatewayController@approve']);
    Route::get('/{id}/delete', ['as' => 'backend.payment_gateways.delete', 'uses' => 'PaymentGatewayController@destroy']);
});

Route::group(['prefix' => 'categories', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/', ['as' => 'backend.categories.index', 'uses' => 'CategoryController@index']);
    Route::get('/create', ['as' => 'backend.categories.create', 'uses' => 'CategoryController@create']);
    Route::post('/create', ['as' => 'backend.categories.create', 'uses' => 'CategoryController@store']);
    Route::get('/{id}/edit', ['as' => 'backend.categories.edit', 'uses' => 'CategoryController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.categories.edit', 'uses' => 'CategoryController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.categories.approve', 'uses' => 'CategoryController@approve']);
    Route::get('/{id}/delete', ['as' => 'backend.categories.delete', 'uses' => 'CategoryController@destroy']);
});

Route::group(['prefix' => 'doctor_specializations', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/', ['as' => 'backend.doctor_specializations.index', 'uses' => 'DoctorSpecializationController@index']);
    Route::get('/create', ['as' => 'backend.doctor_specializations.create', 'uses' => 'DoctorSpecializationController@create']);
    Route::post('/create', ['as' => 'backend.doctor_specializations.create', 'uses' => 'DoctorSpecializationController@store']);
    Route::get('/{id}/edit', ['as' => 'backend.doctor_specializations.edit', 'uses' => 'DoctorSpecializationController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.doctor_specializations.edit', 'uses' => 'DoctorSpecializationController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.doctor_specializations.approve', 'uses' => 'DoctorSpecializationController@approve']);
    Route::get('/{id}/delete', ['as' => 'backend.doctor_specializations.delete', 'uses' => 'DoctorSpecializationController@destroy']);
});

Route::group(['prefix' => 'products', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/', ['as' => 'backend.products.index', 'uses' => 'ProductController@index']);
    Route::get('/list_with_price', ['as' => 'backend.products.list_with_price', 'uses' => 'ProductController@list_with_price']);
    Route::get('/App', ['as' => 'backend.products.indexApp', 'uses' => 'ProductController@indexApp']);
    Route::get('/getImport', ['as' => 'backend.products.getImport', 'uses' => 'ProductController@getImport']);
    Route::post('/postImport', ['as' => 'backend.products.postImport', 'uses' => 'ProductController@postImport']);
    Route::get('/create', ['as' => 'backend.products.create', 'uses' => 'ProductController@create']);
    Route::post('/create', ['as' => 'backend.products.create', 'uses' => 'ProductController@store']);
    Route::post('/add_position', ['as' => 'backend.products.add_position', 'uses' => 'ProductController@add_position']);
    Route::post('create/App', ['as' => 'backend.products.createApp', 'uses' => 'ProductController@storeApp']);
    Route::get('/{id}/edit', ['as' => 'backend.products.edit', 'uses' => 'ProductController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.products.edit', 'uses' => 'ProductController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.products.approve', 'uses' => 'ProductController@approve']);
    Route::get('/{id}/delete', ['as' => 'backend.products.delete', 'uses' => 'ProductController@destroy']);
});

Route::group(['prefix' => 'offers', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/', ['as' => 'backend.offers.index', 'uses' => 'OfferController@index']);
    Route::get('/App', ['as' => 'backend.offers.indexApp', 'uses' => 'OfferController@indexApp']);
    Route::get('/create', ['as' => 'backend.offers.create', 'uses' => 'OfferController@create']);
    Route::post('/create', ['as' => 'backend.offers.create', 'uses' => 'OfferController@store']);
    Route::post('create/App', ['as' => 'backend.offers.createApp', 'uses' => 'OfferController@storeApp']);
    Route::get('/{id}/edit', ['as' => 'backend.offers.edit', 'uses' => 'OfferController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.offers.edit', 'uses' => 'OfferController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.offers.approve', 'uses' => 'OfferController@approve']);
    Route::get('/{id}/delete', ['as' => 'backend.offers.delete', 'uses' => 'OfferController@destroy']);
});

Route::group(['prefix' => 'descriptions', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/', ['as' => 'backend.descriptions.index', 'uses' => 'DescriptionController@index']);
    Route::get('/description_list/{id}', ['as' => 'backend.descriptions.description_list', 'uses' => 'DescriptionController@description_list']);
    Route::get('/App', ['as' => 'backend.descriptions.indexApp', 'uses' => 'DescriptionController@indexApp']);
    Route::get('/create/{id}', ['as' => 'backend.descriptions.create', 'uses' => 'DescriptionController@create']);
    Route::post('/create/{id}', ['as' => 'backend.descriptions.create', 'uses' => 'DescriptionController@store']);
    Route::get('/getImport', ['as' => 'backend.descriptions.getImport', 'uses' => 'DescriptionController@getImport']);
    Route::post('/postImport', ['as' => 'backend.descriptions.postImport', 'uses' => 'DescriptionController@postImport']);
    Route::post('create/App', ['as' => 'backend.descriptions.createApp', 'uses' => 'DescriptionController@storeApp']);
    Route::get('/{id}/edit', ['as' => 'backend.descriptions.edit', 'uses' => 'DescriptionController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.descriptions.edit', 'uses' => 'DescriptionController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.descriptions.approve', 'uses' => 'DescriptionController@approve']);
    Route::get('/{id}/delete', ['as' => 'backend.descriptions.delete', 'uses' => 'DescriptionController@destroy']);
});

Route::group(['prefix' => 'description_types', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/', ['as' => 'backend.description_types.index', 'uses' => 'DescriptiontypeController@index']);
    Route::get('/App', ['as' => 'backend.description_types.indexApp', 'uses' => 'DescriptiontypeController@indexApp']);
    Route::get('/create', ['as' => 'backend.description_types.create', 'uses' => 'DescriptiontypeController@create']);
    Route::post('/create', ['as' => 'backend.description_types.create', 'uses' => 'DescriptiontypeController@store']);
    Route::post('create/App', ['as' => 'backend.description_types.createApp', 'uses' => 'DescriptiontypeController@storeApp']);
    Route::get('/{id}/edit', ['as' => 'backend.description_types.edit', 'uses' => 'DescriptiontypeController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.description_types.edit', 'uses' => 'DescriptiontypeController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.description_types.approve', 'uses' => 'DescriptiontypeController@approve']);
    Route::get('/{id}/delete', ['as' => 'backend.description_types.delete', 'uses' => 'DescriptiontypeController@destroy']);
});

Route::group(['prefix' => 'packages', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/', ['as' => 'backend.packages.index', 'uses' => 'PackageController@index']);
    Route::get('/App', ['as' => 'backend.packages.indexApp', 'uses' => 'PackageController@indexApp']);
    Route::get('/getImport', ['as' => 'backend.packages.getImport', 'uses' => 'PackageController@getImport']);
    Route::post('/postImport', ['as' => 'backend.packages.postImport', 'uses' => 'PackageController@postImport']);
    Route::get('/create', ['as' => 'backend.packages.create', 'uses' => 'PackageController@create']);
    Route::post('/create', ['as' => 'backend.packages.create', 'uses' => 'PackageController@store']);
    Route::post('create/App', ['as' => 'backend.packages.createApp', 'uses' => 'PackageController@storeApp']);
    Route::get('/{id}/edit', ['as' => 'backend.packages.edit', 'uses' => 'PackageController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.packages.edit', 'uses' => 'PackageController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.packages.approve', 'uses' => 'PackageController@approve']);
    Route::get('/{id}/delete', ['as' => 'backend.packages.delete', 'uses' => 'PackageController@destroy']);
});

Route::group(['prefix' => 'doctors', 'middleware' => ['auth', 'role:Doctor']], function () {
    Route::get('/prescribed_order_detail/{order_id}', ['as' => 'backend.doctors.prescribed_order_detail', 'uses' => 'DoctorAppointmentController@prescribed_order_detail']);
    Route::post('/prescribed_order_detail/{order_id}', ['as' => 'backend.doctors.prescribed_order_detail', 'uses' => 'DoctorAppointmentController@prescribed_order_detail_store']);

    Route::get('/prescribed_order', ['as' => 'backend.doctors.prescribed_order', 'uses' => 'DoctorAppointmentController@prescribed_order']);
    Route::get('/', ['as' => 'backend.doctors.index', 'uses' => 'DoctorAppointmentController@index']);
    Route::get('/App', ['as' => 'backend.doctors.indexApp', 'uses' => 'DoctorAppointmentController@indexApp']);
    Route::get('/create', ['as' => 'backend.doctors.create', 'uses' => 'DoctorAppointmentController@create']);
    Route::post('/create', ['as' => 'backend.doctors.create', 'uses' => 'DoctorAppointmentController@store']);
    Route::post('create/App', ['as' => 'backend.doctors.createApp', 'uses' => 'DoctorAppointmentController@storeApp']);
    Route::get('/{id}/edit', ['as' => 'backend.doctors.edit', 'uses' => 'DoctorAppointmentController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.doctors.edit', 'uses' => 'DoctorAppointmentController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.doctors.approve', 'uses' => 'DoctorAppointmentController@approve']);
    Route::get('/{id}/delete', ['as' => 'backend.doctors.delete', 'uses' => 'DoctorAppointmentController@destroy']);
});

Route::group(['prefix' => 'orders', 'middleware' => ['auth']], function () {
    Route::get('/order_json/{id}', ['as' => 'backend.orders.order_json', 'uses' => 'OrderController@order_json']);

    Route::get('/payment_export', ['as' => 'backend.orders.payment_export', 'uses' => 'OrderController@payment_export']);
    Route::get('/order_settelement_report', ['as' => 'backend.orders.order_settelement_report', 'uses' => 'OrderController@order_settelement_report']);
    Route::Post('/order_settelement_report', ['as' => 'backend.orders.order_settelement_report', 'uses' => 'OrderController@order_settelement_report_store']);
    Route::get('/order_tracking_export', ['as' => 'backend.orders.order_tracking_export', 'uses' => 'OrderController@order_tracking_export']);
    Route::get('/view_cart_items/{id}', ['as' => 'backend.orders.view_cart_items', 'uses' => 'OrderController@view_cart_items']);
    Route::get('/pending_orders_for_payment', ['as' => 'backend.orders.pending_orders_for_payment', 'uses' => 'OrderController@pending_orders_for_payment']);
    Route::get('/orders_with_empty_order_code', ['as' => 'backend.orders.orders_with_empty_order_code', 'uses' => 'OrderController@orders_with_empty_order_code']);
    Route::get('/chemist_list_more_than_one_order', ['as' => 'backend.orders.chemist_list_more_than_one_order', 'uses' => 'OrderController@chemist_list_more_than_one_order']);
    Route::get('/chemist_order_list/{id}', ['as' => 'backend.orders.chemist_order_list', 'uses' => 'OrderController@chemist_order_list']);
    Route::get('/party_order_tracking', ['as' => 'backend.orders.party_order_tracking', 'uses' => 'OrderController@party_order_tracking']);
    Route::get('/view_cart_items_paid_now/{payment_id}', ['as' => 'backend.orders.view_cart_items_paid_now', 'uses' => 'OrderController@view_cart_items_paid_now']);
    Route::get('/payment_report', ['as' => 'backend.orders.payment_report', 'uses' => 'OrderController@payment_report']);
    Route::get('/payment_export_page', ['as' => 'backend.orders.payment_export_page', 'uses' => 'OrderController@payment_export_page']);
    Route::get('/order_report', ['as' => 'backend.orders.order_report', 'uses' => 'OrderController@order_report']);
    Route::get('/order_report_state_wise', ['as' => 'backend.orders.order_report_state_wise', 'uses' => 'OrderController@order_report_state_wise']);
    Route::get('/order_report_date_wise', ['as' => 'backend.orders.order_report_date_wise', 'uses' => 'OrderController@order_report_date_wise']);
    Route::get('/', ['as' => 'backend.orders.index', 'uses' => 'OrderController@index']);
    Route::get('show/{id}', ['as' => 'backend.orders.show', 'uses' => 'OrderController@show']);
    Route::get('/App', ['as' => 'backend.orders.indexApp', 'uses' => 'OrderController@indexApp']);
    Route::get('/create', ['as' => 'backend.orders.create', 'uses' => 'OrderController@create']);
    Route::post('/create', ['as' => 'backend.orders.create', 'uses' => 'OrderController@store']);
    Route::get('/{id}/print_view', ['as' => 'frontend.print_view', 'uses' => 'OrderController@print_view']);
    Route::get('/{id}/edit', ['as' => 'backend.orders.edit', 'uses' => 'OrderController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.orders.edit', 'uses' => 'OrderController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.orders.approve', 'uses' => 'OrderController@approve']);
    Route::get('/{id}/order_cancel', ['as' => 'backend.orders.order_cancel', 'uses' => 'OrderController@order_cancel']);
    Route::get('/{id}/order_return', ['as' => 'backend.orders.order_return', 'uses' => 'OrderController@order_return']);
    Route::get('/{id}/delete', ['as' => 'backend.orders.delete', 'uses' => 'OrderController@destroy']);
});

Route::group(['prefix' => 'order_products', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/', ['as' => 'backend.order_products.index', 'uses' => 'OrderProductController@index']);
    Route::get('/App', ['as' => 'backend.order_products.indexApp', 'uses' => 'OrderProductController@indexApp']);
    Route::get('/create', ['as' => 'backend.order_products.create', 'uses' => 'OrderProductController@create']);
    Route::post('/create', ['as' => 'backend.order_products.create', 'uses' => 'OrderProductController@store']);
    Route::post('create/App', ['as' => 'backend.order_products.createApp', 'uses' => 'OrderProductController@storeApp']);
    Route::get('/{id}/edit', ['as' => 'backend.order_products.edit', 'uses' => 'OrderProductController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.order_products.edit', 'uses' => 'OrderProductController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.order_products.approve', 'uses' => 'OrderProductController@approve']);
    Route::get('/{id}/delete', ['as' => 'backend.order_products.delete', 'uses' => 'OrderProductController@destroy']);
});

Route::group(['prefix' => 'pincodes', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/', ['as' => 'backend.pincodes.index', 'uses' => 'PincodeController@index']);
    Route::get('/App', ['as' => 'backend.pincodes.indexApp', 'uses' => 'PincodeController@indexApp']);
    Route::get('/office/{id}', ['as' => 'backend.pincodes.office', 'uses' => 'PincodeController@office']);
    Route::get('/State/{id}', ['as' => 'backend.pincodes.state', 'uses' => 'PincodeController@State']);
    Route::get('/create', ['as' => 'backend.pincodes.create', 'uses' => 'PincodeController@create']);
    Route::post('/create', ['as' => 'backend.pincodes.create', 'uses' => 'PincodeController@store']);
    Route::get('/getImport', ['as' => 'backend.pincodes.getImport', 'uses' => 'PincodeController@getImport']);
    Route::post('/postImport', ['as' => 'backend.pincodes.postImport', 'uses' => 'PincodeController@postImport']);
    Route::post('create/App', ['as' => 'backend.pincodes.createApp', 'uses' => 'PincodeController@storeApp']);
    Route::get('/{id}/edit', ['as' => 'backend.pincodes.edit', 'uses' => 'PincodeController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.pincodes.edit', 'uses' => 'PincodeController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.pincodes.approve', 'uses' => 'PincodeController@approve']);
    Route::get('/{id}/delete', ['as' => 'backend.pincodes.delete', 'uses' => 'PincodeController@destroy']);
});

Route::group(['prefix' => 'productprices', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/', ['as' => 'backend.productprices.index', 'uses' => 'ProductpriceController@index']);
    Route::get('/App', ['as' => 'backend.productprices.indexApp', 'uses' => 'ProductpriceController@indexApp']);
    Route::get('/create', ['as' => 'backend.productprices.create', 'uses' => 'ProductpriceController@create']);
    Route::post('/create', ['as' => 'backend.productprices.create', 'uses' => 'ProductpriceController@store']);
    Route::get('/getImport', ['as' => 'backend.productprices.getImport', 'uses' => 'ProductpriceController@getImport']);
    Route::post('/postImport', ['as' => 'backend.productprices.postImport', 'uses' => 'ProductpriceController@postImport']);
    Route::post('create/App', ['as' => 'backend.productprices.createApp', 'uses' => 'ProductpriceController@storeApp']);
    Route::get('/{id}/edit', ['as' => 'backend.productprices.edit', 'uses' => 'ProductpriceController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.productprices.edit', 'uses' => 'ProductpriceController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.productprices.approve', 'uses' => 'ProductpriceController@approve']);
    Route::get('/{id}/delete', ['as' => 'backend.productprices.delete', 'uses' => 'ProductpriceController@destroy']);
});

Route::group(['prefix' => 'sales_schemes', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/', ['as' => 'backend.sales_schemes.index', 'uses' => 'SalesSchemeController@index']);
    Route::get('/App', ['as' => 'backend.sales_schemes.indexApp', 'uses' => 'SalesSchemeController@indexApp']);
    Route::get('/create', ['as' => 'backend.sales_schemes.create', 'uses' => 'SalesSchemeController@create']);
    Route::post('/create', ['as' => 'backend.sales_schemes.create', 'uses' => 'SalesSchemeController@store']);
    Route::get('/getImport', ['as' => 'backend.sales_schemes.getImport', 'uses' => 'SalesSchemeController@getImport']);
    Route::post('/postImport', ['as' => 'backend.sales_schemes.postImport', 'uses' => 'SalesSchemeController@postImport']);
    Route::post('create/App', ['as' => 'backend.sales_schemes.createApp', 'uses' => 'SalesSchemeController@storeApp']);
    Route::get('/{id}/edit', ['as' => 'backend.sales_schemes.edit', 'uses' => 'SalesSchemeController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.sales_schemes.edit', 'uses' => 'SalesSchemeController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.sales_schemes.approve', 'uses' => 'SalesSchemeController@approve']);
    Route::get('/{id}/delete', ['as' => 'backend.sales_schemes.delete', 'uses' => 'SalesSchemeController@destroy']);
    Route::post('/image_upload/{id}', ['as' => 'backend.sales_schemes.image_upload', 'uses' => 'SalesSchemeController@image_upload']);
});

Route::group(['prefix' => 'sceme_ons', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/', ['as' => 'backend.sceme_ons.index', 'uses' => 'ScemeonController@index']);
    Route::get('/App', ['as' => 'backend.sceme_ons.indexApp', 'uses' => 'ScemeonController@indexApp']);
    Route::get('/create', ['as' => 'backend.sceme_ons.create', 'uses' => 'ScemeonController@create']);
    Route::post('/create', ['as' => 'backend.sceme_ons.create', 'uses' => 'ScemeonController@store']);
    Route::get('/getImport', ['as' => 'backend.sceme_ons.getImport', 'uses' => 'ScemeonController@getImport']);
    Route::post('/postImport', ['as' => 'backend.sceme_ons.postImport', 'uses' => 'ScemeonController@postImport']);
    Route::post('create/App', ['as' => 'backend.sceme_ons.createApp', 'uses' => 'ScemeonController@storeApp']);
    Route::get('/{id}/edit', ['as' => 'backend.sceme_ons.edit', 'uses' => 'ScemeonController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.sceme_ons.edit', 'uses' => 'ScemeonController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.sceme_ons.approve', 'uses' => 'ScemeonController@approve']);
    Route::get('/{id}/delete', ['as' => 'backend.sceme_ons.delete', 'uses' => 'ScemeonController@destroy']);
});

Route::group(['prefix' => 'stocks', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/', ['as' => 'backend.stocks.index', 'uses' => 'StockController@index']);
    Route::get('/report2', ['as' => 'backend.stocks.report2', 'uses' => 'StockController@report2']);
    Route::get('/service_area', ['as' => 'backend.stocks.service_area', 'uses' => 'StockController@service_area']);
    Route::get('/App', ['as' => 'backend.stocks.indexApp', 'uses' => 'StockController@indexApp']);
    Route::get('/create', ['as' => 'backend.stocks.create', 'uses' => 'StockController@create']);
    Route::post('/create', ['as' => 'backend.stocks.create', 'uses' => 'StockController@store']);
    Route::get('/getImport', ['as' => 'backend.stocks.getImport', 'uses' => 'StockController@getImport']);
    Route::post('/postImport', ['as' => 'backend.stocks.postImport', 'uses' => 'StockController@postImport']);
    Route::post('create/App', ['as' => 'backend.stocks.createApp', 'uses' => 'StockController@storeApp']);
    Route::get('/{id}/edit', ['as' => 'backend.stocks.edit', 'uses' => 'StockController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.stocks.edit', 'uses' => 'StockController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.stocks.approve', 'uses' => 'StockController@approve']);
    Route::get('/{id}/delete', ['as' => 'backend.stocks.delete', 'uses' => 'StockController@destroy']);
});

Route::group(['prefix' => 'product_images', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/', ['as' => 'backend.product_images.index', 'uses' => 'ProductimageController@index']);
    Route::get('/App', ['as' => 'backend.product_images.indexApp', 'uses' => 'ProductimageController@indexApp']);
    Route::get('/add_image/{id}', ['as' => 'backend.product_images.add_image', 'uses' => 'ProductimageController@add_image']);
    Route::post('/add_image/{id}', ['as' => 'backend.product_images.add_image', 'uses' => 'ProductimageController@store']);
    Route::get('/getImport', ['as' => 'backend.product_images.getImport', 'uses' => 'ProductimageController@getImport']);
    Route::post('/postImport', ['as' => 'backend.product_images.postImport', 'uses' => 'ProductimageController@postImport']);
    Route::post('create/App', ['as' => 'backend.product_images.createApp', 'uses' => 'ProductimageController@storeApp']);
    Route::get('/{id}/edit', ['as' => 'backend.product_images.edit', 'uses' => 'ProductimageController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.product_images.edit', 'uses' => 'ProductimageController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.product_images.approve', 'uses' => 'ProductimageController@approve']);
    Route::get('/{id}/delete', ['as' => 'backend.product_images.delete', 'uses' => 'ProductimageController@destroy']);
    Route::post('/add_image_mobile/{id}', ['as' => 'backend.product_images.add_image_mobile', 'uses' => 'ProductimageController@add_image_mobile']);
});

Route::group(['prefix' => 'upload_prescriptions', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/', ['as' => 'backend.upload_prescriptions.index', 'uses' => 'UploadprescriptionController@index']);
    Route::get('/add_product/{id}', ['as' => 'backend.upload_prescriptions.add_product', 'uses' => 'UploadprescriptionController@add_product']);
    Route::post('/add_product/{id}', ['as' => 'backend.upload_prescriptions.add_product', 'uses' => 'UploadprescriptionController@add_product_store']);
    Route::get('/{id}/edit', ['as' => 'backend.upload_prescriptions.edit', 'uses' => 'UploadprescriptionController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.upload_prescriptions.edit', 'uses' => 'UploadprescriptionController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.upload_prescriptions.approve', 'uses' => 'UploadprescriptionController@approve']);
    Route::get('/{id}/delete', ['as' => 'backend.upload_prescriptions.delete', 'uses' => 'UploadprescriptionController@destroy']);
});

Route::group(['prefix' => 'patient_details'], function () {
    Route::get('/', ['as' => 'backend.patient_details.index', 'uses' => 'PatientDetailController@index']);
    Route::post('/get_detail_on_patient_select', ['as' => 'backend.patient_details.get_detail_on_patient_select', 'uses' => 'PatientDetailController@get_detail_on_patient_select']);
    Route::get('/create', ['as' => 'backend.patient_details.create', 'uses' => 'PatientDetailController@create']);
    Route::post('/create', ['as' => 'backend.patient_details.create', 'uses' => 'PatientDetailController@store']);
    Route::get('/{id}/edit', ['as' => 'backend.patient_details.edit', 'uses' => 'PatientDetailController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.patient_details.edit', 'uses' => 'PatientDetailController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.patient_details.approve', 'uses' => 'PatientDetailController@approve']);
    Route::get('/{id}/delete', ['as' => 'backend.patient_details.delete', 'uses' => 'PatientDetailController@destroy']);
});

Route::group(['prefix' => 'contacts', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/', ['as' => 'backend.contacts.index', 'uses' => 'ContactController@index']);
    Route::get('/{id}/edit', ['as' => 'backend.contacts.edit', 'uses' => 'ContactController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.contacts.edit', 'uses' => 'ContactController@update']);
    Route::get('/{id}/delete', ['as' => 'backend.contacts.delete', 'uses' => 'ContactController@destroy']);
});

Route::group(['prefix' => 'cities', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/', ['as' => 'backend.cities.index', 'uses' => 'CityController@index']);
    Route::get('/getImport', ['as' => 'backend.cities.getImport', 'uses' => 'CityController@getImport']);
    Route::post('/postImport', ['as' => 'backend.cities.postImport', 'uses' => 'CityController@postImport']);
    Route::get('/{id}/delete', ['as' => 'backend.cities.delete', 'uses' => 'CityController@destroy']);
});

Route::group(['prefix' => 'states', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/', ['as' => 'backend.states.index', 'uses' => 'StateController@index']);
    Route::get('/getImport', ['as' => 'backend.states.getImport', 'uses' => 'StateController@getImport']);
    Route::post('/postImport', ['as' => 'backend.states.postImport', 'uses' => 'StateController@postImport']);
    Route::get('/{id}/delete', ['as' => 'backend.states.delete', 'uses' => 'StateController@destroy']);
});

Route::group(['prefix' => 'comparative_products', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/list/{id}', ['as' => 'backend.comparative_products.list', 'uses' => 'ComparativeProductController@list']);
    Route::get('/create', ['as' => 'backend.comparative_products.create', 'uses' => 'ComparativeProductController@create']);
    Route::post('/create', ['as' => 'backend.comparative_products.create', 'uses' => 'ComparativeProductController@store']);
    Route::get('/{id}/edit', ['as' => 'backend.comparative_products.edit', 'uses' => 'ComparativeProductController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.comparative_products.edit', 'uses' => 'ComparativeProductController@update']);
    Route::get('/{id}/approve', ['as' => 'backend.comparative_products.approve', 'uses' => 'ComparativeProductController@approve']);
    Route::get('/{id}/delete', ['as' => 'backend.comparative_products.delete', 'uses' => 'ComparativeProductController@destroy']);
});

Route::group(['prefix' => 'offices', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/', ['as' => 'backend.offices.index', 'uses' => 'OfficeController@index']);
    Route::get('/{id}/edit', ['as' => 'backend.offices.edit', 'uses' => 'OfficeController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.offices.edit', 'uses' => 'OfficeController@update']);
    Route::get('/{id}/delete', ['as' => 'backend.offices.delete', 'uses' => 'OfficeController@destroy']);
});

Route::group(['prefix' => 'user_login_logs', 'middleware' => ['auth', 'role:Admin']], function () {
    Route::get('/', ['as' => 'backend.user_login_logs.index', 'uses' => 'UserloginlogController@index']);
    Route::get('/user_add_to_card_but_shop', ['as' => 'backend.user_login_logs.user_add_to_card_but_shop', 'uses' => 'UserloginlogController@user_add_to_card_but_shop']);
    Route::get('/view_chemist_cart_detail/{user_id}', ['as' => 'backend.user_login_logs.view_chemist_cart_detail', 'uses' => 'UserloginlogController@view_chemist_cart_detail']);
    Route::get('/registered_user_list', 'UserloginlogController@registered_user_list')->name('backend.user_login_logs.registered_user_list');
    Route::get('/testing_user_list', 'UserloginlogController@testing_user_list')->name('backend.user_login_logs.testing_user_list');
    Route::get('/change_user/{id}', 'UserloginlogController@change_user')->name('backend.user_login_logs.change_user');
    Route::get('/{id}/edit', ['as' => 'backend.user_login_logs.edit', 'uses' => 'UserloginlogController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.user_login_logs.edit', 'uses' => 'UserloginlogController@update']);
    Route::get('/{id}/delete', ['as' => 'backend.user_login_logs.delete', 'uses' => 'UserloginlogController@destroy']);
    Route::post('/change_into_testing', ['as' => 'backend.user_login_logs.change_into_testing', 'uses' => 'UserloginlogController@change_into_testing']);
});

Route::group(['prefix' => 'order_settings', 'middleware' => ['auth', 'role:Admin', 'role:Admin']], function () {
    Route::get('/', ['as' => 'backend.order_settings.index', 'uses' => 'OrderSettingController@index']);
    Route::get('/create', ['as' => 'backend.order_settings.create', 'uses' => 'OrderSettingController@create']);
    Route::post('/create', ['as' => 'backend.order_settings.create', 'uses' => 'OrderSettingController@store']);
    Route::get('/{id}/edit', ['as' => 'backend.order_settings.edit', 'uses' => 'OrderSettingController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.order_settings.edit', 'uses' => 'OrderSettingController@update']);
    Route::get('/{id}/delete', ['as' => 'backend.order_settings.delete', 'uses' => 'OrderSettingController@destroy']);
});

Route::group(['prefix' => 'stock_notifications', 'role:Admin'], function () {
    Route::get('/', ['as' => 'backend.stock_notifications.index', 'uses' => 'StockNotificationController@index']);
    Route::get('/create', ['as' => 'backend.stock_notifications.create', 'uses' => 'StockNotificationController@create']);
    Route::post('/create', ['as' => 'backend.stock_notifications.create', 'uses' => 'StockNotificationController@store']);
    Route::get('/{id}/edit', ['as' => 'backend.stock_notifications.edit', 'uses' => 'StockNotificationController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.stock_notifications.edit', 'uses' => 'StockNotificationController@update']);
    Route::get('/{id}/delete', ['as' => 'backend.stock_notifications.delete', 'uses' => 'StockNotificationController@destroy']);
});

Route::group(['prefix' => 'doctor_appointments', 'role:Admin'], function () {
    Route::get('/doctor_call_missed/{id}', ['as' => 'backend.doctor_appointments.doctor_call_missed', 'uses' => 'DoctorAppointmentController@doctor_call_missed']);
    Route::get('/prescription_submit_now/{id}', ['as' => 'backend.doctor_appointments.prescription_submit_now', 'uses' => 'DoctorAppointmentController@prescription_submit_now']);
    Route::get('/', ['as' => 'backend.doctor_appointments.index', 'uses' => 'DoctorAppointmentController@index']);
    Route::get('/prescribed_now/{id}', ['as' => 'backend.doctor_appointments.prescribed_now', 'uses' => 'DoctorAppointmentController@prescribed_now']);
    Route::get('/add_product_in_patient_cart/{id}', ['as' => 'backend.doctor_appointments.add_product_in_patient_cart', 'uses' => 'DoctorAppointmentController@add_product_in_patient_cart']);
    Route::post('/add_product_in_patient_cart/{id}', ['as' => 'backend.doctor_appointments.add_product_in_patient_cart', 'uses' => 'DoctorAppointmentController@add_product_in_patient_cart_store']);
    Route::get('/create', ['as' => 'backend.doctor_appointments.create', 'uses' => 'DoctorAppointmentController@create']);
    Route::post('/create', ['as' => 'backend.doctor_appointments.create', 'uses' => 'DoctorAppointmentController@store']);
    Route::post('/{id}/accepted', ['as' => 'backend.doctor_appointments.accepted', 'uses' => 'DoctorAppointmentController@accepted']);
    Route::get('/{id}/rejected', ['as' => 'backend.doctor_appointments.rejected', 'uses' => 'DoctorAppointmentController@rejected']);
    Route::get('/{id}/edit', ['as' => 'backend.doctor_appointments.edit', 'uses' => 'DoctorAppointmentController@edit']);
    Route::post('/{id}/edit', ['as' => 'backend.doctor_appointments.edit', 'uses' => 'DoctorAppointmentController@update']);
    Route::get('/{id}/delete', ['as' => 'backend.doctor_appointments.delete', 'uses' => 'DoctorAppointmentController@destroy']);
});

Route::get('/Brand/{brand_url_name}', 'FrontendController@brand_page')->name('frontend.brand_page');
Route::get('/{group_url_name}', 'FrontendController@group_page')->name('frontend.group_page');
Route::get('/{group_url_name}/{groupcategory_url_name}', 'FrontendController@groupcategory_page')->name('frontend.groupcategory_page');
Route::get('/{group_url_name}/{groupcategory_url_name}/{product_name}', 'FrontendController@product_detail')->name('frontend.product_detail');