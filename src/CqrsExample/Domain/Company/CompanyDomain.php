<?php
namespace CqrsExample\Domain\Company;

class CompanyDomain
{
    /**
     * @var string
     */
    private $domain;

    public function __construct(string $domain)
    {
        if (!self::isValid($domain)) {
            throw new CompanyDomainInvalidFormatException('Company domain has invalid format.');
        }
        $this->domain = $domain;
    }

    public static function isValid(string $domain): bool
    {
        return (bool)filter_var($domain, FILTER_VALIDATE_DOMAIN);
    }

    public function __toString(): string
    {
        return $this->domain;
    }
}

class CompanyDomainInvalidFormatException extends \InvalidArgumentException {}