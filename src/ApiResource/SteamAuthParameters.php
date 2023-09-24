<?php

declare(strict_types=1);

namespace App\ApiResource;

class SteamAuthParameters
{
    public const PARAMETERS = [
        [
            "name" => "openid.ns",
            "in" => "query",
            "description" => "",
            "required" => "true",
            "type" => "string",
        ],
        [
            "name" => "openid.mode",
            "in" => "query",
            "description" => "",
            "required" => "true",
            "type" => "string",
        ],
        [
            "name" => "openid.op_endpoint",
            "in" => "query",
            "description" => "",
            "required" => "true",
            "type" => "string",
        ],
        [
            "name" => "openid.claimed_id",
            "in" => "query",
            "description" => "",
            "required" => "true",
            "type" => "string",
        ],
        [
            "name" => "openid.identity",
            "in" => "query",
            "description" => "",
            "required" => "true",
            "type" => "string",
        ],
        [
            "name" => "openid.return_to",
            "in" => "query",
            "description" => "",
            "required" => "true",
            "type" => "string",
        ],
        [
            "name" => "openid.response_nonce",
            "in" => "query",
            "description" => "",
            "required" => "true",
            "type" => "string",
        ],
        [
            "name" => "openid.assoc_handle",
            "in" => "query",
            "description" => "",
            "required" => "true",
            "type" => "string",
        ],
        [
            "name" => "openid.signed",
            "in" => "query",
            "description" => "",
            "required" => "true",
            "type" => "string",
        ],
        [
            "name" => "openid.sig",
            "in" => "query",
            "description" => "",
            "required" => "true",
            "type" => "string",
        ],
    ];
}