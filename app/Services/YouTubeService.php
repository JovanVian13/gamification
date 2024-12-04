<?php

namespace App\Services;

use GuzzleHttp\Client;

class YoutubeService
{
    protected $apiKey;
    protected $httpClient;

    public function __construct()
    {
        $this->apiKey = config('services.youtube.api_key'); // Pastikan API Key ada di config/services.php
        $this->httpClient = new Client(['base_uri' => 'https://www.googleapis.com/youtube/v3/']);
    }

    public function getVideoStatistics($videoId)
    {
        $response = $this->httpClient->get('videos', [
            'query' => [
                'id' => $videoId,
                'part' => 'statistics',
                'key' => $this->apiKey,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function checkVideoLike($videoId, $accessToken)
    {
        $client = new Client();
        $response = $client->get('https://www.googleapis.com/youtube/v3/videos', [
            'query' => [
                'part' => 'statistics',
                'id' => $videoId,
                'key' => $this->apiKey,
                'access_token' => $accessToken,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

}
