<?php

namespace Bedoz\BackpackPlus\app\Library\CrudPanel;

use Bedoz\BackpackPlus\app\Library\CrudPanel\Traits\Actions;
use Bedoz\BackpackPlus\app\Library\CrudPanel\Traits\Columns;
use Bedoz\BackpackPlus\app\Library\CrudPanel\Traits\Fields;
use Bedoz\BackpackPlus\app\Library\CrudPanel\Traits\Query;
use Bedoz\BackpackPlus\app\Library\CrudPanel\Traits\SaveActions;
use Bedoz\BackpackPlus\app\Library\CrudPanel\Traits\Search;

class CrudPanel extends \Backpack\CRUD\app\Library\CrudPanel
{
    use Actions, Columns, Fields, Query, SaveActions, Search;
}
