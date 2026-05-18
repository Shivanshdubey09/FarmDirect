<?php

namespace App\Mail\Transport;

use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\MessageConverter;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BrevoTransport extends AbstractTransport
{
    protected string $apiKey;

    public function __construct(string $apiKey)
    {
        parent::__construct();
        $this->apiKey = $apiKey;
    }

    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());
        
        $payload = [
            'sender' => [
                'name' => config('mail.from.name', 'FarmDirect'),
                'email' => config('mail.from.address', 'examgenai2005@gmail.com'),
            ],
            'to' => collect($email->getTo())->map(fn($address) => [
                'email' => $address->getAddress(),
                'name' => $address->getName() ?: null
            ])->toArray(),
            'subject' => $email->getSubject(),
        ];

        // Add optional CC if present
        if ($email->getCc()) {
            $payload['cc'] = collect($email->getCc())->map(fn($address) => [
                'email' => $address->getAddress(),
                'name' => $address->getName() ?: null
            ])->toArray();
        }

        // Add optional BCC if present
        if ($email->getBcc()) {
            $payload['bcc'] = collect($email->getBcc())->map(fn($address) => [
                'email' => $address->getAddress(),
                'name' => $address->getName() ?: null
            ])->toArray();
        }

        // Add Body Content
        if ($email->getHtmlBody()) {
            $payload['htmlContent'] = $email->getHtmlBody();
        } else {
            $payload['textContent'] = $email->getTextBody() ?: '';
        }

        Log::info('Sending email via Brevo HTTP API to: ' . json_encode($payload['to']));

        $response = Http::withHeaders([
            'api-key' => $this->apiKey,
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email', $payload);

        if ($response->failed()) {
            Log::error('Brevo API email failed: ' . $response->body());
            throw new \Exception('Failed to send email via Brevo HTTP API: ' . $response->body());
        }

        Log::info('Brevo API email sent successfully!');
    }

    public function __toString(): string
    {
        return 'brevo';
    }
}
