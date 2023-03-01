<?php

namespace Skyracer2012\HttpMailDriver;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\EventDispatcher\EventDispatcher;
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
        parent::__construct(new EventDispatcher());

        $this->key = $key;
        $this->url = $url;
        $this->client = new Client();
    }

    protected function getPayload(Email $email): array
    {
        //Mailchannels Format as in https://api.mailchannels.net/tx/v1/documentation
        return [
            'headers' => [
                'Authorization' => $this->key,
                'Accept'        => 'application/json',
            ],
            'json' => [
                'subject' => $email->getSubject(),
                'personalizations' => [
                    [
                        'to' => $this->mapContactsToNameEmail($email->getTo()),
                        'cc' => $this->mapContactsToNameEmail($email->getCc()),
                        'bcc' => $this->mapContactsToNameEmail($email->getBcc()),
                    ]
                ],
                'from' => [
                    'name' => $email->getFrom()[0]->getName(),
                    'email' => $email->getFrom()[0]->getAddress(),
                ],
                'content' => [
                    [
                        'type' => 'text/plain',
                        'value' => $email->getTextBody(),
                    ],
                    [
                        'type' => 'text/html',
                        'value' => $email->getHtmlBody(),
                    ]
                ],
            ],
        ];
    }

    protected function mapContactsToNameEmail($contacts): array
    {
        $formatted = [];
        if (empty($contacts)) {
            return [];
        }
        foreach ($contacts as $contact) {
            if(!$contact instanceof Address)
                continue;
            $formatted[] =  [
                'name' => $contact->getName(),
                'email' => $contact->getAddress()
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