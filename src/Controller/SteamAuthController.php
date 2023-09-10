<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class SteamAuthController extends AbstractController
{
    public function __invoke()
    {
        // /login-with-steam-yt/process-openId.php?
        //openid.ns=http://specs.openid.net/auth/2.0
        //&openid.mode=id_res
        //&openid.op_endpoint=https://steamcommunity.com/openid/login
        //&openid.claimed_id=https://steamcommunity.com/openid/id/76561197984781593
        //&openid.identity=https://steamcommunity.com/openid/id/76561197984781593
        //&openid.return_to=http://localhost:3000/login-with-steam-yt/process-openId.php
        //&openid.response_nonce=2023-09-12T02:19:09Z4KuxfePH08hQhBOaUEDXQyP%2BEdE%3D&openid.assoc_handle=1234567890
        //&openid.signed=signed,op_endpoint,claimed_id,identity,return_to,response_nonce,assoc_handle
        //&openid.sig=wUFN9WtJF65ubhIh2Nl7Wezl2CE%3D
        return new User();
    }
}
