<?php

namespace Skyracer2012\HttpMailDriver;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\MessageConverter;

class HttpTransport extends AbstractTransport
{
    protected Client $client;
    protected string $key;
    protected string $url;

    public function __construct(string $url, string $key)
    {
        $this->key = $key;
        $this->url = $url;
        $this->client = new Client();
    }

    protected function getPayload(Email $email): array
    {
        // Change this to the format your API accepts
        return [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->key,
                'Accept'        => 'application/json',
            ],
            'json' => [
                'to' => $this->mapContactsToNameEmail($email->getTo()),
                'cc' => $this->mapContactsToNameEmail($email->getCc()),
                'bcc' => $this->mapContactsToNameEmail($email->getBcc()),
                'message' => $email->getBody(),
                'subject' => $email->getSubject(),
            ],
        ];
    }

    protected function mapContactsToNameEmail($contacts): array
    {
        $formatted = [];
        if (empty($contacts)) {
            return [];
        }
        foreach ($contacts as $address => $display) {
            $formatted[] =  [
                'name' => $display,
                'email' => $address,
            ];
        }
        return $formatted;
    }

    /**
     * @throws GuzzleException
     */
    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());

        $payload = $this->getPayload($email);

        $this->client->request('POST', $this->url, $payload);
    }

    public function __toString(): string
    {
        return 'http';
    }
}