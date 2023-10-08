<?php

declare(strict_types=1);

namespace App\Tests\Unit\Message;

use App\Message\SteamAuthorizeCommand\AuthData;
use PHPUnit\Framework\TestCase;

class SteamAuthorizeCommandDataTest extends TestCase
{
    public function testSerialize(): void
    {
        $data = new AuthData(
            'http://specs.openid.net/auth/2.0',
            'id_res',
            'https://steamcommunity.com/openid/login',
            'https://steamcommunity.com/openid/id/76561197984781593',
            'https://steamcommunity.com/openid/id/76561197984781593',
            'http://localhost:3000/auth-via-steam',
            '2023-09-16T11:19:09Z4KuxfePH08hQhBOaUEDXQyP%2BEdE%3D',
            '1234567890',
            'signed,op_endpoint,claimed_id,identity,return_to,response_nonce,assoc_handle',
            'wUFN9WtJF65ubhIh2Nl7Wezl2CE%3D',
        );

        $unserialized = unserialize(serialize($data));

        $this->assertInstanceOf(AuthData::class, $unserialized);
        $this->assertNotSame($data, $unserialized);
        $this->assertTrue($data == $unserialized);
    }
}
