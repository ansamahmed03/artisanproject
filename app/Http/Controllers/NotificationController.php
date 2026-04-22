<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
 public function index()
{
    $notifications = Notification::whereHas('notifiable')
        ->with('notifiable') // ضيف هاد السطر عشان السرعة
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('cms.notification.index', compact('notifications'));
}

    public function create()
    {
        $users = User::all();
        return response()->view('cms.notification.create', compact('users'));
    }
public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'title'           => 'required|string|max:45',
        'message'         => 'required|string|max:45',
        'notifiable_type' => 'required|in:customer,artisan,team',
        'notifiable_id'   => 'required|integer',
        'is_read'         => 'nullable|boolean',
    ]);

    if ($validator->fails()) {
        return response()->json(['icon' => 'error', 'title' => $validator->getMessageBag()->first()], 400);
    }

    $typeMap = [
        'customer' => \App\Models\Customer::class,
        'artisan'  => \App\Models\Artisan::class,
        'team'     => \App\Models\Team::class,
    ];

    $notification                  = new Notification();
    $notification->title           = $request->title;
    $notification->message         = $request->message;
    $notification->is_read         = $request->is_read ?? 0;
    $notification->notifiable_id   = $request->notifiable_id;
    $notification->notifiable_type = $typeMap[$request->notifiable_type];
    $isSaved = $notification->save();

    if ($isSaved) {
        return response()->json(['icon' => 'success', 'title' => 'Notification sent successfully'], 200);
    }
    return response()->json(['icon' => 'error', 'title' => 'Something went wrong'], 500);
}
    public function show($id)
    {
        $notification = Notification::with('user')->findOrFail($id);
        return response()->view('cms.notification.show', compact('notification'));
    }

    public function edit($id)
    {
        $notification = Notification::findOrFail($id);
        $users        = User::all();
        return response()->view('cms.notification.edit', compact('notification', 'users'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'   => 'required|string|max:45',
            'message' => 'required|string|max:45',
            'users_id'=> 'required|integer|exists:users,id',
            'is_read' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['icon' => 'error', 'title' => $validator->getMessageBag()->first()], 400);
        }

        $notification          = Notification::findOrFail($id);
        $notification->title   = $request->title;
        $notification->message = $request->message;
        $notification->users_id= $request->users_id;
        $notification->is_read = $request->has('is_read') ? 1 : 0;
        $notification->save();

        return response()->json(['icon' => 'success', 'title' => 'Updated Successfully', 'redirect' => route('notifications.index')], 200);
    }

    public function destroy($id)
    {
        Notification::destroy($id);
        return response()->json(['icon' => 'success', 'title' => 'Deleted Successfully'], 200);
    }

  public function trashed()
{

    $notifications = Notification::onlyTrashed()
        ->with(['notifiable' => function($query) {
            $query->withTrashed();
        }])
        ->orderBy('deleted_at', 'desc')
        ->paginate(10);

    return view('cms.notification.trashed', compact('notifications'));
}

    public function restore($id)
    {
        Notification::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Restored Successfully');
    }

    public function force($id)
    {
        Notification::onlyTrashed()->findOrFail($id)->forceDelete();
        return back()->with('success', 'Deleted Successfully');
    }

    public function forceAll()
    {
        Notification::onlyTrashed()->forceDelete();
        return back()->with('success', 'All Deleted Successfully');
    }
// لجلب المستلمين حسب النوع
public function recipients($type)
{
    $data = match($type) {
        'customer' => \App\Models\Customer::select('id', 'name')->get(),
        'artisan'  => \App\Models\Artisan::select('id', 'artisan_name as name')->get(),
        'team'     => \App\Models\Team::select('id', 'team_name as name')->get(),
        default    => collect()
    };

    return response()->json($data);
}



// في NotificationController::send()
public static function send($notifiable, $title, $message)
{
    // جيبي الاسم قبل الحفظ
    $name = $notifiable->name
         ?? $notifiable->artisan_name
         ?? $notifiable->team_name
         ?? 'Unknown';

    Notification::create([
        'title'           => $title,
        'message'         => $message,
        'is_read'         => 0,
        'notifiable_id'   => $notifiable->id,
        'notifiable_type' => get_class($notifiable),
        'recipient_name'  => $name,  // ← احفظي الاسم هان
    ]);
}

}
