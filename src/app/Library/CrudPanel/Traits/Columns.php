<?php

namespace Bedoz\BackpackPlus\app\Library\CrudPanel\Traits;

use Backpack\CRUD\app\Library\CrudPanel\Traits\Columns as OriginalColumns;

trait Columns
{
    use OriginalColumns;

    /**
     * @param string $table
     * @param string $name
     *
     * @return bool
     */
    protected function hasColumn($table, $name)
    {
        static $cache = [];

        if ($this->driverIsMongoDb()) {
            return true;
        }

        if (isset($cache[$table])) {
            $columns = $cache[$table];
        } else {
            $columns = $cache[$table] = $this->getSchema()->getColumnListing($table);
            if (method_exists($this->model, 'translationEnabledForModel') && $this->model->translationEnabledForModel()) {
                $columns = $cache[$table] = array_merge($cache[$table], $this->model->getAttributes());
            }
        }

        return in_array($name, $columns);
    }
}
