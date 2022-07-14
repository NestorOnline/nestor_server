<?php

namespace App\Http\Controllers;

use App\Exports\OrderTackingsExport;
use App\Exports\PaymentsExport;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderProduct;
use App\Payment;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PaytmWallet;

require_once "../vendor/paytm/paytmchecksum/PaytmChecksum.php";
class OrderController extends Controller
{

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function place_your_order_checksum_App(Request $request)
    {
        /* initialize JSON String */

        //      $data['MID']=config('services.paytm-wallet.merchant_id');
        //     $data['INSTRY_TYPE_ID']=$request->INSTRY_TYPE_ID;
        //     $data['WEBSITE']=$request->WEBSITE;
        //      $data['CHANNEL_ID']=$request->CHANNEL_ID;
        //       $data['TXN_AMOUNT']=$request->TXN_AMOUNT;
        //       $data['ORDER_ID']=$request->ORDER_ID;
        //       $data['EMAIL']=$request->EMAIL;
        //      $data['MOBILE_NO']=$request->MOBILE_NO;
        //       $data['CUST_ID']=$request->CUST_ID;
        //       $data['CALLBACK_URL']=$request->CALLBACK_URL;
        //       $data['CHECKSUMHASH']=\PaytmChecksum::generateSignature(json_encode($data), config('services.paytm-wallet.merchant_key'));
        //     return response()->json(['status'=>true,'message'=>'Your Checksum Successfully Registered','data'=>$data], 200);
        $body = '{"mid":"' . config('services.paytm-wallet.merchant_id') . '","orderId":"' . $request->order_id . '"}';

/**
 * Generate checksum by parameters we have in body
 * Find your Merchant Key in your$paytmChecksum Paytm Dashboard at https://dashboard.paytm.com/next/apikeys
 */
        $paytmChecksum = \PaytmChecksum::generateSignature($body, config('services.paytm-wallet.merchant_key'));

        $isVerifySignature = \PaytmChecksum::verifySignature($body, config('services.paytm-wallet.merchant_key'), $paytmChecksum);
/**
if($isVerifySignature) {
echo "Checksum Matched";
} else {
echo "Checksum Mismatched";
}
 *
 */
        return response()->json(['status' => true, 'message' => 'Your Checksum Successfully Registered', 'is_vrification' => $isVerifySignature, 'data' => $paytmChecksum], 200);
        return response()->json(['status' => true, 'message' => 'Your Checksum Successfully Registered', 'data' => $paytmChecksum], 200);
    }

    public function order_settelement_report(Request $request)
    {
        return view('backend.orders.order_settelement_report');
    }
    public function payment_export_page(Request $request)
    {
        $data['payment_from'] = $request->payment_from;
        $data['payment_to'] = $request->payment_to;

        return view('backend.orders.payment_export_page', $data);
    }

    public function order_settelement_report_store(Request $request)
    {
        require_once "../vendor/paytm/paytmchecksum/PaytmChecksum.php";
        $paytmParams = array();
        $paytmParams["MID"] = "NESTOR42509796971890";
        $paytmParams["utrProcessedStartTime"] = $request->payment_date;
        $paytmParams["pageNum"] = "1";
        $paytmParams["pageSize"] = "20";
/*
 * Generate checksum by parameters we have
 * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys
 */
        $checksum = \PaytmChecksum::generateSignature($paytmParams, "yZt!E@hjd9AgJ5aM");

        $paytmParams["checksumHash"] = $checksum;

        $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

/* for Production */
        $url = "https://securegw.paytm.in/merchant-settlement-service/settlement/list";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $response = curl_exec($ch);
        $Order_settelement_arr = json_decode($response);

        foreach ($Order_settelement_arr->settlementListResponse->settlementTransactionList as $settlementTransaction) {

            $payment = \App\Payment::where('Order_Code', $settlementTransaction->ORDERID)->first();
            if ($payment) {
// $payment = \App\Payment::where('Order_Code', $settlementTransaction->ORDERID)->where('User_ID', $settlementTransaction->CUSTID)->get();
                $payment->COMMISSION = $settlementTransaction->COMMISSION;
                $payment->PAYOUT_DATE = $settlementTransaction->{'PAYOUT DATE'};
                $payment->SETTLED_DATE = $settlementTransaction->{'SETTLED DATE'};
                $payment->SETTLEDAMOUNT = $settlementTransaction->SETTLEDAMOUNT;
                $payment->UTR = $settlementTransaction->UTR;
                $payment->SETTLED_ORDERID = $settlementTransaction->ORDERID;
                $payment->GST = $settlementTransaction->GST;
                $payment->save();
            }
        }
        return redirect()->back()->with('success', 'UTR No. Update Successfully!');
    }

    public function index(Request $request)
    {
        $date = $request->date;
        $OrderFrom_Code = $request->OrderFrom_Code;
        if ($date) {
            $month = substr($date, 0, 7);
        } else {
            $month = date('Y-m');
        }
        if ($date && $OrderFrom_Code) {
            $orders = \App\Order::whereDate('created_at', $date)->where('OrderFrom_Code', '=', $OrderFrom_Code)->orderBy('id', 'DESC')->get();
        } elseif ($date) {
            $orders = \App\Order::whereDate('created_at', $date)->orderBy('id', 'DESC')->get();
        } else {
            $date = date('Y-m-d');
            $orders = \App\Order::whereDate('created_at', $date)->orderBy('id', 'DESC')->get();
        }

        return view('backend.orders.index', compact('orders', 'date', 'OrderFrom_Code', 'month'));
    }

    public function payment_report(Request $request)
    {
        $date = $request->date;
        if ($date) {
            $payments = \App\Payment::whereDate('created_at', $date)->get();
        } else {
            $date = date('Y-m-d');
            $payments = \App\Payment::whereDate('created_at', $date)->get();
        }
        return view('backend.orders.payment_report', compact('payments', 'date'));
    }

    public function order_report(Request $request)
    {
        $year = $request->year;
        $report_for = $request->report_for;
        if ($report_for == 'month_wise' && $year) {
            return view('backend.orders.order_report', compact('year', 'report_for'));
        } elseif ($report_for == 'state_wise' && $year) {
            $states = \App\State::where('country_code', '=', 1)->get();
            return view('backend.orders.order_report_state_wise', compact('states', 'year', 'report_for'));
        } else {
            $year = date('Y');
            $report_for = "month_wise";
        }
        return view('backend.orders.order_report', compact('year', 'report_for'));
    }

    public function order_report_tracking($order_id)
    {
        $date['order'] = \App\Order::find($order_id);
        return view('backend.orders.order_report_tracking', compact('year', 'report_for'));
    }

    public function chemist_list_more_than_one_order()
    {
        $data['orders'] = \App\Order::select('user_id', \DB::raw('COUNT(user_id) as payment_made'))
        ->groupBy('user_id')->havingRaw('COUNT(user_id) > ?', [1])->get();
        return view('backend.orders.chemist_list_more_than_one_order', $data);
    }

    public function chemist_order_list(Request $request,$user_id)
    {
        $data['orders'] = \App\Order::where('user_id',$user_id)->get();
        return view('backend.orders.chemist_order_list', $data);
    }
    

    public function order_tracking_export(Request $request)
    {
        return Excel::download(new OrderTackingsExport, 'orderSummeryExport.xlsx');
        return redirect()->back();
    }

    public function order_report_date_wise(Request $request)
    {
        $first = $request->date . "-01";
        if ($request->date == date('Y-m')) {
            $last = date('Y-m-d');
        } else {
            $last = date("Y-m-t", strtotime($request->date . "-01"));
        }
        $thisTime = strtotime($first);
        $endTime = strtotime($last);
        return view('backend.orders.order_report_date_wise', compact('endTime', 'thisTime'));
    }

    public function print_view($id)
    {
        $order = \App\Order::find($id);
        $order_products = \App\OrderProduct::where('order_id', '=', $order->id)->get();
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        if(\Auth::user()->role=='User'){
            return view('frontend.users.print_view', compact('order', 'groups', 'order_products'));
        }else{
            return view('frontend.print_view', compact('order', 'groups', 'order_products'));
        }

    }

    public function search_order(Request $request)
    {
        $order = \App\Order::where('id', $request->order_id)
            ->OrWhere('Party_Name', $request->Party_Name)
            ->OrWhere('Party_Name', $request->Party_Name)
            ->get();
        $order_products = \App\OrderProduct::where('order_id', '=', $order->id)->get();
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        return view('frontend.print_view', compact('order', 'groups', 'order_products'));
    }

    public function show($id)
    {
        $order = \App\Order::with('orderproducts')->find($id);
        return view('backend.orders.show', compact('order'));
    }

    public function orders_with_empty_order_code()
    {
        $data['orders'] = \App\Order::whereNull('Order_Code')->where('id', '>', 850)->orderBy('id', 'DESC')->get();
        return view('backend.orders.orders_with_empty_order_code', $data);
    }
    public function order_json($id)
    {

        $OrderDetails = \App\Order::with('orderproducts')->where('id', $id)->first();

        $data['OrderDetails'] = json_encode($OrderDetails);
        $data['API_KEY'] = 'fdAu52PaUI1';
        $post_data = json_encode($data, JSON_UNESCAPED_SLASHES);
        $url = "http://nestorpharmaceuticals.com/API/NestorOnline.asmx/OrderAdd";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        $server_output = curl_exec($ch);
        dd($server_output);
        if ($server_output) {
            $OrderDetails->Order_Code = json_decode(substr($server_output, 0, 91), true)['Reference_Code'];
        }
        
        $OrderDetails->save();
        curl_close($ch);
       
    }

    public function pending_orders_for_payment(Request $request)
    {
        $data['date'] = $request->date;
        // if ($data['date']) {

        // } else {
        //     $data['date'] = date('Y-m-d');
        // }
        // $data['payments'] = \App\Payment::where('created_at', $data['date'])->get();
        $data['payments'] = \App\Payment::where('TransStatus', 'TXN_PENDING')->orderBy('id', 'DESC')->get();

        return view('backend.orders.pending_orders_for_payment', $data);
    }

    public function view_cart_items($user_id)
    {
        $data['user'] = \App\User::find($user_id);
        $data['chemist'] = \App\Chemist::where('user_id', $user_id)->first();
        $data['payments'] = \App\Payment::where('User_ID', $user_id)->where('TransStatus', 'TXN_PENDING')->orderBy('id', 'DESC')->get();
        $data['add_to_carts'] = \App\Addtocard::where('user_id', $user_id)->get();
        return view('backend.orders.view_cart_items', $data);
    }

    public function view_cart_items_paid_now($payment_id)
    {
        $payment = \App\Payment::find($payment_id);
        if ($payment) {
            $user = \App\User::find($payment->User_ID);

            $wallet = 0;
            if ($user) {
                if ($user->wallet > 500) {
                    $wallet = 500;
                } else {
                    $wallet = $user->wallet;
                }
                $user->wallet = $user->wallet - $wallet;
                $user->save();
            }

            $address = \App\Address::where('user_id', '=', $user->id)->where('set_as_a_current', '=', 'Yes')
                ->where('set_as_a_default', '=', 'Yes')
                ->first();
            if ($address) {
            } else {
                $address = \App\Address::where('user_id', '=', $user->id)->where('set_as_a_current', '=', 'Yes')
                    ->where('set_as_a_default', '=', 'Yes')
                    ->first();
            }

            $order = \App\Order::create([
                'user_id' => $user->id,
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
            $payment->TransStatus = 'TXN_SUCCESS';
            $payment->save();
            $product_carts = \App\Addtocard::where('user_id', '=', $user->id)->get();
            $card_subtotal = 0;
            $grand_total = 0;
            $gst_amount = 0;

            foreach ($product_carts as $product_cart) {
                $subtotal = 0;
                $amount = 0;
                $discount = 0;
                $subtotal = $product_cart->amount * $product_cart->Qty;
                $card_subtotal = $card_subtotal + $product_cart->amount * $product_cart->Qty;
                $product_detail = \App\Product::find($product_cart->product_id);

                if ($product_detail) {
                    if ($user->role == 'Chemist') {
                        $product_price = \App\Productprice::where('Product_Code', '=', $product_detail->product_code)
                            ->where('ProductPriceType_Code', '=', 7)
                            ->first();
                        $mrp_product_price = \App\Productprice::where('Product_Code', '=', $product_detail->product_code)->where('ProductPriceType_Code', '=', '8')->first();

                    } else {
                        $mrp_product_price = \App\Productprice::where('Product_Code', '=', $product_detail->product_code)->where('ProductPriceType_Code', '=', '8')->first();
                        $product_price = \App\Productprice::where('Product_Code', '=', $product_detail->product_code)
                            ->where('ProductPriceType_Code', '=', 9)
                            ->first();
                    }
                }
                $amount = $subtotal - $discount;
                $p_tax = $amount * $product_price->GST / 100;
                $p_total = $amount + $p_tax;
                $order_product = \App\OrderProduct::create([
                    'Order_Id' => $order->id,
                    'product_id' => $product_detail->id,
                    'Product_Code' => $product_detail->product_code,
                    'Order_Qty' => $product_cart->Qty,
                    'Rate' => $product_cart->amount,
                    'Amount' => $amount,
                    'Taxable' => $subtotal,
                    'TaxRate' => $product_price->GST,
                    'Tax' => $p_tax,
                    'Total' => $p_total,
                    'Discount' => $product_detail->offer,
                ]);
                $sales_scheme = \App\SalesScheme::where('Product_Code', '=', $order_product->Product_Code)->first();
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

            }
            foreach ($product_carts as $product_cart) {
                if ($product_cart->count()) {
                    $product_cart->delete();
                }
            }
            if ($user->role == 'Chemist') {
                $chemist = \App\Chemist::where('user_id', '=', $user->id)->first();
                $order->Party_Name = $chemist->Party_Name;
                $order->Party_ID = $chemist->id;
                $order->Party_Code = $chemist->Party_Code;
                $order->GSTIN = $chemist->GSTIN;
                $order->DL_No = $chemist->DL_No;
                $order->Contact_Person = $chemist->Contact_Person;

            } else {
                $order->GSTIN = 'null';
            }
            if ($user->role == 'Chemist') {
                $Delivery_Amount = 0;
            } else {
                $Delivery_Amount = 50;
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
            $order->Grand_Total = $grand_total;

            $order->Order_No = 'NSRID-' . $order->id;
            $order->Order_Date = date('Y-m-d H:i:s');
            $order->Product_Amount = $card_subtotal;
            $order->Payment_Amount = $grand_total_invoice;
            $order->Payment_Status = 'TXN_SUCCESS';
            $order->OrderStatus_Code = 5;
            $order->OrderFrom_Code = 2;
            $order->is_update = 0;
            $order->Testing_Order = 1;

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
                    $stock_hold = \App\StockHold::where('User_Id', '=', $user->id)->where('Office_Code', '=', $stock->Office_Code)->where('Product_Code', '=', $stock->Product_Code)->delete();
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
            $balance = \App\RewardReferenceLedger::where('user_id', $user->id)->orderBy('id', 'DESC')->first();
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

            $OrderDetails = \App\Order::with('orderproducts')->where('id', $order->id)->first();

            $data['OrderDetails'] = json_encode($OrderDetails);
            $data['API_KEY'] = 'fdAu52PaUI1';
            $post_data = json_encode($data, JSON_UNESCAPED_SLASHES);
            $url = "http://nestorpharmaceuticals.com/API/NestorOnline.asmx/OrderAdd";
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
            $server_output = curl_exec($ch);
            if ($server_output) {
                $order->Order_Code = json_decode(substr($server_output, 0, 92), true)['Reference_Code'];
            }
            $order->save();
            curl_close($ch);

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

            return redirect()->route('backend.orders.pending_orders_for_payment');
        }
        return redirect()->route('backend.orders.pending_orders_for_payment');
    }

    public function order_cancel($id)
    {
        require_once "../vendor/paytm/paytmchecksum/PaytmChecksum.php";
        $groups = \App\Group::with('groupcategories')->orderBy('id', 'DESC')->get();
        $order = \App\Order::find($id);
        $order->CancelOn = date('Y-m-d H:i:s');
        $order->OrderStatus_Code = 7;
        $payment = \App\Payment::where('Order_ID', '=', $order->id)->first();
        $balance = \App\RewardReferenceLedger::where('user_id', \Auth::user()->id)->orderBy('id', 'DESC')->first();
        $reward_reference_ledger_debit = null;
        if($payment->Wallet_Amount){
            $reward_reference_ledger_debit = \App\RewardReferenceLedger::create([
                'Reference' => "Cancelled Order (".$order->Order_No.")",
                'Date_Time' => date('Y-m-d H:i:s'),
                'Debit' => 0,
                'Credit' => $payment->Wallet_Amount,
                'user_id' => \Auth::user()->id,
            ]);
            $reward_reference_ledger_debit->Balance = $balance->Balance + $payment->Wallet_Amount;
            $reward_reference_ledger_debit->save();
        }

       
            $reward_reference_ledger_debit1 = \App\RewardReferenceLedger::create([
                'Reference' => "Cancelled Order (".$order->Order_No.")",
                'Date_Time' => date('Y-m-d H:i:s'),
                'Debit' => round($order->Taxable_Amount * 2 / 100),
                'Credit' => 0,
                'user_id' => \Auth::user()->id,
            ]);
            if ($reward_reference_ledger_debit) {
                $reward_reference_ledger_debit1->Balance = $reward_reference_ledger_debit->Balance - round($order->Taxable_Amount * 2 / 100);
                $reward_reference_ledger_debit1->save();
            }else{
                $reward_reference_ledger_debit1->Balance = $balance->Balance - round($order->Taxable_Amount * 2 / 100);
                $reward_reference_ledger_debit1->save();
            }

  




        $paytmParams = array();

        $paytmParams["body"] = array(
            "mid" => "NESTOR42509796971890",
            "txnType" => "REFUND",
            "orderId" => $payment->Order_Code,
            "txnId" => $payment->ResponseTransID,
            "refId" => "REFDID_" . rand(10000, 99999),
            "refundAmount" => $payment->Requested_Amount,
        );

/*
 * Generate checksum by parameters we have in body
 * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys
 */
        $checksum = \PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), "yZt!E@hjd9AgJ5aM");

        $paytmParams["head"] = array(
            "signature" => $checksum,
        );

        $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

/* for Staging */
        $url = "https://securegw.paytm.in/refund/apply";

/* for Production */
// $url = "https://securegw.paytm.in/refund/apply";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        $response = curl_exec($ch);
        $order->save();

//         $chemist = \App\Chemist::find($order->Party_ID);

//         $to = $chemist->Email_ID;
        //          $subject = "***Order Cencel: NSRID-".$order->id." ***";

//          $message = "<b>Hello ".$order->Party_Name."
        // </b>

// <p>We regret to inform you that our licensed pharmacy partner is unable to process part of your order as the item(s) you requested for is/are currently out of stock. For now we have cancelled part of your order.

// Although we always try our best to fulfil all orders on time, there are rare occasions where we experience such unavailability.

// We apologize for the inconvenience caused.

// Part Order Cancelled

// Out of stock.</p>";
        //          $message .= "<h3>Thanks & Regards,<br> Nestor</h3>";

//          $header = "From:erp@nestorpharmaceuticals.com \r\n";
        //          $header .= "Cc:demotictechnologies@gmail.com \r\n";
        //          $header .= "MIME-Version: 1.0\r\n";
        //          $header .= "Content-type: text/html\r\n";

//          $retval = mail ($to,$subject,$message,$header);

//          if( $retval == true ) {
        //             echo "Message sent successfully...";
        //          }else {
        //             echo "Message could not be sent...";
        //          }
        return redirect()->route('dashboard.order_history', \Auth::user()->id);
    }

    public function checksum_match_App(Request $request)
    {
        $paytmParams = $request->checksum;
        $isVerifySignature = PaytmChecksum::verifySignature($paytmParams, config('services.paytm-wallet.merchant_id'), $paytmChecksum);
        if ($isVerifySignature) {
            echo "Checksum Matched";
        } else {
            echo "Checksum Mismatched";
        }
    }

    public function place_your_order_App(Request $request)
    {
        $user = \App\User::where('role', '=', 'Chemist')->where('mobile', '=', $request->mobile)->where('status', '=', 'verify')->first();
        if ($user) {
            $product_carts = \App\Addtocard::where('user_id', '=', $user->id)->get();
            if (count($product_carts)) {

                $site_route = $request->getSchemeAndHttpHost();
                $chemist = \App\Chemist::where('user_id', '=', $user->id)->first();
                $payment = \PaytmWallet::with('receive');

                $card_subtotal = 0;
                $wallet = 0;
                $grand_total = 0;
                if ($user) {
                    if ($user->wallet > 0) {
                        $wallet = $request->Wallet_Amount;
                    } else {
                        $wallet = 0;
                    }
                }
                $address = \App\Address::where('user_id', '=', $user->id)->where('set_as_a_current', '=', 'Yes')
                    ->where('set_as_a_default', '=', 'Yes')
                    ->first();
                if ($address) {
                    $pincode = \App\Pincode::where('pincode', '=', $address->PIN)->first();
                    $office_state = \App\OfficeState::where('State_Code', '=', $pincode->state_id)->first();
                }
                $stock_arr = [];
                foreach ($product_carts as $product_cart) {
                    $subtotal = 0;
                    $amount = 0;
                    $discount = 0;
                    $subtotal = $product_cart->amount * $product_cart->Qty;
                    $card_subtotal = $card_subtotal + $product_cart->amount * $product_cart->Qty;
                    $product_detail = \App\Product::find($product_cart->product_id);
                    $sales_scheme = \App\SalesScheme::where('Product_Code', '=', $product_cart->Product_Code)->first();
                    $produc_qty = 0;
                    if ($sales_scheme) {
                        $dividend = $product_cart->Qty;
                        $divisor = $sales_scheme->NextMinSaleQty_ForScheme;
                        $output = intdiv($dividend, $divisor);
                        $produc_qty = $product_cart->Qty + $output * $sales_scheme->Free_Qty;
                    } else {
                        $produc_qty = $product_cart->Qty;
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
                                return response()->json(['status' => false, 'message' => 'Stock Of ' . $product_detail->brand_name . ' Are Not Available For This Location'], 200);
                            }
                        } else {
                            return response()->json(['status' => false, 'message' => 'Stock Of ' . $product_detail->brand_name . ' Are Not Available For This Location'], 200);
                        }
                    } else {
                        return response()->json(['status' => false, 'message' => 'Stock Are Not Available For This Location'], 200);
                    }
                    $p_tax = 0;
                    if ($product_detail) {
                        if ($user->role == 'chemist') {
                            $product_price = \App\Productprice::where('Product_Code', '=', $product_detail->product_code)
                                ->where('ProductPriceType_Code', '=', 7)
                                ->first();
                            if ($product_price) {
                                $p_tax = $amount * $product_price->GST / 100;
                            }

                        } else {
                            $product_price = \App\Productprice::where('Product_Code', '=', $product_detail->product_code)
                                ->where('ProductPriceType_Code', '=', 9)
                                ->first();
                            if ($product_price) {
                                $p_tax = $amount * $product_price->GST / 100;
                            }
                        }
                    }
                    $amount = $subtotal - $discount;
                    $gst_amount = 0;
                    $p_total = $amount + $p_tax;
                    if ($user->role == 'Chemist') {
                        $chemist = \App\Chemist::where('user_id', '=', $user->id)->first();
                        if ($product_price) {
                            $gst_amount = $card_subtotal * $product_price->GST / 100;
                        }
                    } else {
                        $order->GSTIN = 'null';
                        if ($product_price) {
                            $gst_amount = $card_subtotal * $product_price->GST / 100;
                        }
                    }
                    $Delivery_Amount = 0;
                    $grand_total = $card_subtotal + $Delivery_Amount + $gst_amount;
                    $grand_total_invoice = $card_subtotal - $wallet + $Delivery_Amount + $gst_amount;
                }
                foreach ($stock_arr as $stock_ar) {
                    $stock1 = \App\Stock::where('Office_Code', '=', $stock_ar['Office_Code'])->where('Product_Code', '=', $stock_ar['Product_Code'])->first();
                    $stock1->Hold_Qty = $stock1->Hold_Qty + $stock_ar['Hold_Qty'];
                    $stock1->save();
                }

                $payment_request = \App\Payment::create([
                    'Order_Code' => "",
                    'ResponseTransID' => '',
                    'Requested_Amount' => number_format($request->payment_amount, 2, '.', ''),
                    'PaymentMode' => '',
                    'TransactionTime' => date('Y-m-d H:m:s'),
                    'TransStatus' => 'TXN_PENDING',
                    'Response_Code' => '02',
                    'RESPMSG' => '',
                    'GatewayName' => '',
                    'BankTransID' => '',
                    'BankName' => '',
                    'User_ID' => $user->id,
                    'Wallet_Amount' => $request->Wallet_Amount,
                ]);

                require_once "../vendor/paytm/paytmchecksum/PaytmChecksum.php";

                $paytmParams = array();

                $paytmParams["body"] = array(
                    "requestType" => "Payment",
                    "mid" => "NESTOR42509796971890",
                    "websiteName" => "DEFAULT",
                    "orderId" => "NMLID-" . $payment_request->id,
                    "callbackUrl" => "https://securegw.paytm.in/theia/paytmCallback?ORDER_ID=NMLID-" . $payment_request->id,
                    "txnAmount" => array(
                        "value" => number_format($request->payment_amount, 2, '.', ''),
                        "currency" => "INR",
                    ),
                    "userInfo" => array(
                        "custId" => $user->id,
                    ),
                );

/*
 * Generate checksum by parameters we have in body
 * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys
 */
                $checksum = \PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), "yZt!E@hjd9AgJ5aM");

                $paytmParams["head"] = array(
                    "signature" => $checksum,
                );

                $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

/* for Staging */
                // $url = "https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid=yEcytO49536340286191&orderId=NMLID-" . $payment_request->id;

/* for Production */
                $url = "https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid=NESTOR42509796971890&orderId=NMLID-" . $payment_request->id;

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
                $response = curl_exec($ch);
                $data['response'] = $response;
                $data['ORDER_ID'] = 'NMLID-' . $payment_request->id;
                $data['callbackUrl'] = "https://securegw.paytm.in/theia/paytmCallback?ORDER_ID=NMLID-" . $payment_request->id;
                return response()->json(['status' => true, 'message' => 'you order is initiated, we are waiting for payment submission', 'data' => $data], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Error Your Card is Empty, Please Add Alteast One Item'], 200);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Error Data Does Not Match. Please Try Again'], 200);
        }
    }

    public function responce_from_paytm_App(Request $request)
    {
        //   require_once("../vendor/paytm/paytmchecksum/PaytmChecksum.php");
        //      $transaction = PaytmWallet::with('receive');
        //     $response = $transaction->response();
        $response = $request->all();
        // To get raw response as array
        //Check out response parameters sent by paytm here -> http://paywithpaytm.com/developer/paytm_api_doc?target=interpreting-response-sent-by-paytm

        $payment_id = explode('-', $response['ORDERID']);
        $payment = \App\Payment::find($payment_id[1]);
        $user = \App\User::find($payment->User_ID);
        Auth::login($user);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['token_type'] = 'Bearer';
        $chemist = \App\Chemist::where('user_id', '=', $user->id)->first();
        if ($chemist) {
            $site_route = $request->getSchemeAndHttpHost();
            $success['chemist_name'] = $chemist->Party_Name;
            $success['Party_Code'] = $chemist->Party_Code;
            $success['ShopPhoto'] = $site_route . "/" . $chemist->ShopPhoto;
            $success['contact_person'] = $chemist->Mobile_No;
        }
        $success['role'] = $user->role;
        $success['mobile'] = $user->mobile;
        $success['status'] = 'verify';
        $success['password'] = $user->password;
        $success['role'] = $user->role;
        $success['wallet'] = $user->wallet;

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
            if (\Auth::user()->wallet > 0) {
                $wallet = $payment->Wallet_Amount;
            } else {
                $wallet = 0;
            }
            $user->wallet = $user->wallet - $payment->Wallet_Amount;
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
            $subtotal = $product_cart->amount * $product_cart->Qty;
            $card_subtotal = $card_subtotal + $product_cart->amount * $product_cart->Qty;
            $product_detail = \App\Product::find($product_cart->product_id);

            if ($product_detail) {
                if (\Auth::user()->role == 'Chemist') {
                    $product_price = \App\Productprice::where('Product_Code', '=', $product_detail->product_code)
                        ->where('ProductPriceType_Code', '=', 7)
                        ->first();
                    $mrp_product_price = \App\Productprice::where('Product_Code', '=', $product_detail->product_code)->where('ProductPriceType_Code', '=', '8')->first();

                } else {
                    $mrp_product_price = \App\Productprice::where('Product_Code', '=', $product_detail->product_code)->where('ProductPriceType_Code', '=', '8')->first();
                    $product_price = \App\Productprice::where('Product_Code', '=', $product_detail->product_code)
                        ->where('ProductPriceType_Code', '=', 9)
                        ->first();
                }
            }
            $amount = $subtotal - $discount;
            $p_tax = $amount * $product_price->GST / 100;
            $p_total = $amount + $p_tax;
            $order_product = \App\OrderProduct::create([
                'Order_Id' => $order->id,
                'product_id' => $product_detail->id,
                'Product_Code' => $product_detail->product_code,
                'Order_Qty' => $product_cart->Qty,
                'Rate' => $product_cart->amount,
                'Amount' => $amount,
                'Taxable' => $subtotal,
                'TaxRate' => $product_price->GST,
                'Tax' => $p_tax,
                'Total' => $p_total,
                'Discount' => $product_detail->offer,
            ]);
            $sales_scheme = \App\SalesScheme::where('Product_Code', '=', $order_product->Product_Code)->first();
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
        }
        foreach ($product_carts as $product_cart) {
            if ($product_cart->count()) {
                $product_cart->delete();
            }
        }
        if (\Auth::user()->role == 'Chemist') {
            $chemist = \App\Chemist::where('user_id', '=', \Auth::user()->id)->first();
            $order->Party_ID = $chemist->id;
            $order->Party_Code = $chemist->Party_Code;
            $order->Party_Name = $chemist->Party_Name;
            $order->GSTIN = $chemist->GSTIN;
            $order->DL_No = $chemist->DL_No;
            $order->Contact_Person = $chemist->Contact_Person;
        } else {
            $order->GSTIN = 'null';
        }
        $Delivery_Amount = 0;
        $grand_total = $card_subtotal + $Delivery_Amount + $gst_amount;
        $grand_total_invoice = $card_subtotal - $wallet + $Delivery_Amount + $gst_amount;
        $pincode = \App\Pincode::where('pincode', '=', $order->PIN)->first();
        $office_state = \App\OfficeState::where('State_Code', '=', $pincode->state_id)->first();
        $order->Delivery_Amount = $Delivery_Amount;
        $order->Taxable_Amount = $card_subtotal;
        $order->Tax_Amount = $gst_amount;
        $order->WalletAmount = $wallet;
        $order->Discount_Amount = 0;
        $order->Grand_Total = $grand_total;

        $order->Order_No = 'NSRID-' . $order->id;
        $order->Order_Date = date('Y-m-d H:i:s');
        $order->Product_Amount = $card_subtotal;
        $order->Payment_Amount = $grand_total_invoice;
        $order->Payment_Status = $response['STATUS'];
        $order->OrderStatus_Code = 5;
        $order->OrderFrom_Code = 1;
        $order->is_update = 0;
        $order->Testing_Order = 1;
        if ($office_state) {
            $order->Office_Code = $office_state->Office_Code;
        } else {
            $order->Office_Code = 31;
        }
        $order->save();
        $OrderDetails = \App\Order::with('orderproducts')->where('id', $order->id)->first();

        $data['OrderDetails'] = json_encode($OrderDetails);
        $data['API_KEY'] = 'fdAu52PaUI1';
        $post_data = json_encode($data, JSON_UNESCAPED_SLASHES);
        $url = "http://nestorpharmaceuticals.com/API/NestorOnline.asmx/OrderAdd";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        $server_output = curl_exec($ch);
        if ($server_output) {
            $order->Order_Code = json_decode(substr($server_output, 0, 92), true)['Reference_Code'];
            $order->save();
        }
        curl_close($ch);

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
            $stock = \App\Stock::where('Office_Code', '=', $office_state->Office_Code)->where('Product_Code', '=', $order_product->Product_Code)->first();
            if ($stock) {
                $stock_hold = \App\StockHold::where('User_Id', '=', \Auth::user()->id)->where('Office_Code', '=', $stock->Office_Code)->where('Product_Code', '=', $stock->Product_Code)->delete();
                $stock->Ordered_Qty = $stock->Ordered_Qty + $order_product->Order_Qty + $order_product->Free_Qty;
                $stock->QtyForNewOrder = $stock->QtyForNewOrder - $order_product->Order_Qty - $order_product->Free_Qty;
                $stock->Hold_Qty = $stock->Hold_Qty - $order_product->Order_Qty - $order_product->Free_Qty;
                $stock->save();
            }
        }

        $data = [];
        $data['order'] = $order;
        $data['user'] = $success;
        $data['response'] = $response;
        return response()->json(['status' => true, 'message' => 'You Order is Placed', 'data' => $data], 200);
    }

    public function order_return(Request $request, $id)
    {

/*
 * import checksum generation utility
 * You can get this utility from https://developer.paytm.com/docs/checksum/
 */
        $order = \App\Order::find($id);
        if ($order) {
            $payment = \App\Payment::where('Order_ID', '=', $order->id)->get();
        }
        require_once "../vendor/paytm/paytmchecksum/PaytmChecksum.php";

        $paytmParams = array();

        $paytmParams["body"] = array(
            "mid" => "YtBoHw17737500171583",
            "txnType" => "REFUND",
            "orderId" => "NSRID-" . $order->id,
            "txnId" => $payment->TXNID,
            "refId" => "REFUNDID_98765",
            "refundAmount" => "1.00",
        );

/*
 * Generate checksum by parameters we have in body
 * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys
 */
        $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), "YOUR_MERCHANT_KEY");

        $paytmParams["head"] = array(
            "signature" => $checksum,
        );

        $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

/* for Staging */
        $url = "https://securegw-stage.paytm.in/refund/apply";

/* for Production */
// $url = "https://securegw.paytm.in/refund/apply";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        $response = curl_exec($ch);
        print_r($response);

    }

    public function payment_export()
    {
        return Excel::download(new PaymentsExport, 'PaymentsExport.xlsx');
        return redirect()->back();
    }

}