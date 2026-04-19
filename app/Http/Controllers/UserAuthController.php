<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    //
 public function showLogin(){
   return response()->view('cms.auth.login');
 }



 public function login(Request $request){
    $validator = Validator($request->all(), [
            'email'    => "required|email",
            'password' => 'required|string|min:3',
        ], [
            'email.required' => 'الرجاء إدخال البريد الإلكتروني',
            'password.required' => 'كلمة المرور مطلوبة',
        ]);

        if (!$validator->fails()) {
            $credentials = $request->only('email', 'password');

            // قائمة الجاردات التي سيمر عليها النظام للبحث عن المستخدم
            $guards = ['admin', 'team', 'artisan', 'customer'];

            foreach ($guards as $guard) {
                // محاولة تسجيل الدخول بكل جارد على حدة
                if (Auth::guard($guard)->attempt($credentials)) {
                    $request->session()->regenerate();

                    // عند النجاح، نرسل رابط التوجيه (URL) بناءً على الجارد الذي نجح
                    return response()->json([
                        'icon' => 'success',
                        'title' => 'Logged in successfully',
                        'url' => url("cms/" . ucfirst($guard) . "/home") // مثال: cms/Admin/home
                    ], 200);
                }
            }

            // إذا انتهى البحث في كل الجداول ولم نجد المستخدم
            return response()->json([
                'icon' => 'error',
                'title' => 'خطأ في البريد الإلكتروني أو كلمة المرور'
            ], 400);

        } else {
            return response()->json([
                'icon' => 'error',
                'title' => $validator->getMessageBag()->first()
            ], 400);
        }
 }



 public function logout(Request $request){

$guards = ['admin', 'team', 'customer', 'artisan'];
        $activeGuard = 'admin';

        foreach ($guards as $guard) {
            if (auth($guard)->check()) {
                $activeGuard = $guard;
                break;
            }
    }

    // 2. تسجيل الخروج من الجارد المحدد
  Auth::guard($activeGuard)->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // التوجه لصفحة اللوجن الموحدة بعد الخروج
        return redirect()->route('view.login');
    }
 public function changePassword(){}
 public function resetPassword(Request $request){}
 public function editProfile(){}
 public function updatePassword(Request $request , $id){}

}

