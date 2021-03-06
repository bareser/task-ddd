<?php

namespace App\Domain\Company\ValueObject\Prefix\Type;

use App\Domain\Company\ValueObject\Prefix\AbstractCompanyPrefix;
use App\Domain\Company\ValueObject\Prefix\CompanyPrefixInterface;
use Assert\Assertion;

class Merchant extends AbstractCompanyPrefix
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return Cargo
     */
    public static function fromString(string $prefix): CompanyPrefixInterface
    {
        Assertion::length($prefix, 3);
        $merchant = new self();
        $merchant->prefix = $prefix;

        return $merchant;
    }
}
