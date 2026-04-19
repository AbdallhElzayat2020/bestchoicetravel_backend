<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Contact;

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
