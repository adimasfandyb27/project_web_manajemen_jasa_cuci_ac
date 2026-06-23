<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Facades\DataTables;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            return DataTables::of(Activity::with('causer'))
                ->addIndexColumn()

                ->addColumn('user', function ($row) {
                    return $row->causer->name ?? '-';
                })

                ->addColumn('event', function ($row) {
                    return $row->description;
                })

                ->addColumn('ip_address', function ($row) {
                    return $row->properties['ip'] ?? '-';
                })

                ->make(true);
        }

        return view('admin.activity-logs.index', [
            'totalActivity' => Activity::count(),
            'todayActivity' => Activity::whereDate('created_at', today())->count(),
            'activeUsers' => Activity::whereDate('created_at', today())
                ->distinct('causer_id')
                ->count('causer_id'),
        ]);
    }
}
