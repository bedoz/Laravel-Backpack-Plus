<?php

namespace Bedoz\BackpackPlus\app\Http\Controllers\Operations;

use Illuminate\Support\Facades\Route;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation as OriginalListOps;

trait ListOperation
{
    use OriginalListOps;

    /**
     * The search function that is called by the data table.
     *
     * @return array JSON Array of cells in HTML form.
     */
    public function search()
    {
        $this->crud->hasAccessOrFail('list');

        $totalRows = $this->crud->model->count();
        $filteredRows = $this->crud->count();
        $startIndex = $this->request->input('start') ?: 0;
        // if a search term was present
        if ($this->request->input('search') && $this->request->input('search')['value']) {
            // filter the results accordingly
            $this->crud->applySearchTerm($this->request->input('search')['value']);
            // recalculate the number of filtered rows
            $filteredRows = $this->crud->count();
        }
        // start the results according to the datatables pagination
        if ($this->request->input('start')) {
            $this->crud->skip((int) $this->request->input('start'));
        }
        // limit the number of results according to the datatables pagination
        if ($this->request->input('length')) {
            $this->crud->take((int) $this->request->input('length'));
        }
        // overwrite any order set in the setup() method with the datatables order
        if ($this->request->input('order')) {
            // clear any past orderBy rules
            $this->crud->query->getQuery()->orders = null;
            foreach ($this->request->input('order') as $order) {
                $column_number = $order['column'];
                $column_direction = $order['dir'];
                if (is_numeric($column_number)) {
                    $column = $this->crud->findColumnById($column_number);
                    if ($column['tableColumn']) {
                        // apply the current orderBy rules
                        $this->crud->orderBy($column['name'], $column_direction);
                    }
                } else {
                    $this->crud->orderBy($column_number, $column_direction);
                }
            }

            // check for custom order logic in the column definition
            if (isset($column['orderLogic'])) {
                $this->crud->customOrderBy($column, $column_direction);
            }
        }

        // show newest items first, by default (if no order has been set for the primary column)
        // if there was no order set, this will be the only one
        // if there was an order set, this will be the last one (after all others were applied)
        $orderBy = $this->crud->query->getQuery()->orders;
        $hasOrderByPrimaryKey = false;
        collect($orderBy)->each(function ($item, $key) use ($hasOrderByPrimaryKey) {
            if (! isset($item['column'])) {
                return false;
            }

            if ($item['column'] == $this->crud->model->getKeyName()) {
                $hasOrderByPrimaryKey = true;

                return false;
            }
        });
        if (! $hasOrderByPrimaryKey) {
            $this->crud->query->orderByDesc($this->crud->model->getKeyName());
        }

        $entries = $this->crud->getEntries();

        return $this->crud->getEntriesAsJsonForDatatables($entries, $totalRows, $filteredRows, $startIndex);
    }
}
