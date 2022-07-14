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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('get_payment_gateway/App', 'PaymentGatewayController@get_payment_gateway_App')->name('get_payment_gateway_App');

Route::post('/data_get_by_pincode/App', 'APIController@data_get_by_pincode_App')->name('data_get_by_pincode_App');

Route::post('/customer/login/App', 'UserController@customer_login_App')->name('customer_login_App');
Route::post('/customer/send_otp_for_login/App', 'UserController@customer_send_otp_for_login_App')->name('customer_send_otp_for_login_App');
Route::post('/customer/otp_verify_login/App', 'UserController@customer_otp_verify_login_App')->name('customer_otp_verify_login_App');

Route::post('/customer/registration/App', 'UserController@customer_registration_App')->name('customer_registration_App');
Route::post('/customer/registration/otp/verify/App', 'UserController@customer_registration_otp_verify_App')->name('customer_registration_otp_verify_App');

Route::post('/registration/App', 'UserController@registration_App')->name('registration_App');
Route::post('/login/App', 'UserController@login_App')->name('login_App');
Route::post('/registration/otp/verify/App', 'UserController@registration_otp_verify_App')->name('registration_otp_verify_App');
Route::post('/send_otp_for_login/App', 'UserController@send_otp_for_login_App')->name('send_otp_for_login_App');
Route::post('/otp_verify_login/App', 'UserController@otp_verify_login_App')->name('otp_verify_login_App');
Route::get('/paytm_payment_config/App', 'APIController@paytm_payment_config_App')->name('paytm_payment_config_App');
Route::get('/terms_and_conditions/App', 'APIController@terms_and_conditions_App')->name('terms_and_conditions_App');
Route::get('/cancellation_return_and_refund_policy/App', 'APIController@cancellation_return_and_refund_policy_App')->name('cancellation_return_and_refund_policy_App');

Route::group(['prefix' => 'customer'], function () {
    Route::post('/delete_address/App', 'CustomerAPIController@customer_delete_address_App')->name('customer_delete_address_App');
    Route::post('/home/App', 'CustomerAPIController@customer_home_App')->name('customer_home_App');
    Route::get('/our_products/App', 'CustomerAPIController@our_products_App')->name('customer_our_products_App');
    Route::post('/products_by_brand/App', 'CustomerAPIController@customer_products_by_brand_App')->name('customer_products_by_brand_App');
    Route::get('/group_list/App', 'CustomerAPIController@group_list_App')->name('group_list_App');
    Route::get('/group_category_list/App', 'CustomerAPIController@customer_group_category_list_App')->name('customer_group_category_list_App');
    Route::get('/group_with_groupcategory/App', 'CustomerAPIController@customer_group_with_groupcategory_App')->name('customer_group_with_groupcategory_App');
    Route::post('/product_detail/App', 'CustomerAPIController@customer_product_detail_App')->name('product_detail_App');
    Route::post('/products_by_group/App', 'CustomerAPIController@customer_products_by_group_App')->name('customer_products_by_group_App');
    Route::post('/products_by_groupcategory/App', 'CustomerAPIController@customer_products_by_groupcategory_App')->name('customer_products_by_groupcategory_App');
    Route::post('/customer_add_to_cart/App', 'CustomerAPIController@customer_add_to_cart_App')->name('customer_add_to_cart_App');
    Route::post('/my_cart/App', 'CustomerAPIController@customer_my_cart_App')->name('customer_my_cart_App');
    Route::post('/remove_from_my_cart/App', 'CustomerAPIController@customer_remove_from_my_cart_App')->name('customer_remove_from_my_cart_App');
    Route::post('/place_your_order/App', 'CustomerAPIController@customer_place_your_order_App')->name('customer_place_your_order_App');
    Route::post('/add_address/App', 'CustomerAPIController@customer_add_address_App')->name('customer_add_address_App');
    Route::post('/get_address/App', 'CustomerAPIController@customer_get_address_App')->name('customer_get_address_App');
    Route::post('/edit_address/App', 'CustomerAPIController@customer_edit_address_App')->name('customer_edit_address_App');
    Route::post('/change_address/App', 'CustomerAPIController@customer_change_address_App')->name('customer_change_address_App');
    Route::post('/set_as_a_default_address/App', 'CustomerAPIController@customer_set_as_a_default_address_App')->name('customer_set_as_a_default_address_App');
    Route::post('/responce_from_paytm/App', 'CustomerAPIController@customer_responce_from_paytm_App')->name('customer_responce_from_paytm_App');
    Route::post('get_search_data_after_filter/App', 'SearchController@customer_get_search_data_after_filter_App')->name('customer_get_search_data_after_filter_App');
    Route::post('/search/App', 'CustomerAPIController@customer_search_App')->name('customer_search_App');
    Route::post('/list_of_order_history/App', 'CustomerAPIController@customer_list_of_order_history_App')->name('customer_list_of_order_history_App');
    Route::post('/order_detail/App', 'CustomerAPIController@customer_order_detail_App')->name('customer_order_detail_App');
    Route::post('customer_account/App', 'CustomerAPIController@customer_account_App')->name('customer_account_App');
    Route::post('book_an_appointment/App', 'CustomerAPIController@customer_book_an_appointment_App')->name('customer_book_an_appointment_App');
    Route::post('doctor_prescribed_product/add_to_mycart/App', 'DoctorAppointmentController@doctor_prescribed_product_add_to_mycart_App')->name('customer_doctor_prescribed_product_add_to_mycart_App');
    Route::post('add_to_cart_guest_to_login_user/App', 'CustomerAPIController@customer_add_to_cart_guest_to_login_user_App')->name('customer_add_to_cart_guest_to_login_user_App');
    Route::post('/current_reward_balance/App', 'CustomerAPIController@customer_current_reward_balance_App')->name('customer_current_reward_balance_App');
    Route::group(['middleware' => 'auth:api'], function () {
  
        Route::post('get_reward_ledger/App', 'CustomerAPIController@customer_get_reward_ledger_App')->name('customer_get_reward_ledger_App');
        Route::post('get_doctor_appointment_list/App', 'DoctorAppointmentController@customer_get_doctor_appointment_list_App')->name('customer_get_doctor_appointment_list_App');
        Route::post('doctor_appointment_detail/App', 'DoctorAppointmentController@customer_doctor_appointment_detail_App')->name('customer_doctor_appointment_detail_App');
    });

});
Route::post('/chat_submit/App', 'ChatController@chat_submit_App')->name('chat_submit_App');

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/chemist_home/App', 'APIController@chemist_home_App')->name('chemist_home_App');
    Route::post('/search/App', 'APIController@search_App')->name('search_App');
    Route::get('get_filter_data/App', 'APIController@get_filter_data_App')->name('get_filter_data_App');
    Route::post('get_search_data_after_filter/App', 'SearchController@get_search_data_after_filter_App')->name('get_search_data_after_filter_App');

    Route::get('user_detail', 'APIController@user_detail');

    Route::post('/reward_point/App', 'RewardPointController@reward_point_App')->name('reward_point_App');

    Route::post('/chemist_account/App', 'APIController@chemist_account_App')->name('chemist_account_App');
    Route::post('/get_reward_ledger/App', 'APIController@get_reward_ledger_App')->name('get_reward_ledger_App');
    Route::post('/current_reward_balance/App', 'APIController@current_reward_balance_App')->name('current_reward_balance_App');

    Route::post('/re_order/App', 'APIController@re_order_App')->name('re_order_App');
    Route::get('chat_bot/App', 'APIController@chat_bot_App')->name('chat_bot_App');
    Route::get('minimum_order_amount/App', 'APIController@minimum_order_amount_App')->name('minimum_order_amount_App');

    Route::get('details/App', 'PaytmController@detailsApp')->name('detailsApp');
    Route::get('chat_request_submit/App', 'PaytmController@chat_request_submit_App')->name('chat_request_submit_App');

    Route::get('logout/App', 'PaytmController@logoutApp')->name('logoutApp');

    Route::post('/stock_notification/App', 'StockNotificationController@stock_notification_App')->name('stock_notification_App');
    Route::post('/contact/App', 'ContactController@contact_store_App')->name('contact_App');
    Route::get('/home/App', 'APIController@home_App')->name('home_App');
    Route::get('/aboutus/App', 'APIController@aboutus_App')->name('aboutus_App');
    Route::post('/get_wallet/App', 'APIController@get_wallet_App')->name('get_wallet_App');

    Route::get('/group_pages/{id}/App', 'APIController@group_pages_App')->name('group_pages_App');
    Route::get('/groupcategory_pages/{id}/App', 'APIController@groupcategory_pages_App')->name('groupcategory_pages_App');
    Route::post('/product_detail/App', 'APIController@product_detail_App')->name('product_detail_App');
    Route::post('/our_products/App', 'APIController@our_products_App')->name('our_products_App');
    Route::post('/book_a_doctor_appointment/App', 'APIController@book_a_doctor_appointment_App')->name('book_a_doctor_appointment_App');
    Route::post('/list_of_order_history/App', 'APIController@list_of_order_history_App')->name('list_of_order_history_App');
    Route::post('/chemist_order_history/App', 'APIController@chemist_order_history_App')->name('chemist_order_history_App');

    Route::post('/order_detail/App', 'APIController@order_detail_App')->name('order_detail_App');
    Route::post('/get_order_detail_from_order_list/App', 'APIController@get_order_detail_from_order_list_App')->name('get_order_detail_from_order_list_App');

    Route::post('/add_to_cart/App', 'AddToCardController@add_to_cart_App')->name('add_to_cart_App');
    Route::post('/my_cart/App', 'AddToCardController@my_cart_App')->name('my_cart_App');
    Route::post('/my_cart_count/App', 'AddToCardController@my_cart_count_App')->name('my_cart_count_App');

    Route::post('/remove_from_my_cart/App', 'AddToCardController@remove_from_my_cart_App')->name('remove_from_my_cart_App');
    Route::post('/upload_prescription/App', 'APIController@upload_prescription_App')->name('upload_prescription_App');

    Route::get('/wellness_product/App', 'APIController@wellness_product_App')->name('wellness_product_App');
    Route::get('/offer_products/App', 'APIController@offer_products_App')->name('offer_products_App');
    Route::post('/search_my_order/App', 'APIController@search_my_order_App')->name('search_my_order_App');
    Route::post('/add_address/App', 'APIController@add_address_App')->name('add_address_App');
    Route::post('/get_address/App', 'APIController@get_address_App')->name('get_address_App');
    Route::post('/edit_address/App', 'APIController@edit_address_App')->name('edit_address_App');
    Route::post('/change_address/App', 'APIController@change_address_App')->name('change_address_App');
    Route::post('/set_as_a_default_address/App', 'APIController@set_as_a_default_address_App')->name('set_as_a_default_address_App');
    Route::post('/place_your_order/App', 'OrderController@place_your_order_App')->name('place_your_order_App');
    Route::post('/place_your_order_checksum/App', 'OrderController@place_your_order_checksum_App')->name('place_your_order_checksum_App');
    Route::post('/checksum_match/App', 'OrderController@checksum_match_App')->name('checksum_match_App');
    Route::post('/products_by_group/App', 'APIController@products_by_group_App')->name('products_by_group_App');
    Route::post('/products_by_groupcategory/App', 'APIController@products_by_groupcategory_App')->name('products_by_groupcategory_App');
    Route::post('/products_by_brand/App', 'APIController@products_by_brand_App')->name('products_by_brand_App');
    Route::get('/group_with_groupcategory/App', 'APIController@group_with_groupcategory_App')->name('group_with_groupcategory_App');
    Route::get('/all_state_city/App', 'APIController@all_state_city_App')->name('all_state_city_App');
    Route::post('/state_city_by_pinocode/App', 'APIController@state_city_by_pinocode_App')->name('state_city_by_pinocode_App');
    Route::get('/chatApi/App', 'ChatController@chatApiApp')->name('chatApi_App');
    Route::post('/chemist/create/App', 'ChemistController@create_App')->name('backend.chemists.create_App');

});
Route::post('responce_from_paytm/App', 'OrderController@responce_from_paytm_App')->name('responce_from_paytm_App');
Route::group(['prefix' => 'backsite'], function () {
    
    Route::post('/get_chemist_order_list', ['as' => 'backend.nestor.get_chemist_order_list', 'uses' => 'NestorAPIController@get_chemist_order_list']);
    Route::get('/product_list', ['as' => 'backend.nestor.product_list', 'uses' => 'NestorAPIController@product_list']);
    Route::post('/product_update', ['as' => 'backend.nestor.product_update', 'uses' => 'NestorAPIController@product_update']);
    Route::get('/{id}/delete', ['as' => 'backend.nestor.delete', 'uses' => 'NestorAPIController@destroy']);
    Route::post('/update_order_detail', ['as' => 'backend.nestor.update_order_detail', 'uses' => 'NestorAPIController@update_order_detail']);

    Route::post('/chemist_list', ['as' => 'backend.nestor.chemist_list', 'uses' => 'NestorAPIController@chemist_list']);
    Route::post('chemist_create', ['as' => 'backend.nestor.chemist_create', 'uses' => 'NestorAPIController@chemist_store']);
    Route::post('/chemist_detail', ['as' => 'backend.nestor.chemist_detail', 'uses' => 'NestorAPIController@chemist_detail']);
    Route::post('/chemist_update', ['as' => 'backend.nestor.chemist_update', 'uses' => 'NestorAPIController@chemist_update']);
    Route::get('/chemist_delete', ['as' => 'backend.nestor.chemist_delete', 'uses' => 'NestorAPIController@chemist_destroy']);

    Route::post('/order_detail', ['as' => 'backend.nestor.order_detail', 'uses' => 'NestorAPIController@order_detail']);
    Route::post('/order_list', ['as' => 'backend.nestor.order_list', 'uses' => 'NestorAPIController@order_list']);

    Route::post('/payment_detail', ['as' => 'backend.nestor.payment_detail', 'uses' => 'NestorAPIController@payment_detail']);

    Route::get('/productuses_list', ['as' => 'backend.nestor.product_uses_list', 'uses' => 'NestorAPIController@productuses_list']);

    Route::post('/update_productuses', ['as' => 'backend.nestor.update_productuses', 'uses' => 'NestorAPIController@update_productuses']);

    Route::get('/package_list', ['as' => 'backend.nestor.package_list', 'uses' => 'NestorAPIController@package_list']);

    Route::post('/update_package_detail', ['as' => 'backend.nestor.update_package_detail', 'uses' => 'NestorAPIController@update_package_detail']);

    Route::get('/stock_list', ['as' => 'backend.nestor.stock_list', 'uses' => 'NestorAPIController@stock_list']);
    Route::post('/update_stock_detail', ['as' => 'backend.nestor.update_stock_detail', 'uses' => 'NestorAPIController@update_stock_detail']);

    Route::get('/office_list', ['as' => 'backend.nestor.office_list', 'uses' => 'NestorAPIController@office_list']);
    Route::post('/update_office_detail', ['as' => 'backend.nestor.update_office_detail', 'uses' => 'NestorAPIController@update_office_detail']);

    Route::get('/office_state_list', ['as' => 'backend.nestor.office_state_list', 'uses' => 'NestorAPIController@office_state_list']);
    Route::post('/update_office_state_detail', ['as' => 'backend.nestor.update_office_state_detail', 'uses' => 'NestorAPIController@update_office_state_detail']);

    Route::get('/office_delivery_pin_list', ['as' => 'backend.nestor.office_delivery_pin_list', 'uses' => 'NestorAPIController@office_delivery_pin_list']);
    Route::post('/update_office_delivery_pin_detail', ['as' => 'backend.nestor.update_office_delivery_pin_detail', 'uses' => 'NestorAPIController@update_office_delivery_pin_detail']);

    Route::get('/office_sales_scheme_list', ['as' => 'backend.nestor.office_sales_scheme_list', 'uses' => 'NestorAPIController@office_sales_scheme_list']);
    Route::post('/update_sales_scheme_detail', ['as' => 'backend.nestor.update_sales_scheme_detail', 'uses' => 'NestorAPIController@update_sales_scheme_detail']);
    Route::post('create/App', ['as' => 'backend.chemists.createApp', 'uses' => 'ChemistController@storeApp']);

    Route::get('/product_price_list', ['as' => 'backend.nestor.product_price_list', 'uses' => 'NestorAPIController@product_price_list']);
    Route::post('/update_product_price', ['as' => 'backend.nestor.update_product_price', 'uses' => 'NestorAPIController@update_product_price']);
    Route::post('/add_update_product_use_detail', ['as' => 'backend.nestor.add_update_product_use_detail', 'uses' => 'NestorAPIController@add_update_product_use_detail']);

    Route::post('/add_manufacture', ['as' => 'backend.nestor.add_manufacture', 'uses' => 'NestorAPIController@add_manufacture']);
    Route::get('/TherapeuticCategory_list', ['as' => 'backend.nestor.TherapeuticCategory_list', 'uses' => 'NestorAPIController@TherapeuticCategory_list']);
    Route::post('/update_TherapeuticCategory', ['as' => 'backend.nestor.update_TherapeuticCategory', 'uses' => 'NestorAPIController@update_TherapeuticCategory']);
    Route::post('/Therapeutic_Category_By_Brand_Code', ['as' => 'backend.nestor.Therapeutic_Category_By_Brand_Code', 'uses' => 'NestorAPIController@Therapeutic_Category_By_Brand_Code']);
    Route::post('/Product_List_by_Therapeutic_Category_Code', ['as' => 'backend.nestor.Product_List_by_Therapeutic_Category_Code', 'uses' => 'NestorAPIController@Product_List_by_Therapeutic_Category_Code']);
    Route::post('/Product_Details_By_Product_Code', ['as' => 'backend.nestor.Product_Details_By_Product_Code', 'uses' => 'NestorAPIController@Product_Details_By_Product_Code']);

    Route::post('/Add_Product_HashTag', ['as' => 'backend.nestor.Add_Product_HashTag', 'uses' => 'NestorAPIController@Add_Product_HashTag']);
    Route::post('/Add_ProductHashTag_Detail', ['as' => 'backend.nestor.Add_ProductHashTag_Detail', 'uses' => 'NestorAPIController@Add_ProductHashTag_Detail']);
    Route::post('/Add_Product_Therapeutic', ['as' => 'backend.nestor.Add_Product_Therapeutic', 'uses' => 'NestorAPIController@Add_Product_Therapeutic']);
    Route::post('/Add_Ayuveda_Product_On_App', ['as' => 'backend.nestor.Add_Ayuveda_Product_On_App', 'uses' => 'NestorAPIController@Add_Ayuveda_Product_On_App']);

});