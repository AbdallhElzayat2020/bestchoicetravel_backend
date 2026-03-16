<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RecaptchaService
{
    protected string $secretKey;

    protected string $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';

    public function __construct()
    {
        $this->secretKey = (string) config('services.recaptcha.secret_key', '');
    }

    /**
     * Verify reCAPTCHA v2 response token.
     * Returns true if valid, false otherwise.
     */
    public function verify(?string $response, ?string $remoteIp = null): bool
    {
        if (empty($this->secretKey) || empty($response)) {
            return false;
        }

        $payload = [
            'secret' => $this->secretKey,
            'response' => $response,
        ];

        if ($remoteIp !== null && $remoteIp !== '') {
            $payload['remoteip'] = $remoteIp;
        }

        $result = Http::asForm()->post($this->verifyUrl, $payload);

        if (!$result->successful()) {
            return false;
        }

        $body = $result->json();
        return ($body['success'] ?? false) === true;
    }

    /**
     * Check if reCAPTCHA is configured (so we can show the widget).
     */
    public static function isConfigured(): bool
    {
        return !empty(config('services.recaptcha.site_key'))
            && !empty(config('services.recaptcha.secret_key'));
    }
}
