<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
public function index(Request $request, $guard)
    {
        // يمكنك الآن استخدام $guard داخل ملف الـ Blade إذا أردت
        // مثلاً لعرض: "أهلاً بك في لوحة تحكم الأدمن" أو "التيم"
        return view('cms.home', compact('guard'));
    }

}
