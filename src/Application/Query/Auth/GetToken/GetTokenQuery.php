<?php

namespace App\Application\Query\Auth\GetToken;

use App\Domain\User\ValueObject\Email;

class GetTokenQuery
{
    /**
     * @var Email
     */
    public $email;

    public function __construct(string $email)
    {
        $this->email = Email::fromString($email);
    }
}
