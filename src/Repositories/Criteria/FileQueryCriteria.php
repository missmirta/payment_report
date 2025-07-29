<?php

declare(strict_types=1);

namespace PaymentReport\Repositories\Criteria;

use App\Repositories\Common\QueryCriteriaInterface;
use Illuminate\Database\Eloquent\Builder;
use PaymentReport\Models\Relation\Contracts\HasFileRelationInterface;

class FileQueryCriteria implements QueryCriteriaInterface
{
    private function __construct(private readonly string $fileId)
    {
    }

    public static function make(string $fileId): FileQueryCriteria
    {
        return new FileQueryCriteria($fileId);
    }

    public function apply(Builder $query): Builder
    {
        $query->where($query->qualifyColumn(HasFileRelationInterface::ATTRIBUTE_FILE_ID), $this->fileId);

        return $query;
    }
}
