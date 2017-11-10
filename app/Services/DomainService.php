<?php

namespace App\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Spatie\SslCertificate\SslCertificate;

class DomainService
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get HTTP client
     *
     * @return Client
     */
    protected function getClient(): Client
    {
        return $this->client;
    }

    /**
     * Validate domain
     *
     * @param string $domain
     * @return bool
     */
    public function validate($domain): bool
    {
        try {
            $result = $this
                ->getClient()
                ->request('GET', $domain, [
                    'timeout' => 5
                ]);

            return $result->getStatusCode() == 200;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get certificate info
     *
     * @param $domain
     * @return array
     */
    public function getCertificateInfo($domain): array
    {
        try {
            $certificate = SslCertificate::createForHostName($domain);

            return [
                'Issuer'  => $certificate->getIssuer(),
                'Is Valid' => (bool) $certificate->isValid(),
                'Expired In' => $certificate->expirationDate()->diffInDays(Carbon::now()).' days',
            ];
        } catch (\Exception $e) {
            return [];
        }
    }
}