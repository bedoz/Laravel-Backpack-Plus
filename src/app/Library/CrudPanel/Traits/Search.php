<?php

namespace Bedoz\BackpackPlus\app\Library\CrudPanel\Traits;

use Carbon\Carbon;
use Validator;
use Backpack\CRUD\app\Library\CrudPanel\Traits\Search as OriginalSearch;

trait Search
{
    use OriginalSearch;

    /**
     * Apply the search logic for each CRUD column.
     */
    public function applySearchLogicForColumn($query, $column, $searchTerm)
    {
        $columnType = $column['type'];

        // if there's a particular search logic defined, apply that one
        if (isset($column['searchLogic'])) {
            $searchLogic = $column['searchLogic'];

            // if a closure was passed, execute it
            if (is_callable($searchLogic)) {
                return $searchLogic($query, $column, $searchTerm);
            }

            // if a string was passed, search like it was that column type
            if (is_string($searchLogic)) {
                $columnType = $searchLogic;
            }

            // if false was passed, don't search this column
            if ($searchLogic == false) {
                return;
            }
        }

        // sensible fallback search logic, if none was explicitly given
        if ($column['tableColumn']) {
            switch ($columnType) {
                case 'email':
                case 'text':
                case 'textarea':
                    if (method_exists($this->model, 'translationEnabledForModel') && $this->model->translationEnabledForModel() && $this->model->isTranslation($column['name'])) {
                        $query->orWhereTranslationLike($column['name'], '%'.$searchTerm.'%');
                    } else {
                        $query->orWhere($column['name'], 'like', '%'.$searchTerm.'%');
                    }
                    break;

                case 'date':
                case 'datetime':
                    $validator = Validator::make(['value' => $searchTerm], ['value' => 'date']);

                    if ($validator->fails()) {
                        break;
                    }

                    $query->orWhereDate($column['name'], Carbon::parse($searchTerm));
                    break;

                case 'select':
                case 'select_multiple':
                    $query->orWhereHas($column['entity'], function ($q) use ($column, $searchTerm) {
                        $q->where($column['attribute'], 'like', '%'.$searchTerm.'%');
                    });
                    break;

                default:
                    return;
                    break;
            }
        }

        return;
    }
}
