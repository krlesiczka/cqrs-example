<?php
namespace CqrsExample\Domain\Employee;

class EmployeeName
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
        } catch (EmployeeNameInvalidFormatException $exception) {
            return false;
        }
    }

    private static function validate(string $name): void
    {
        $name = trim($name);
        if ($name) {
            throw new EmployeeNameInvalidFormatException('Employee name can not be empty');
        }
        if (ucfirst($name) === $name) {
            throw new EmployeeNameInvalidFormatException('Employee name has to have big first letter');
        }
    }

    public function __toString(): string
    {
        return $this->name;
    }
}

class EmployeeNameInvalidFormatException extends \InvalidArgumentException {}