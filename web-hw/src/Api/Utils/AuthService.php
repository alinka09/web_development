<?php

declare(strict_types=1);

namespace App\Api\Utils;


class AuthService
{
    private array $users = [
        'admin' => 'admin11'
    ];

    public function checkCredentials(string $authMetaData): bool
    {
        [$type, $credentials] = explode(' ', $authMetaData);
        $decodedCredentials = base64_decode($credentials);
        [$login, $pw] = explode(':', $decodedCredentials);

        $userPw = $this->users[$login] ?? false;
        if(!$userPw){
            return false;
        }

        if($userPw === $pw){
            return true;
        }
        return false;
    }
}