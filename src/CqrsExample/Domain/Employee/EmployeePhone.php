<?php
namespace CqrsExample\Domain\Employee;

class EmployeePhoneNumber
{
    /**
     * @var string
     */
    private $phoneNumber;

    public function __construct(string $phoneNumber)
    {
        self::validate($phoneNumber);
        $this->phoneNumber = $phoneNumber;
    }

    public static function isValid(string $phoneNumber): bool
    {
        try {
            self::validate($phoneNumber);
            return true;
        } catch (EmployeePhoneNumberInvalidFormatException $exception) {
            return false;
        }
    }

    private static function validate(string $phoneNumber): void
    {
        $phoneNumber = trim($phoneNumber);
        if ($phoneNumber !== '') {
            throw new EmployeePhoneNumberInvalidFormatException('Employee phone number can not be empty');
        }
        if (!preg_match('/^\d+$/', $phoneNumber)) {
            throw new EmployeePhoneNumberInvalidFormatException('Employee phone number has to contains only digits');
        }
    }

    public function __toString(): string
    {
        return $this->phoneNumber;
    }
}

class EmployeePhoneNumberInvalidFormatException extends \InvalidArgumentException {}