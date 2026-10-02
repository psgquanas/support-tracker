<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    private function filters(Request $request): array
    {
        $request->validate([
            'from'   => ['nullable', 'date'],
            'to'     => ['nullable', 'date', 'after_or_equal:from'],
            'status' => ['nullable', 'in:done,pending'],
        ]);

        $from = Carbon::parse($request->input('from', today()->subDays(6)))->toDateString();
        $to   = Carbon::parse($request->input('to', today()))->toDateString();

        return [$from, $to, $request->input('status')];
    }

    private function baseQuery(string $from, string $to, ?string $status)
    {
        return Activity::query()
            ->whereBetween('activity_date', [$from, $to])
            ->when($status, fn ($q) => $q->where('status', $status));
    }

    public function index(Request $request)
    {
        [$from, $to, $status] = $this->filters($request);
        $base = $this->baseQuery($from, $to, $status);

        $stats = [
            'total'      => (clone $base)->count(),
            'done'       => (clone $base)->where('status', 'done')->count(),
            'pending'    => (clone $base)->where('status', 'pending')->count(),
            'mismatches' => (clone $base)
                ->whereNotNull('system_count')
                ->whereNotNull('log_count')
                ->whereColumn('system_count', '!=', 'log_count')
                ->count(),
        ];

        $activities = (clone $base)
            ->with(['updates.user', 'creator'])
            ->orderByDesc('activity_date')
            ->orderBy('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('reports.index', compact('activities', 'stats', 'from', 'to', 'status'));
    }

    // CSV export of the same filtered data
    public function export(Request $request)
    {
        [$from, $to, $status] = $this->filters($request);

        $activities = $this->baseQuery($from, $to, $status)
            ->with('updates.user')
            ->orderBy('activity_date')
            ->get();

        return response()->streamDownload(function () use ($activities) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Date', 'Activity', 'Current Status', 'System Count', 'Log Count',
                           'Update Status', 'Updated By', 'Staff ID', 'Update Time', 'Remark']);

            foreach ($activities as $a) {
                if ($a->updates->isEmpty()) {
                    fputcsv($out, [$a->activity_date->toDateString(), $a->title, $a->status,
                                   $a->system_count, $a->log_count, '', '', '', '', '']);
                    continue;
                }
                foreach ($a->updates->sortBy('created_at') as $u) {
                    fputcsv($out, [
                        $a->activity_date->toDateString(), $a->title, $a->status,
                        $a->system_count, $a->log_count,
                        $u->status, $u->user->name, $u->user->staff_id,
                        $u->created_at->format('Y-m-d H:i'), $u->remark,
                    ]);
                }
            }
            fclose($out);
        }, "activity-report-{$from}-to-{$to}.csv");
    }
}