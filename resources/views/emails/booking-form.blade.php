<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        h2 { color: #8b7138; border-bottom: 1px solid #eee; padding-bottom: 8px; }
        .field { margin-bottom: 12px; }
        .label { font-weight: bold; color: #555; }
        .box { background: #f5f5f5; padding: 12px; border-radius: 8px; margin: 16px 0; }
        ul { margin: 4px 0 0 0; padding-left: 20px; }
    </style>
</head>
<body>
    <h2>حجز جديد - Tour Egypt</h2>
    <p>تم استلام طلب حجز جديد:</p>

    <div class="box">
        <div class="field"><span class="label">الرحلة:</span> {{ $tour->title }}</div>
    </div>

    <div class="field"><span class="label">الاسم الكامل:</span> {{ $booking->full_name }}</div>
    <div class="field"><span class="label">البريد الإلكتروني:</span> {{ $booking->email }}</div>
    <div class="field"><span class="label">الهاتف:</span> {{ $booking->phone }}</div>
    <div class="field"><span class="label">الجنسية:</span> {{ $booking->nationality }}</div>
    <div class="field"><span class="label">عدد المسافرين:</span> {{ $booking->no_of_travellers }}</div>
    <div class="field"><span class="label">السعر الإجمالي:</span> ${{ number_format($booking->total_price, 0) }}</div>

    @if($booking->accommodationType)
    <div class="field"><span class="label">نوع الإقامة:</span> {{ $booking->accommodationType->price_name ?? '—' }}</div>
    @endif

    @if(!empty($variantNames))
    <div class="field">
        <span class="label">الاختيارات الإضافية:</span>
        <ul>
            @foreach($variantNames as $name)
                <li>{{ $name ?: '—' }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <p style="margin-top: 24px; color: #888; font-size: 12px;">هذا الطلب من موقع Grand Nile Cruises.</p>
</body>
</html>
