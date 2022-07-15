<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Detail_set_pitchs;
use App\Models\Bill;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; 
class PayController extends BaseUserController
{
    public function __construct()
    {
        parent::__construct();
    }
   public function vnpay_payment(Request $request){
    $setPitch = Detail_set_pitchs::where('id', $request->id)->first();
    $timeStart=$setPitch->start_time;
    $timeEnd=$setPitch->end_time;
  
    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    $vnp_Returnurl = "http://localhost:8000/return-vnpay";
    $vnp_TmnCode = "A05TVYHX";//Mã website tại VNPAY 
    $vnp_HashSecret = "EWPSYFBFTHFCVOILPZNLGMAEKPTGTPTO"; //Chuỗi bí mật
    
    $vnp_TxnRef =strtoupper(Str::random(8)).''.$setPitch->id; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
    $vnp_OrderInfo = "Thanh toán tiền sân $timeStart đến $timeEnd";
    $vnp_OrderType = 'billpayment';
    $vnp_Amount =  $setPitch->total * 100;
    $vnp_Locale = 'vn';
    $vnp_BankCode = 'NCB';
    $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
    //Add Params of 2.0.1 Version
    //$vnp_ExpireDate = $_POST['txtexpire'];
    //Billing

    $vnp_CreateDate=date('YmdHis');
    $vnp_Bill_FirstName = Auth::guard('user')->user()->username;
  
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
        "vnp_Bill_FirstName"=>$vnp_Bill_FirstName,
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
    $bill = Bill::where('detail_set_pitch_id', $setPitch->id)->first();
    if($bill==null){
        $bill=new Bill();
        $bill->detail_set_pitch_id=$setPitch->id;
        $bill->bill_number=$vnp_TxnRef;
        $bill->user_id=Auth::guard('user')->user()->id;
        $bill->price= $setPitch->total;
        $bill->bank=$vnp_BankCode;
        $bill->createdate=$vnp_CreateDate;
        $bill->transfer_content=$vnp_OrderInfo;
        $bill->status='0';
        $bill->save();
    }else{
        $bill->detail_set_pitch_id=$setPitch->id;
        $bill->bill_number=$vnp_TxnRef;
        $bill->user_id=Auth::guard('user')->user()->id;
        $bill->price= $setPitch->total;
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
                   $setPitch=Detail_set_pitchs::where('id',$bill->detail_set_pitch_id)->first();
                   $setPitch->ispay='1';
                   $setPitch->save();
                return redirect()->route('list.set.pitch')->with('success',"Thanh toán thành công");
            } 
            else {
                return redirect()->route('list.set.pitch')->with('error',"Giao dịch thất bại");
                }
        } else {
            return redirect()->route('list.set.pitch')->with('error',"Chữ kí không hợp lệ");
            }
		
}
}
