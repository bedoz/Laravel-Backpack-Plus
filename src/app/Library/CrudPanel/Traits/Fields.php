<?php

namespace Bedoz\BackpackPlus\app\Library\CrudPanel\Traits;

use Backpack\CRUD\app\Library\CrudPanel\Traits\Fields as OriginalFields;

trait Fields
{
    use OriginalFields;

    /**
     * Returns the request without anything that might have been maliciously inserted.
     * Only specific field names that have been introduced with addField() are kept in the request.
     */
    public function getStrippedSaveRequest()
    {
        $setting = $this->getOperationSetting('saveAllInputsExcept');

        if ($setting == false || $setting == null) {
            return $this->request->only($this->getAllFieldNames());
        }

        if (is_array($setting)) {
            return collect($this->request->post())
                ->except($this->getOperationSetting('saveAllInputsExcept'))
                ->toArray();
        }

        return $this->request->only($this->getAllFieldNames());
    }
}
