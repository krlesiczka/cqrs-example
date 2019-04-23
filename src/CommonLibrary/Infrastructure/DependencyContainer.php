<?php
namespace CommonLibrary\Infrastructure;

use Psr\Container\ContainerInterface;
use League\Container\Container;
use League\Container\ReflectionContainer;

class DependencyContainer
{
    /**
     * @var ContainerInterface
     */
    private static $container = null;

    /**
     * @param bool $forceRebuild
     */
    public static function build(bool $forceRebuild = false): void
    {
        if (self::$container === null || $forceRebuild) {

            $c = new Container;
            $c->delegate(new ReflectionContainer);

            //TODO configure

            self::$container = $c;
        }
    }


    public static function get(): ContainerInterface
    {
        if (self::$container === null) {
            self::build();
        }
        return self::$container;
    }
}
