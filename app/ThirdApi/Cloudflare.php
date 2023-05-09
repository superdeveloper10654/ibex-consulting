<?php

namespace App\ThirdApi;

/**
 * Cloudflare API [https://api.cloudflare.com/]
 * Singleton
 * 
 * @todo maybe replace with composer package if more API actions is required
 */
class Cloudflare
{
    /** @var string */
    const BASE_URL = 'https://api.cloudflare.com/client/v4';

    /** @var static Instance of class */
    private static $instance;

    /**
     * @throws Exception
     */
    private function __construct() {}

    private function __clone() {}

    /**
     * Return class instance
     */
    public static function instance()
    {
        if (empty(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }


    /**
     * Add A dns record
     * @return <object>
     * @throws Exception json_decoded
     */
    public function addTenantDnsRecord($name)
    {
        $data = [
            "type"      => "A",
            "name"      => $name,
            "content"   => env('CLOUDFLARE_IP'),
            "ttl"       => 120,
            "proxied"   =>  true
        ];
        $url = static::BASE_URL . '/zones/' . env('CLOUDFLARE_ZONE') . "/dns_records";

        return $this->request('POST', $url, $data);
    }

    /**
     * Check if dns record
     * @return bool
     * @throws Exception json_decoded
     */
    public function isTenantDnsRecordExists($name)
    {
        $data = [
            "type"      => "A",
            "name"      => $name,
            "content"   => env('CLOUDFLARE_IP'),
            "proxied"   =>  true
        ];
        $url = static::BASE_URL . '/zones/' . env('CLOUDFLARE_ZONE') . "/dns_records";
        $res = $this->request('GET', $url, $data);

        return !empty($res->result);
    }

    /**
     * Send request to api and return response
     * 
     * @param string<GET|POST|PUT> $method
     * @param string $url
     * @param array $data
     * 
     * @return object{status:int,body:array<string,string>}
     * 
     * @throws Exception
     */ 
    private function request($method, $url, $data = [])
    {
        $headers = [
            ('X-Auth-Email: ' . env('CLOUDFLARE_AUTH_EMAIL')),
            ('X-Auth-Key: ' . env('CLOUDFLARE_AUTH_KEY')),
        ];

        $curl = curl_init();

        switch ($method) {
            case "GET":
                if ($data) {
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                }
                break;

            case "DELETE":
            case "POST": 
            case "PATCH":
                $headers[] = 'Content-Type: application/json';
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

                if ($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                }

                break;

            default:
                throw new \Exception("Method '$method' not added for request" );
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $body = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);
        if (!in_array($status, [200, 201, 204])) {
            throw new \Exception($body);
        }

        return json_decode($body);
    }
}
