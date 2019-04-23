<?php

namespace CqrsExample\Application\Query\Dto;

class CompanyDto
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $domain;

    /**
     * @var int
     */
    public $employeesCount;
}