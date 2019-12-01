<?php

namespace Bedoz\BackpackPlus\app\Library\CrudPanel\Traits;

use Backpack\CRUD\app\Library\CrudPanel\Traits\Query as OriginalQuery;

trait Query
{
    use OriginalQuery;

    /**
     * Order the results of the query in a certain way.
     *
     * @param string $field
     * @param string $order
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function orderBy($field, $order = 'asc')
    {
        if ($this->request->has('order')) {
            return $this->query;
        }

        if (method_exists($this->model, 'translationEnabledForModel') && $this->model->translationEnabledForModel()) {
            if ($this->model->isTranslation($field)) {
                return $this->model->orderTranslationBy($this->query, $field, $order);
            }
        }

        return $this->query->orderBy($field, $order);
    }

    /**
     * Count the number of results.
     *
     * @return int
     */
    public function count()
    {
        if (method_exists($this->model, 'translationEnabledForModel') && $this->model->translationEnabledForModel()) {
            $this->query = $this->model->addTranslationJoin($this->query);
        }
        return $this->query->get()->count();
    }
}
