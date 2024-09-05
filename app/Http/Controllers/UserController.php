<?php
namespace App\Http\Controllers;
use App\Helper\JWTToken;
use App\Helper\ResponseHelper;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function LoginPage()
    {
        return view('pages.login-page');
    }

    public function VerifyPage()
    {
        return view('pages.verify-page');
    }
    public function UserLogin(Request $request):JsonResponse
    {
        try{
            $UserEmail = $request->UserEmail;
            $OTP = rand(100000, 999999);
            $details = ['code'=>$OTP];
            Mail::to($UserEmail)->send(new OTPMail($details));
            User::updateOrCreate(['email'=>$UserEmail],['email'=>$UserEmail,'otp'=>$OTP]);
            return ResponseHelper::Out('succes', "A 6 Digit OTP has been sent to your email",200);
        }catch (exception $e){
//            return response()->json([
//                'status'=>'error',
//                'message'=>$e->getMessage()
//            ]);

            return ResponseHelper::Out('fail', $e,200);
        }
    }
    public function VerifyLogin(Request $request):JsonResponse
    {
        $UserEmail = $request->UserEmail;
        $OTP =$request->OTP;
        $verification = User::where('email', $UserEmail)->where('otp',$OTP)->first();

        if($verification){
            User::where('email', $UserEmail)->where('otp',$OTP)->update(['otp'=>0]);
            $token = JWTToken::CreateToken($UserEmail, $verification->id);
            return  ResponseHelper::Out('success',"Login successful",200)->cookie('token',$token,60*24*30);
        }
        else{
            return ResponseHelper::Out('fail', "Invalid OTP",401);
        }

    }
    function UserLogout(){
        return redirect('/')->cookie('token', '', -1);
    }
}
