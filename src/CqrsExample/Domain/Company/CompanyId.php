<?php
namespace CqrsExample\Domain\Company;

use Ramsey\Uuid\Uuid;

class CompanyId
{
    /**
     * @var string
     */
    private $uuid;

    public function __construct(string $uuid)
    {
        if (!self::isValid($uuid)) {
            throw new CompanyIdInvalidFormatException('Company id has invalid format. UUID required.');
        }
        $this->uuid = $uuid;
    }

    public static function isValid(string $uuid): bool
    {
        return Uuid::isValid($uuid);
    }

    public function __toString(): string
    {
        return $this->uuid;
    }
}

class CompanyIdInvalidFormatException extends \InvalidArgumentException {}