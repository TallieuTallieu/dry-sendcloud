<?php

namespace Tnt\Sendcloud\Revisions;

use dry\db\Connection;
use Tnt\Dbi\QueryBuilder;

abstract class DatabaseRevision
{
    protected QueryBuilder $queryBuilder;

    public function __construct(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    protected function execute(): void
    {
        $this->queryBuilder->build();
        Connection::get()->query($this->queryBuilder->getQuery());
    }
}
