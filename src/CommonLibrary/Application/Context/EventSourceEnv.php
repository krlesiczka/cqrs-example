<?php
namespace CommonLibrary\Application\Context;


class EventSourceEnv
{
    public const HTTP = 'EventSourceEnvHttp';
    public const CLI = 'EventSourceEnvCli';
    public const APP = 'EventSourceEnvApp';

    public const SUPPORTED_ENV_LIST = [
        self::HTTP,
        self::CLI,
        self::APP
    ];

    /**
     * @var string
     */
    private $env;

    /**
     * EventSourceEnv constructor.
     *
     * @param string $env
     */
    public function __construct(string $env)
    {
        $this->env = $env;
    }

    public static function fromSapi(): self
    {
        if (PHP_SAPI === 'cli') {
            return new self(self::CLI);
        }
        return new self(self::APP);
    }


    /**
     * @return string
     */
    public function getEnv(): string
    {
        return $this->env;
    }
}