<?php

namespace App\Traits;

use App\Builders\JsonOnlyBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Config;

trait HasJsonFallback
{
    /**
     * Use JSON-backed builder when DB is offline.
     */
    public function newEloquentBuilder($query): Builder
    {
        if (Config::get('app.db_offline', false)) {
            return new JsonOnlyBuilder($this);
        }

        return parent::newEloquentBuilder($query);
    }

    /**
     * Save the model (noop in offline mode).
     */
    public function save(array $options = [])
    {
        if (Config::get('app.db_offline', false)) {
            $this->exists = true;
            return true;
        }

        return parent::save($options);
    }

    /**
     * Delete the model (noop in offline mode).
     */
    public function delete()
    {
        if (Config::get('app.db_offline', false)) {
            return true;
        }

        return parent::delete();
    }
}
