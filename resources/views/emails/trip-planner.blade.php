<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; max-width: 640px; margin: 0 auto; padding: 20px; }
        h2 { color: #2b539f; border-bottom: 1px solid #eee; padding-bottom: 8px; }
        .field { margin-bottom: 10px; }
        .label { font-weight: bold; color: #555; }
        .message { background: #f5f5f5; padding: 12px; border-radius: 8px; margin-top: 12px; white-space: pre-wrap; }
    </style>
</head>
<body>
    <h2>New Trip Planner request</h2>
    <p>You have received a new submission from the Trip Planner form.</p>

    <div class="field"><span class="label">Full name:</span> {{ $tripPlanner->full_name }}</div>
    <div class="field"><span class="label">Nationality:</span> {{ $tripPlanner->nationality }}</div>
    <div class="field"><span class="label">Phone:</span> {{ $tripPlanner->phone }}</div>
    <div class="field"><span class="label">Email:</span> {{ $tripPlanner->email }}</div>
    <div class="field"><span class="label">Travelers:</span>
        Adults (+12): {{ $tripPlanner->adults }} —
        Children (2–11): {{ $tripPlanner->children }} —
        Infants (0–2): {{ $tripPlanner->infants }}
    </div>
    <div class="field"><span class="label">Arrival date:</span> {{ $tripPlanner->arrival_date?->format('Y-m-d') ?? '—' }}</div>
    <div class="field"><span class="label">Departure date:</span> {{ $tripPlanner->departure_date?->format('Y-m-d') ?? '—' }}</div>
    <div class="field"><span class="label">Message:</span></div>
    <div class="message">{{ $tripPlanner->message }}</div>

    <p style="margin-top: 24px; color: #888; font-size: 12px;">Reply directly to this email to reach the guest.</p>
</body>
</html>
