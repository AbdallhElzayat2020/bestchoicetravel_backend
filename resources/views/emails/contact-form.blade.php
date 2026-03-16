<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        h2 { color: #8b7138; border-bottom: 1px solid #eee; padding-bottom: 8px; }
        .field { margin-bottom: 12px; }
        .label { font-weight: bold; color: #555; }
        .message { background: #f5f5f5; padding: 12px; border-radius: 8px; margin-top: 16px; white-space: pre-wrap; }
    </style>
</head>
<body>
    <h2>تواصل معانا - رسالة جديدة</h2>
    <p>تم استلام رسالة من نموذج التواصل:</p>

    <div class="field"><span class="label">الاسم:</span> {{ $name }}</div>
    <div class="field"><span class="label">البريد الإلكتروني:</span> {{ $email }}</div>
    @if($phone)
    <div class="field"><span class="label">الهاتف:</span> {{ $phone }}</div>
    @endif
    @if($contactSubject)
    <div class="field"><span class="label">الموضوع:</span> {{ $contactSubject }}</div>
    @endif
    <div class="field"><span class="label">الرسالة:</span></div>
    <div class="message">{{ $contactMessage }}</div>

    <p style="margin-top: 24px; color: #888; font-size: 12px;">هذه الرسالة من موقع Grand Nile Cruises.</p>
</body>
</html>
