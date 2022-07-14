<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $addHttpCookie = true;

    protected $except = [
        'pageregisterApp',
        'pageloginApp',
        'details/App',
        'registerpage',
        'registration_varificationApp',
        'otp_verify_login/App',
        'customer/registration/otp/verify/App',
        'loginpage',
        '/registration/App',
        'loginpage_password',
        '/chemist_form',
        '/add_payment_status',
        'payment_callback',
        'logout/App',
        'abc_logout/App',
        'state_city_by_pinocode/App',
        'dashboard/backurl_wallet_recharge',
        'chemists/create/App',
        'backsite/chemist_update',
        'customer/customer_account/App',
        'customer/customer_add_to_cart/App',
        'payment_customer_callback',
        'customer/book_an_appointment/App',
    ];
}