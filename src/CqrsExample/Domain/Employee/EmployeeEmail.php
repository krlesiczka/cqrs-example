<?php
namespace CqrsExample\Domain\Employee;

use CqrsExample\Domain\Company\CompanyDomain;

class EmployeeEmail
{
    /**
     * @var string
     */
    private $email;

    public function __construct(string $email)
    {
        if (!self::isValid($email)) {
            throw new EmployeeEmailInvalidFormatException('Employee email has invalid format.');
        }
        $this->email = $email;
    }

    public static function isValid(string $email): bool
    {
        return (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function isInCompanyDomain(CompanyDomain $domain): bool
    {
        $emailDomain = strtolower(substr($this->email, strpos($this->email, '@') + 1));
        $companyDomain = strtolower($domain);
        return $emailDomain === $companyDomain;
    }

    public function equals(EmployeeEmail $otherEmail): bool
    {
        return $this->__toString() === $otherEmail->__toString();
    }

    public function __toString(): string
    {
        return $this->email;
    }
}

class EmployeeEmailInvalidFormatException extends \InvalidArgumentException {}