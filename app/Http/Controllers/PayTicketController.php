<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tickets;
use App\Models\Detail_set_pitchs;
use App\Models\SetService;
use App\Models\Bill;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; 

class PayTicketController extends Controller
{
    public function vnpay_payment(Request $request){
        $ticket = Tickets::where('id', $request->id)->first();
        if($ticket->ispay==1){
            return redirect()->route('pay.ticket',['ticketid'=>$ticket->id])->with('error',"Vé đã có người mua");
        }
        $code_ticket=$ticket->code_ticket;
      
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost:8000/return-vnpay-ticket";
        $vnp_TmnCode = "A05TVYHX";//Mã website tại VNPAY 
        $vnp_HashSecret = "EWPSYFBFTHFCVOILPZNLGMAEKPTGTPTO"; //Chuỗi bí mật
        
        $vnp_TxnRef =strtoupper(Str::random(8)).''.$ticket->id; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = "Thanh toán vé mã là $code_ticket";
        $vnp_OrderType = 'billpayment';
        $vnp_Amount =  $ticket->price * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        //$vnp_ExpireDate = $_POST['txtexpire'];
        //Billing
        $vnp_CreateDate=date('YmdHis');
    
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" =>  $vnp_CreateDate,
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );
        
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }
        
        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $bill = Bill::where('ticket_id', $ticket->id)->first();
        if($bill==null){
            $bill=new Bill();
            $bill->ticket_id=$ticket->id;
            $bill->bill_number=$vnp_TxnRef;
            $bill->user_id=Auth::guard('user')->user()->id;
            $bill->price= $ticket->price;
            $bill->bank=$vnp_BankCode;
            $bill->createdate=$vnp_CreateDate;
            $bill->transfer_content=$vnp_OrderInfo;
            $bill->status='0';
            $bill->save();
        }else{
            $bill->ticket_id=$ticket->id;
            $bill->bill_number=$vnp_TxnRef;
            $bill->user_id=Auth::guard('user')->user()->id;
            $bill->price= $ticket->price;
            $bill->bank=$vnp_BankCode;
            $bill->createdate=$vnp_CreateDate;
            $bill->transfer_content=$vnp_OrderInfo;
            $bill->status='0';
            $bill->save();
        }
    
    
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
         
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                die();
                dd(42342);
            } else {
                echo json_encode($returnData);
            }
       }
       public function return(Request $request)
    {
        $vnp_HashSecret = "EWPSYFBFTHFCVOILPZNLGMAEKPTGTPTO";
        $vnp_SecureHash = $_GET['vnp_SecureHash'];
            $inputData = array();
            foreach ($_GET as $key => $value) {
                if (substr($key, 0, 4) == "vnp_") {
                    $inputData[$key] = $value;
                }
            }
            
            unset($inputData['vnp_SecureHash']);
            ksort($inputData);
            $i = 0;
            $hashData = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
            }
    
            $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
            if ($secureHash == $vnp_SecureHash) {
                if ($_GET['vnp_ResponseCode'] == '00') {
                       $bill=Bill::where('bill_number',$inputData['vnp_TxnRef'])->first();
                       $bill->transaction_id=$inputData['vnp_TransactionNo'];
                       $bill->trace_number=$inputData['vnp_BankTranNo'];
                       $bill->status='1';
                       $bill->save();
                       $ticket=Tickets::where('id',$bill->ticket_id)->first();
                       $ticket->ispay='1';
                       $ticket->user_id=$bill->user_id;
                       $ticket->save();
                       foreach(Detail_set_pitchs::where('ticket_id', $bill->ticket_id)->get() as $setPitch){
                       $setPitch->user_id=$bill->user_id;
                       $setPitch->ispay='1';
                       $setPitch->save();
                      }
                    return redirect()->route('list.buy.ticket')->with('success',"Thanh toán thành công");
                } 
                else {
                    return redirect()->route('list.buy.ticket')->with('error',"Giao dịch thất bại");
                    }
            } else {
                return redirect()->route('list.buy.ticket')->with('error',"Chữ kí không hợp lệ");
                }
            
    }
}
