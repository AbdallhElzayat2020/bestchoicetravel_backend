<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\CruiseVesselBookingsExport;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CruiseVesselEnquiryController extends Controller
{
    public function index()
    {
        $enquiries = Contact::query()
            ->cruiseVesselEnquiries()
            ->orderBy('is_read')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('dashboard.bookings.cruise-vessels.index', compact('enquiries'));
    }

    public function export(Request $request)
    {
        $columns = $request->input('columns', []);
        if (empty($columns)) {
            $columns = ['email', 'name'];
        } elseif (is_string($columns)) {
            $columns = explode(',', $columns);
        }

        $filename = 'nile_cruise_bookings_'.date('Y-m-d_His').'.xlsx';
        return Excel::download(new CruiseVesselBookingsExport($columns), $filename);
    }

    public function show(Contact $contact)
    {
        if (! $contact->isCruiseVesselEnquiry()) {
            abort(404);
        }

        if (! $contact->is_read) {
            $contact->markAsRead();
        }

        return view('dashboard.bookings.cruise-vessels.show', compact('contact'));
    }

    public function markAsRead(Contact $contact)
    {
        if (! $contact->isCruiseVesselEnquiry()) {
            abort(404);
        }
        $contact->markAsRead();

        return redirect()->back()->with('success', 'Marked as read');
    }

    public function markAsUnread(Contact $contact)
    {
        if (! $contact->isCruiseVesselEnquiry()) {
            abort(404);
        }
        $contact->update([
            'is_read' => false,
            'read_at' => null,
        ]);

        return redirect()->back()->with('success', 'Marked as unread');
    }
}
