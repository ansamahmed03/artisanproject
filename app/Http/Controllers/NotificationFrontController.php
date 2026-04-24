<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationFrontController extends Controller
{
    // الحصول على المستخدم الحالي وأنواعه
    private function getCurrentUser()
    {
        if (Auth::guard('customer')->check()) {
            return ['user' => Auth::guard('customer')->user(), 'guard' => 'customer'];
        }
        if (Auth::guard('artisan')->check()) {
            return ['user' => Auth::guard('artisan')->user(), 'guard' => 'artisan'];
        }
        if (Auth::guard('team')->check()) {
            return ['user' => Auth::guard('team')->user(), 'guard' => 'team'];
        }
        return null;
    }

    // عرض كل الإشعارات
    public function index()
    {
        $current = $this->getCurrentUser();
        if (!$current) return redirect()->route('front.login');

        $notifications = $current['user']->notifications()->latest()->get();
        return view('frontend.notifications.index', compact('notifications'));
    }

    // تعليم إشعار واحد كمقروء
    public function markRead($id)
    {
        $current = $this->getCurrentUser();
        if (!$current) return redirect()->route('front.login');

        $notif = $current['user']->notifications()->findOrFail($id);
        $notif->update(['is_read' => 1]);

        return back()->with('success', 'Notification marked as read.');
    }

    // تعليم كل الإشعارات كمقروءة
    public function markAllRead()
    {
        $current = $this->getCurrentUser();
        if (!$current) return redirect()->route('front.login');

        $current['user']->notifications()->where('is_read', 0)->update(['is_read' => 1]);

        return back()->with('success', 'All notifications marked as read.');
    }






    
}
