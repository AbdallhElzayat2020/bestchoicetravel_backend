<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\TripPlannerBookingsExport;
use App\Http\Controllers\Controller;
use App\Models\TripPlanner;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TripPlannerController extends Controller
{
    public function index()
    {
        $requests = TripPlanner::orderBy('is_read')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('dashboard.trip-planners.index', compact('requests'));
    }

    public function export(Request $request)
    {
        $columns = $request->input('columns', []);
        if (empty($columns)) {
            $columns = ['email', 'full_name'];
        } elseif (is_string($columns)) {
            $columns = explode(',', $columns);
        }

        $filename = 'trip_planner_leads_'.date('Y-m-d_His').'.xlsx';
        return Excel::download(new TripPlannerBookingsExport($columns), $filename);
    }

    public function show(TripPlanner $trip_planner)
    {
        if (! $trip_planner->is_read) {
            $trip_planner->markAsRead();
        }

        return view('dashboard.trip-planners.show', ['tripPlanner' => $trip_planner]);
    }

    public function markAsRead(TripPlanner $tripPlanner)
    {
        $tripPlanner->markAsRead();

        return redirect()->back()->with('success', 'Marked as read');
    }

    public function markAsUnread(TripPlanner $tripPlanner)
    {
        $tripPlanner->update([
            'is_read' => false,
            'read_at' => null,
        ]);

        return redirect()->back()->with('success', 'Marked as unread');
    }

    public function destroy(TripPlanner $trip_planner)
    {
        $trip_planner->delete();

        return redirect()->route('admin.trip-planners.index')
            ->with('success', 'Trip planner request deleted successfully');
    }
}
