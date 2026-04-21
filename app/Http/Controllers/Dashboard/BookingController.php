<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\TourBookingsExport;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['tour', 'accommodationType']);
        $hasStatusFilter = $request->has('status') && in_array($request->status, ['pending', 'confirmed', 'cancelled']);
        $currentStatus = $hasStatusFilter ? $request->status : null;

        // Filter by status if provided
        if ($hasStatusFilter) {
            $query->where('status', $currentStatus);
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(perPage: 15);

        // Get counts for all statuses (unified queries)
        // If we have a status filter, paginate() already executed a count query for that status
        // So we can reuse it to avoid duplicate query
        $pendingCount = $currentStatus === 'pending'
            ? $bookings->total()
            : Booking::pending()->count();

        $confirmedCount = $currentStatus === 'confirmed'
            ? $bookings->total()
            : Booking::confirmed()->count();

        $cancelledCount = $currentStatus === 'cancelled'
            ? $bookings->total()
            : Booking::cancelled()->count();

        $allCount = $hasStatusFilter ? Booking::count() : $bookings->total();

        return view('dashboard.bookings.index', compact('bookings', 'pendingCount', 'confirmedCount', 'cancelledCount', 'allCount'));
    }

    public function export(Request $request)
    {
        $columns = $request->input('columns', []);
        if (empty($columns)) {
            $columns = ['email', 'full_name'];
        } elseif (is_string($columns)) {
            $columns = explode(',', $columns);
        }

        $filename = 'tour_bookings_'.date('Y-m-d_His').'.xlsx';
        return Excel::download(new TourBookingsExport($columns), $filename);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->load(['tour', 'accommodationType']);
        return view('dashboard.bookings.show', compact('booking'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $oldStatus = $booking->status;

        // Update only the validated fields
        $booking->status = $validated['status'];
        if (isset($validated['notes'])) {
            $booking->notes = $validated['notes'];
        }
        $booking->save();

        $newStatus = $validated['status'];

        // Redirect to the new status filter (so the booking appears in the correct list)
        $redirectUrl = route('admin.bookings.index', ['status' => $newStatus]);

        return redirect($redirectUrl)
            ->with('success', 'Booking status updated from ' . ucfirst($oldStatus) . ' to ' . ucfirst($newStatus) . ' successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking deleted successfully');
    }
}
