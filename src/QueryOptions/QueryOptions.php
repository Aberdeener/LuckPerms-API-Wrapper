<?php

namespace LuckPermsAPI\QueryOptions;

use Illuminate\Support\Collection;
use LuckPermsAPI\Context\Context;

class QueryOptions
{
    private QueryMode $mode;
    private Collection $flags;
    private Collection $contexts;

    private function __construct()
    {
        $this->flags = new Collection();
        $this->contexts = new Collection();
    }

    public static function make(): QueryOptions
    {
        return new self();
    }

    public function setMode(QueryMode $mode): QueryOptions
    {
        $this->mode = $mode;

        return $this;
    }

    public function withFlag(QueryFlag $flag): QueryOptions
    {
        $this->flags[] = $flag;

        return $this;
    }

    public function withContext(Context $context): QueryOptions
    {
        $this->contexts[] = $context;

        return $this;
    }

    public function toArray(): array
    {
        $queryOptions = [];

        if (isset($this->mode)) {
            $queryOptions['mode'] = $this->mode->value;
        }

        if ($this->flags->isNotEmpty()) {
            $queryOptions['flags'] = $this->flags->map(function (QueryFlag $flag): string {
                return $flag->value;
            })->toArray();
        }

        if ($this->contexts->isNotEmpty()) {
            $queryOptions['contexts'] = $this->contexts->map(function (Context $context): array {
                return [
                    'key' => $context->key()->value,
                    'value' => $context->value(),
                ];
            })->toArray();
        }

        return $queryOptions;
    }
}
