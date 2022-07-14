<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PaytmWallet;

class CustomerPaymentController extends Controller
{
    public function customer_pay(Request $request)
    {

        $site_route = $request->getSchemeAndHttpHost();
        if (\Auth::user()->ApprovalSatus_Code == 3) {
            config(['services.paytm-wallet.env' => 'local']);
            config(['services.paytm-wallet.merchant_id' => 'YtBoHw17737500171583']);
            config(['services.paytm-wallet.merchant_key' => 'zTU5qr5NnXmcmTy5']);
            config(['services.paytm-wallet.merchant_website' => 'WEBSTAGING']);
        } else {
            config(['services.paytm-wallet.env' => 'production']);
            config(['services.paytm-wallet.merchant_id' => 'NESTOR42509796971890']);
            config(['services.paytm-wallet.merchant_key' => 'yZt!E@hjd9AgJ5aM']);
            // config(['services.paytm-wallet.merchant_id' => 'yEcytO49536340286191']);
            // config(['services.paytm-wallet.merchant_key' => 'wzL8t&aSOeWrFvwY']);
            config(['services.paytm-wallet.merchant_website' => 'DEFAULT']);
        }
        $reward = $request->reward;
        if (\Auth::user()->role == 'User') {
            $chemist = \App\Chemist::where('user_id', '=', \Auth::user()->id)->first();
        } else {
        }
        $payment = PaytmWallet::with('receive');
        $product_carts = \App\Addtocard::where('user_id', '=', \Auth::user()->id)->get();
        $card_subtotal = 0;
        $wallet = 0;
        $grand_total = 0;
        if (\Auth::user()->role == 'User') {
            if (\Auth::user()->wallet > 100) {
                $wallet = 100;
            } else {
                $wallet = \Auth::user()->wallet;
            }
            if ($reward) {
                $wallet = $reward;
            }
        }
        

        $address = \App\Address::where('user_id', '=', \Auth::user()->id)->where('set_as_a_current', '=', 'Yes')
            ->where('set_as_a_default', '=', 'Yes')
            ->first();

        if ($address) {
            $pincode = \App\Pincode::where('pincode', '=', $address->PIN)->first();

            if ($pincode) {
                $office_state = \App\OfficeState::where('State_Code', '=', $pincode->state_id)->first();
            } else {
                $office_state = \App\OfficeState::where('State_Code', '=', $pincode->state_id)->first();
            }
        }

        $stock_arr = [];
        foreach ($product_carts as $product_cart) {
            $subtotal = 0;
            $amount = 0;
            $discount = 0;
            $without_gst_amount = 0;
            $product_detail = \App\Product::find($product_cart->product_id);

            $sales_scheme = \App\SalesScheme::where('Product_Code', '=', $product_detail->product_code)->first();
            $produc_qty = 0;
            if ($sales_scheme&&$sales_scheme->Category_Code==1) {
                $dividend = $product_cart->Qty;
                $divisor = $sales_scheme->NextMinSaleQty_ForScheme;
                $output = intdiv($dividend, $divisor);
                $produc_qty = $product_cart->Qty + $output * $sales_scheme->Free_Qty;
            } else {
                $produc_qty = $product_cart->Qty;
            }
            if (\Auth::user()->role == 'User') {
                if ($product_detail->package) {
                    $produc_qty = $produc_qty / $product_detail->package->PrimaryPack_Qty;
                }
            }
            if ($office_state) {
                $stock = \App\Stock::where('Office_Code', '=', $office_state->Office_Code)->where('Product_Code', '=', $product_detail->product_code)->first();
                $check = 0;
                if ($stock) {
                    $check = $stock->QtyForNewOrder + $stock->Hold_Qty;
                    if ($check >= $produc_qty) {
                        $stock_arr1 = [];
                        $stock_arr1['Hold_Qty'] = $produc_qty;
                        $stock_arr1['Office_Code'] = $office_state->Office_Code;
                        $stock_arr1['Product_Code'] = $product_detail->product_code;
                        $stock_arr[] = $stock_arr1;
                    } else {
                        session()->flash('error', 'Stock Of ' . $product_detail->brand_name . ' Are Not Available For This Location');
                        return redirect()->back();
                    }
                } else {
                    session()->flash('error', 'Stock Of ' . $product_detail->brand_name . ' Are Not Available For This Location');
                    return redirect()->back();
                }
            } else {
                session()->flash('error', 'Stock Are Not Available For This Location');
                return redirect()->back();
            }

            if ($product_detail) {
                if (\Auth::user()->role == 'Chemist') {
                    $product_price = \App\Productprice::where('Product_Code', '=', $product_detail->product_code)
                        ->where('ProductPriceType_Code', '=', 7)
                        ->first();
                } else {

                    $product_price = \App\Productprice::where('Product_Code', '=', $product_detail->product_code)
                        ->where('ProductPriceType_Code', '=', 9)
                        ->first();
                }
            }
            
            
            $sales_scheme = \App\SalesScheme::where('Product_Code', '=', $product_detail->product_code)->where('schemefor',2)->first();
       
            if ($sales_scheme&&$sales_scheme->SchemeOn_Code==3) {
               
            $without_gst_amount = $product_price->Price - $product_price->Price*$sales_scheme->Discount/100;
                $subtotal = $without_gst_amount * $product_cart->Qty;
                $card_subtotal = $card_subtotal + $without_gst_amount * $product_price->Qty;    
            }else{
               
                $without_gst_amount = $product_price->Price;
                $subtotal = $without_gst_amount * $product_cart->Qty;
                $card_subtotal = $card_subtotal + $without_gst_amount * $product_price->Qty;
            }

           

            $amount = $subtotal;
            
            
            if (\Auth::user()->role == 'Chemist') {
                $gst_amount = $subtotal * $product_price->GST / 100;
                $p_tax =  $subtotal * $product_price->GST / 100;
            } else {
                $p_tax =  $subtotal * $product_price->GST / 100;
                $gst_amount = $subtotal * $product_price->GST / 100;
            }
           
            $p_total = $amount + $p_tax;
            $grand_total = $grand_total + $subtotal + $gst_amount;
        }
        if (\Auth::user()->role == 'Chemist') {
            $Delivery_Amount = 0;
        } else {
            if($grand_total>=500){

                $Delivery_Amount = 0;
            }else{

                $wallet =0;
                $Delivery_Amount = 50;  
            }
        }

        $grand_total_invoice = $grand_total + $Delivery_Amount - $wallet;

        foreach ($stock_arr as $stock_ar) {
            $stock1 = \App\Stock::where('Office_Code', '=', $stock_ar['Office_Code'])->where('Product_Code', '=', $stock_ar['Product_Code'])->first();

            $stock_hold = \App\StockHold::where('User_Id', '=', \Auth::user()->id)->where('Office_Code', '=', $stock_ar['Office_Code'])->where('Product_Code', '=', $stock_ar['Product_Code'])->first();
            if ($stock_hold) {
                $stock1->Hold_Qty = $stock1->Hold_Qty - $stock_hold->Hold_Qty + $stock_ar['Hold_Qty'];
                $stock1->save();
                $stock_hold->Hold_Qty = $stock_ar['Hold_Qty'];
                $stock_hold->save();
            } else {
                $stock_hold = \App\StockHold::create([
                    'User_Id' => \Auth::user()->id,
                    'Product_Code' => $stock_ar['Product_Code'],
                    'Hold_Qty' => $stock_ar['Hold_Qty'],
                    'Office_Code' => $stock_ar['Office_Code'],
                ]);
                $stock1->Hold_Qty = $stock1->Hold_Qty + $stock_ar['Hold_Qty'];
                $stock1->save();
            }

        }
        if (\Auth::user()->role == 'User') {
            $Doctor_Consult = request()->cookie('DoctorConsult');
            $DoctorConsult = json_decode($Doctor_Consult);
        } else {
            $DoctorConsult = null;
        }

        $payment_request = \App\Payment::create([
            'Order_Code' => "",
            'ResponseTransID' => '',
            'Party_Code' => 0,
            'Requested_Amount' => number_format($grand_total_invoice, 2, '.', ''),
            'PaymentMode' => '',
            'TransactionTime' => date('Y-m-d H:m:s'),
            'TransStatus' => 'TXN_PENDING',
            'Response_Code' => '02',
            'RESPMSG' => '',
            'GatewayName' => '',
            'BankTransID' => '',
            'BankName' => '',
            'User_ID' => \Auth::user()->id,
            'DoctorConsult_id' => $DoctorConsult,
            'Wallet_Amount' => $wallet,
        ]);
        if (\Auth::user()->role == 'Chemist') {
            $payment_request->Party_Code = $chemist->Party_Code;
        } else {
            $payment_request->Party_Code = 0;
        }
        $payment_request->save();
        $payment->prepare([
            'order' => 'NMLID-' . $payment_request->id, // your order id taken from cart
            'user' => \Auth::user()->id, // your user id
            'mobile_number' => \Auth::user()->mobile, // your customer mobile no
            'email' => \Auth::user()->mobile . '@gmail.com', // your user email address
            'amount' => number_format(round($grand_total_invoice), 2, '.', ''), // amount will be paid in INR.
            'callback_url' => $site_route . '/payment_customer_callback', // callback URL
        ]);
        return $payment->receive();
    }

    /**
     * Obtain the payment information.
     *
     * @return Object
     */
    public function payment_customer_callback(Request $request)
    {
           
        config(['services.paytm-wallet.env' => 'local']);
        config(['services.paytm-wallet.merchant_id' => 'YtBoHw17737500171583']);
        config(['services.paytm-wallet.merchant_key' => 'zTU5qr5NnXmcmTy5']);
        config(['services.paytm-wallet.merchant_website' => 'WEBSTAGING']);
        
        $transaction = PaytmWallet::with('receive');

        $response = $transaction->response();

        // To get raw response as array
        //Check out response parameters sent by paytm here -> http://paywithpaytm.com/developer/paytm_api_doc?target=interpreting-response-sent-by-paytm
        if ($transaction->isSuccessful()) {
            $payment_id = explode('-', $response['ORDERID']);
            $payment = \App\Payment::find($payment_id[1]);
            $user = \App\User::find($payment->User_ID);
            Auth::login($user);
            $payment->Order_Code = $response['ORDERID'];
            $payment->ResponseTransID = $response['TXNID'];
            $payment->Requested_Amount = $response['TXNAMOUNT'];
            $payment->PaymentMode = $response['PAYMENTMODE'];
            $payment->TransactionTime = $response['TXNDATE'];
            $payment->TransStatus = $response['STATUS'];
            $payment->Response_Code = $response['RESPCODE'];
            $payment->GatewayName = $response['GATEWAYNAME'];
            $payment->BankTransID = $response['BANKTXNID'];

            $wallet = 0;
            if (\Auth::user()) {
                if (\Auth::user()->wallet > 100) {
                    $wallet = 100;
                } else {
                    $wallet = \Auth::user()->wallet;
                }
                $user->wallet = $user->wallet - $wallet;
                $user->save();
            }

            $address = \App\Address::where('user_id', '=', \Auth::user()->id)->where('set_as_a_current', '=', 'Yes')
                ->where('set_as_a_default', '=', 'Yes')
                ->first();
            if ($address) {
            } else {
                $address = \App\Address::where('user_id', '=', \Auth::user()->id)->where('set_as_a_current', '=', 'Yes')
                    ->where('set_as_a_default', '=', 'Yes')
                    ->first();
            }

            $order = \App\Order::create([
                'user_id' => \Auth::user()->id,
                'Party_Name' => $address->Contact_Person,
                'Address1' => $address->Address1,
                'Address2' => $address->Address2,
                'Address3' => $address->Address3,
                'Mobile_No' => $address->Mobile_No,
                'PIN' => $address->PIN,
                'City_Code' => $address->City_Code,
                'State_Code' => $address->State_Code,
                'DoctorConsult_id' => $payment->DoctorConsult_id,
            ]);

            $payment->Order_ID = $order->id;
            $payment->Testing_Payment = 1;
            $payment->save();
            $product_carts = \App\Addtocard::where('user_id', '=', \Auth::user()->id)->get();
            $card_subtotal = 0;
            $grand_total = 0;
            $gst_amount = 0;

            foreach ($product_carts as $product_cart) {
                $subtotal = 0;
                $amount = 0;
                $discount = 0;
                
                $product_detail = \App\Product::find($product_cart->product_id);

                if ($product_detail) {
                    if (\Auth::user()->role == 'Chemist') {
                        $product_price = \App\Productprice::where('Product_Code', '=', $product_detail->product_code)
                            ->where('ProductPriceType_Code', '=', 7)
                            ->first();
                        $mrp_product_price = \App\Productprice::where('Product_Code', '=', $product_detail->product_code)->where('ProductPriceType_Code', '=', '8')->first();

                    } else {
                        $mrp_product_price = \App\Productprice::where('Product_Code', '=', $product_detail->product_code)->where('ProductPriceType_Code', '=', '10')->first();
                        $product_price = \App\Productprice::where('Product_Code', '=', $product_detail->product_code)
                            ->where('ProductPriceType_Code', '=', 9)
                            ->first();
                    }
                }
                $without_gst_amount = 0.00;
                $sales_scheme = \App\SalesScheme::where('Product_Code', '=', $product_detail->product_code)->where('schemefor',2)->first();
       
                if ($sales_scheme&&$sales_scheme->SchemeOn_Code==3) {
                $discount = $product_price->Price*$sales_scheme->Discount/100;
                $without_gst_amount = $product_price->Price - $product_price->Price*$sales_scheme->Discount/100;
                    $subtotal = $without_gst_amount * $product_cart->Qty;
                    $card_subtotal = $card_subtotal + $without_gst_amount * $product_cart->Qty;
                }else{
                    $discount = 0;
                    $without_gst_amount = $product_price->Price;
                    $subtotal = $without_gst_amount * $product_cart->Qty;
                    $card_subtotal = $card_subtotal + $without_gst_amount * $product_cart->Qty;
                }
               
                $amount = $subtotal;
                $p_tax = $amount * $product_price->GST / 100;
                $p_total = $amount + $p_tax;
                $order_product = \App\OrderProduct::create([
                    'Order_Id' => $order->id,
                    'product_id' => $product_detail->id,
                    'Product_Code' => $product_detail->product_code,
                    'Order_Qty' => $product_cart->Qty,
                    'Rate' => $without_gst_amount,
                    'Amount' => $amount,
                    'Taxable' => $subtotal,
                    'TaxRate' => $product_price->GST,
                    'Tax' => $p_tax,
                    'Total' => $p_total,
                    'Discount' => $product_detail->offer,
                ]);
                $sales_scheme = \App\SalesScheme::where('SchemeOn_Code',1)->where('Product_Code', '=', $order_product->Product_Code)->first();
                if ($sales_scheme) {
                    $dividend = $product_cart->Qty;
                    $divisor = $sales_scheme->NextMinSaleQty_ForScheme;
                    $output = intdiv($dividend, $divisor);
                    $order_product->Free_Qty = $output * $sales_scheme->Free_Qty;
                }
                if ($mrp_product_price) {
                    $order_product->MRP = $mrp_product_price->Price;
                } else {
                    $order_product->MRP = 0;
                }
                $order_product->save();

                if ($user->role == 'Chemist') {
                    $gst_amount = $gst_amount + $subtotal * $product_price->GST / 100;
                } else {
                    $gst_amount = $gst_amount + $subtotal * $product_price->GST / 100;
                }
                if ($product_cart->doctor_description_id) {
                    $order->doctorappointment_id = $product_cart->doctor_description_id;
                    $order->save();
                } else {

                }

            }
            foreach ($product_carts as $product_cart) {
                if ($product_cart->count()) {
                    $product_cart->delete();
                }
            }
            if (\Auth::user()->role == 'Chemist') {
                $chemist = \App\Chemist::where('user_id', '=', \Auth::user()->id)->first();
                $order->Party_Name = $chemist->Party_Name;
                $order->Party_ID = $chemist->id;
                $order->Party_Code = $chemist->Party_Code;
                $order->GSTIN = $chemist->GSTIN;
                $order->DL_No = $chemist->DL_No;
                $order->Contact_Person = $chemist->Contact_Person;
            } else {
                $order->GSTIN = 'null';
            }
            if (\Auth::user()->role == 'Chemist') {
                $Delivery_Amount = 0;
            } else {
                $grand_total1 = 0;
                $grand_total1 = $card_subtotal + $gst_amount;
                if($grand_total1 >=500 ){
                    $Delivery_Amount = 0;
                }else{
                    $Delivery_Amount = 50;
                }
                
            }

            $grand_total = $card_subtotal + $Delivery_Amount + $gst_amount;
            $grand_total_invoice = $card_subtotal - $wallet + $Delivery_Amount + $gst_amount;
            $pincode = \App\Pincode::where('pincode', '=', $order->PIN)->first();
            $office_state = \App\OfficeState::where('State_Code', '=', $pincode->state_id)->first();
            $order->Delivery_Amount = $Delivery_Amount;
            $order->Taxable_Amount = $card_subtotal;
            $order->Tax_Amount = $gst_amount;
            $order->WalletAmount = $wallet;
            $order->Discount_Amount = 0;
            $order->Grand_Total = round($grand_total);

            $order->Order_No = 'NSRID-' . $order->id;
            $order->Order_Date = date('Y-m-d H:i:s');
            $order->Product_Amount = $card_subtotal;
            $order->Payment_Amount = round($grand_total_invoice);
            $order->Payment_Status = $response['STATUS'];
            $order->OrderStatus_Code = 5;
            $order->OrderFrom_Code = 2;
            $order->is_update = 0;
            $order->Testing_Order = 0;

            if ($office_state) {
                $order->Office_Code = $office_state->Office_Code;
            } else {
                $order->Office_Code = 31;
            }

            $order_product_arr = "";
            $order_products = \App\OrderProduct::where('Order_Id', '=', $order->id)->get();
            if ($address) {
                $pincode = \App\Pincode::where('pincode', '=', $order->PIN)->first();
                $office_state = \App\OfficeState::where('State_Code', '=', $pincode->state_id)->first();
            }
            foreach ($order_products as $order_product) {
                $sub = 0;
                $sub = $order_product->Rate * $order_product->Order_Qty;
                $product = \App\Product::find($order_product->product_id);
                $produc_qty = $order_product->Order_Qty + $order_product->Free_Qty;
                if (\Auth::user()->role == 'User') {
                    if ($product->package) {
                        $produc_qty = $produc_qty / $product->package->PrimaryPack_Qty;
                    }
                }

                $stock = \App\Stock::where('Office_Code', '=', $office_state->Office_Code)->where('Product_Code', '=', $order_product->Product_Code)->first();
                if ($stock) {
                    $stock_hold = \App\StockHold::where('User_Id', '=', \Auth::user()->id)->where('Office_Code', '=', $stock->Office_Code)->where('Product_Code', '=', $stock->Product_Code)->delete();
                    $stock->Ordered_Qty = $stock->Ordered_Qty + $produc_qty;
                    $stock->QtyForNewOrder = $stock->QtyForNewOrder - $produc_qty;
                    $stock->Hold_Qty = $stock->Hold_Qty - $produc_qty;
                    $stock->save();
                }
            }
            $order->save();
            $reward_point = \App\RewardPoint::create([
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'Order_No' => $order->Order_No,
                'Order_Code' => $order->Order_Code,
                'Order_Date' => $order->Order_Date,
                'Tax_Amount' => $order->Taxable_Amount,
                'Reward_Point' => round($order->Taxable_Amount * 2 / 100),
            ]);
            $balance = \App\RewardReferenceLedger::where('user_id', \Auth::user()->id)->orderBy('id', 'DESC')->first();
            $reward_reference_ledger_debit1 = null;
            if ($payment->Wallet_Amount) {
                $reward_reference_ledger_debit1 = \App\RewardReferenceLedger::create([
                    'Reference' => $order->Order_No,
                    'Date_Time' => date('Y-m-d H:i:s'),
                    'Debit' => $payment->Wallet_Amount,
                    'Credit' => 0,
                    'user_id' => $user->id,
                ]);
                $reward_reference_ledger_debit1->Balance = $balance->Balance - $payment->Wallet_Amount;
                $reward_reference_ledger_debit1->save();
            }

            $reward_reference_ledger_debit2 = \App\RewardReferenceLedger::create([
                'Reference' => $order->Order_No,
                'Date_Time' => date('Y-m-d H:i:s'),
                'Debit' => 0,
                'Credit' => round($order->Taxable_Amount * 2 / 100),
                'user_id' => $user->id,
            ]);
            if ($reward_reference_ledger_debit1) {
                $reward_reference_ledger_debit2->Balance = $reward_reference_ledger_debit1->Balance + round($order->Taxable_Amount * 2 / 100);
            } else {
                $reward_reference_ledger_debit2->Balance = $balance->Balance + round($order->Taxable_Amount * 2 / 100);
            }
            $reward_reference_ledger_debit2->save();

            $reard_transaction = \App\RewardTransaction::create([
                'Transaction_Date' => date('Y-m-d H:i:s'),
                'RewardPointOf_Code' => 1,
                'Reference_Code' => $reward_reference_ledger_debit2->id,
                'RewardTransactionType_Code' => 2,
                'Points' => round($order->Taxable_Amount * 2 / 100),
                'user_id' => $user->id,
            ]);


            // $OrderDetails = \App\Order::with('orderproducts')->where('id', $order->id)->first();

            // $data['OrderDetails'] = json_encode($OrderDetails);
            // $data['API_KEY'] = 'fdAu52PaUI1';
            // $post_data = json_encode($data, JSON_UNESCAPED_SLASHES);
            // $url = "http://nestorpharmaceuticals.com/API/NestorOnline.asmx/OrderAdd";
            // $ch = curl_init($url);
            // curl_setopt($ch, CURLOPT_POST, 1);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
            // $server_output = curl_exec($ch);
            // if ($server_output) {
            //     $order->Order_Code = json_decode(substr($server_output, 0, 92), true)['Reference_Code'];
            // }
            // $order->save();
            // curl_close($ch);

     $mobile = \Auth::user()->mobile;
        $key = "fdAu5P2aUI1";
        $sender = "NESTOR";
        $service = "TEMPLATE_BASED";
        $message = "Thank you for trusting Nestor online. Your order No. ".$order->Order_No." has been placed. Estimated delivery date ".date('d-m-Y', strtotime($order->created_at->format('d-m-Y'). ' + 2 days')).". Track order @https://play.google.com/store/apps/details?id=com.nestorpharma.b2b_app";
        $message = urlencode($message);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://smsapi.24x7sms.com/api_2.0/SendSMS.aspx?APIKEY=" . $key . "&MobileNo=" . $mobile . "&SenderID=NESTOR&Message=" . $message . "&ServiceName=" . $service);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        $return_val = curl_close($ch);
        if ($output == "") {
            echo "Process Failed, Please check domain, username and password.";
        } else {
            echo "$output";
        }

// $chemist = \App\Chemist::find($order->Party_ID);

//             $subject = "***Order Placed ***";

//             $message = "<b>Hello " . $order->Party_Name . "
            // We're glad that you chose us as your health companion!
            // </b>

// <p>A specialist from our team of doctors will also reach out to you soon for processing your order on your registered mobile number " . $chemist->Mobile_No . ".</p><br>
            // <p>Order ID: " . $order->Order_No . " is Placed</p>
            //          <table style='border: 2px solid black;'>
            //          <thead>
            //          <tr>
            //          <th class='text-center' colspan='4' style='background: yellow;border: 2px solid black;'>TRACK ORDER</th>
            //          </tr>
            //           <tr>
            //          <th class='text-center' style='background: yellow;border: 2px solid black;'>Product</th>
            //          <th class='text-center' style='background: yellow;border: 2px solid black;'>Qty</th>
            //          <th class='text-center' style='background: yellow;border: 2px solid black;'>Unit Price</th>
            //          <th class='text-center' style='background: yellow;border: 2px solid black;'>subtotal</th>
            //          </tr>
            //          </thead>
            //          <tbody>
            //          " . $order_product_arr . "
            //          <tr>
            //          <td colspan='3' style='border: 2px solid black;'>Taxable Amount</td><td style='background: yellow;border: 2px solid black;'>" . $order->Taxable_Amount . "</td>
            //           </tr>
            //           <tr>
            //          <td colspan='3' style='border: 2px solid black;'>Tax Amount</td><td style='background: yellow;border: 2px solid black;'>" . $order->Tax_Amount . "</td>
            //           </tr>
            //           <tr>
            //          <td colspan='3' style='border: 2px solid black;'>Grand Total</td><td style='background: yellow;border: 2px solid black;'>" . $order->Grand_Total . "</td>
            //           </tr>
            //          </tbody>
            //          </table></b>";
            //             $message .= "<h3>Thanks & Regards,<br> Nestor</h3>";

//             $header = "From:erp@nestorpharmaceuticals.com \r\n";
            //             $header .= "Cc:demotictechnologies@gmail.com \r\n";
            //             $header .= "MIME-Version: 1.0\r\n";
            //             $header .= "Content-type: text/html\r\n";

//             $retval = mail($to, $subject, $message, $header);

//             if ($retval == true) {
            //                 echo "Message sent successfully...";
            //             } else {
            //                 echo "Message could not be sent...";
            //             }

            return redirect()->route('frontend.print_view', $order->id);
        } else if ($transaction->isFailed()) {
            //Transaction Failed
        } else if ($transaction->isOpen()) {
            //Transaction Open/Processing
        }

        $transaction->getResponseMessage(); //Get Response Message If Available
        //get important parameters via public methods
        $transaction->getOrderId(); // Get order id

        $transaction->getTransactionId(); // Get transaction id
    }
}