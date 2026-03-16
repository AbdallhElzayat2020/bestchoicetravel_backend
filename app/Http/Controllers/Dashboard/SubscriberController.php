<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use App\Exports\SubscribersExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscribers = Subscriber::orderBy('created_at', 'desc')->get();

        return view('dashboard.subscribers.index', compact('subscribers'));
    }

    /**
     * Export subscribers to Excel
     */
    public function export(Request $request)
    {
        $columns = $request->input('columns', []);

        // Default to email and name only
        if (empty($columns)) {
            $columns = ['email', 'name'];
        } else {
            // If columns are provided as comma-separated string, convert to array
            if (is_string($columns)) {
                $columns = explode(',', $columns);
            }
        }

        $filename = 'subscribers_' . date('Y-m-d_His') . '.xlsx';

        return Excel::download(new SubscribersExport($columns), $filename);
    }

    /**
     * Toggle subscriber active status.
     */
    public function toggleStatus(Subscriber $subscriber)
    {
        $newStatus = !$subscriber->is_active;

        $subscriber->update([
            'is_active' => $newStatus,
            'unsubscribed_at' => $newStatus ? null : now(),
        ]);

        $status = $newStatus ? 'activated' : 'deactivated';

        return redirect()->back()->with('success', "Subscriber {$status} successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();

        return redirect()->route('admin.subscribers.index')
            ->with('success', 'Subscriber deleted successfully');
    }
}
