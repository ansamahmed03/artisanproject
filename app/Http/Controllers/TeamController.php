<?php

namespace App\Http\Controllers;
use App\Models\City;
use App\Models\Team;
// use Egulias\EmailValidator\Warning\TLD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($guard)
    {
        //

   $teams = Team::paginate(10);
    return response()->view('cms.team.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $cities = City::all();
        return response()->view('cms.team.create', compact('cities'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'team_name'           => 'required|string|min:3|max:50',
        'email'               => 'required|email|unique:teams,email', // تأكد أن اسم الجدول teams
        'password'            => 'required|string|min:6',
        'bio'                 => 'nullable|string',
        'hourly_rate'         => 'required|numeric|min:0',
        'city_id' => 'nullable|exists:cities,id',
        'status'              => 'required|in:active,busy,closed',
        'verification_status' => 'required|in:pending,verified,rejected',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'icon'  => 'error',
            'title' => $validator->getMessageBag()->first(),
        ], 400);
    }

    // 2. إنشاء كائن التيم وحفظ البيانات
    $team = new Team();
    $team->team_name           = $request->get('team_name');
    $team->email               = $request->get('email');
    $team->password            = Hash::make($request->get('password'));
    $team->bio                 = $request->get('bio');
    $team->hourly_rate         = $request->get('hourly_rate');
    $team->city_id = $request->get('city_id');
    $team->status              = $request->get('status');
    $team->verification_status = $request->get('verification_status');

    $isSaved = $team->save();

    if ($isSaved) {

        $team->user()->create([
            'name'     => $request->get('team_name'),
            'email'    => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);


        return response()->json([
            'icon'  => 'success',
            'title' => 'Created successfully',
        ], 201); // 201 تعني Created بنجاح
    } else {
        return response()->json([
            'icon'  => 'error',
            'title' => 'Failed to save team'
        ], 500);
    }
    }

    /**
     * Display the specified resource.
     */
    public function show($guard,$id)
    {
        //
   $team = Team::findOrFail($id);
    return response()->view('cms.team.show', compact('team'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $cities = City::all();
                $teams = Team::findOrFail($id);
        return response()->view('cms.team.edit' , compact('teams', 'cities'));


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. التحقق من البيانات (Validator)
    $validator = Validator::make($request->all(), [
        'team_name'           => 'required|string|min:3|max:50',
        'email'               => 'required|email|unique:teams,email,' . $id, // استثناء هذا الـ ID من فحص الفرادة
        'password'            => 'nullable|string|min:6',
        'bio'                 => 'nullable|string',
        'hourly_rate'         => 'required|numeric|min:0',
        'city_id'             => 'nullable|exists:cities,id',
        'status'              => 'required|in:active,busy,closed',
        'verification_status' => 'required|in:pending,verified,rejected',
    ]);

    if (!$validator->fails()) {

        // 2. البحث عن التيم
        $team = Team::findOrFail($id);
        $team->team_name           = $request->get('team_name');
        $team->email               = $request->get('email');
        $team->bio                 = $request->get('bio');
        $team->hourly_rate         = $request->get('hourly_rate');
        $team->city_id             = $request->get('city_id');
        $team->status              = $request->get('status');
        $team->verification_status = $request->get('verification_status');

        // تحديث كلمة المرور فقط إذا تم إرسالها
        if ($request->has('password') && !empty($request->get('password'))) {
            $team->password = Hash::make($request->get('password'));
        }

        $isUpdated = $team->save();

        if ($isUpdated) {
            // 3. تحديث بيانات جدول الـ User المرتبط (Morph relationship)
            if ($team->user) {
                $userData = [
                    'name'  => $request->get('team_name'),
                    'email' => $request->get('email'),
                ];

                // إذا تغيرت الباسورد، حدثها أيضاً في جدول اليوزرز
                if ($request->has('password') && !empty($request->get('password'))) {
                    $userData['password'] = Hash::make($request->get('password'));
                }

                $team->user->update($userData);
            }

            return response()->json([
                'icon'     => 'success',
                'title'    => 'Updated successfully',
               'redirect' => route('teams.index', ['guard' => 'Admin']) // تأكد من اسم الـ Route
            ], 200);
        } else {
            return response()->json([
                'icon'  => 'error',
                'title' => 'Update failed'
            ], 400);
        }

    } else {
        // في حال فشل الـ Validation
        return response()->json([
            'icon'  => 'error',
            'title' => $validator->getMessageBag()->first(),
        ], 400);
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
$team = Team::findOrFail($id);

    if ($team->user) {
        $team->user->delete();
    }

    // حذف ارتزان
    $isDeleted = $team->delete();


    if ($isDeleted) {
        return response()->json([
            'icon' => 'success',
            'title' => 'Deleted successfully'
        ], 200);
    } else {
        return response()->json([
            'icon' => 'error',
            'title' => 'Deletion failed'
        ], 400);
    }    }


        public function trashed() {
    $teams = Team::onlyTrashed()->get();
    return response()->view('cms.team.trashed', compact('teams'));
}

public function restore($id) {
    $team = Team::withTrashed()->findOrFail($id);
    $team->restore();
    return redirect()->back()->with('success', 'تمت استعادة المسؤول بنجاح');
    // return response()->json(['icon' => 'success', 'title' => 'تم الاسترجاع بنجاح'], 200);
}
public function force($id) {
    $team = Team::withTrashed()->findOrFail($id);
    $team->forceDelete();
    return response()->json(['icon' => 'success', 'title' => 'تم الحذف النهائي بنجاح'], 200);
}
public function forceAll() {
    // جلب كل الأدمنز المحذوفين مع اليوزرز تبعهم
    $teams = Team::onlyTrashed()->get();

    foreach($teams as $team) {
        // حذف اليوزر المرتبط في جدول users (إذا كان موجوداً)
        if($team->user) {
            $team->user()->forceDelete();
        }
        // حذف الأدمن نفسه نهائياً
        $team->forceDelete();
    }

    // return response()->json(['icon' => 'success', 'title' => 'تم تفريغ السلة وحذف الحسابات المرتبطة نهائياً'], 200);
    return redirect()->back()->with('success', 'تم إفراغ البيانات بنجاح');
}

}
