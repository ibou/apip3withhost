<?php

declare(strict_types=1);

namespace App\Service;

use App\Message\SteamAuthorizeCommand\AuthData;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

readonly class SteamService
{
    public function __construct(
        #[Autowire('%env(STEAM_API_KEY)%')] private string $steamApiKey
    ) {
    }

    public function check(AuthData $data): bool
    {
        $params = [
            'openid.assoc_handle' => $data->assoc_handle,
            'openid.signed'       => $data->signed,
            'openid.sig'          => $data->sig,
            'openid.ns'           => $data->ns,
            'openid.mode'         => 'check_authentication',
        ];

        $signed = explode(',', $data->signed);

        foreach ($signed as $item) {
            if (!property_exists($data, $item)) {
                return false;
            }
            $params['openid.' . $item] = stripslashes($data->$item);
        }

        $query = http_build_query($params);

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Accept-language: en\r\n".
                    "Content-type: application/x-www-form-urlencoded\r\n".
                    'Content-Length: '.strlen($query)."\r\n",
                'content' => $query,
            ],
        ]);

        $result = file_get_contents('https://steamcommunity.com/openid/login', false, $context);

        return (bool)preg_match("#is_valid\s*:\s*true#i", $result);
    }

    public function getPlayerSummary(string $steamId): array
    {
        $url = 'https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=%s&steamids=%s';
        $response = file_get_contents(sprintf($url, $this->steamApiKey, $steamId));
        $response = json_decode($response,true);

        return $response['response']['players'][0];
    }
}