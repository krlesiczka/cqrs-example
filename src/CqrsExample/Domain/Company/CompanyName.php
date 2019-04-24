<?php
namespace CqrsExample\Domain\Company;

class CompanyName
{
    /**
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        $name = trim($name);
        self::validate($name);
        $this->name = $name;
    }

    public static function isValid(string $name): bool
    {
        try {
            self::validate($name);
            return true;
        } catch (CompanyNameInvalidFormatException $exception) {
            return false;
        }
    }

    private static function validate(string $name): void
    {
        $name = trim($name);
        if (empty($name)) {
            throw new CompanyNameInvalidFormatException('Company name can not be empty');
        }
        if (strtoupper($name) !== $name) {
            throw new CompanyNameInvalidFormatException('Company name has to be uppercase');
        }
    }

    public function __toString(): string
    {
        return $this->name;
    }
}

class CompanyNameInvalidFormatException extends \InvalidArgumentException {}