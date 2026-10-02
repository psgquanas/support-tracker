<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    // Daily handover view
    public function index(Request $request)
    {
        $date = $request->filled('date') ? Carbon::parse($request->date) : today();

        $activities = Activity::with(['updates.user', 'creator'])
            ->whereDate('activity_date', $date)
            ->orderBy('created_at')
            ->get();

        // Still pending from earlier days
        $carryOver = Activity::with(['updates.user'])
            ->where('status', 'pending')
            ->whereDate('activity_date', '<', $date)
            ->orderBy('activity_date')
            ->get();

        return view('activities.index', compact('activities', 'carryOver', 'date'));
    }

    public function create()
    {
        return view('activities.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'         => ['required', 'string', 'max:255'],
            'description'   => ['nullable', 'string', 'max:2000'],
            'activity_date' => ['required', 'date'],
            'system_count'  => ['nullable', 'integer', 'min:0'],
            'log_count'     => ['nullable', 'integer', 'min:0'],
        ]);

        $data['created_by'] = $request->user()->id;
        $data['status'] = 'pending';

        Activity::create($data);

        return redirect()
            ->route('activities.index', ['date' => $data['activity_date']])
            ->with('success', 'Activity added.');
    }

    // Add a status update (never overwrites history)
    public function addUpdate(Request $request, Activity $activity)
    {
        $data = $request->validate([
            'status' => ['required', 'in:done,pending'],
            'remark' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($activity, $data, $request) {
            $activity->updates()->create([
                'user_id' => $request->user()->id,
                'status'  => $data['status'],
                'remark'  => $data['remark'],
            ]);

            $activity->update(['status' => $data['status']]);
        });

        return back()->with('success', 'Activity updated.');
    }
}