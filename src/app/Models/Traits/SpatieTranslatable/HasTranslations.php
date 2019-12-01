<?php

namespace Bedoz\BackpackPlus\App\Models\Traits\SpatieTranslatable;

use Spatie\Translatable\HasTranslations as OriginalHasTranslations;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations as OriginalSpatie;

trait HasTranslations
{
    use OriginalHasTranslations;
    use OriginalSpatie;

    public function getAttributes()
    {
        return $this->getTranslatableAttributes();
    }
    public function isTranslation($key)
    {
        return $this->isTranslatableAttribute($key);
    }
    public function orderTranslationBy($query, $field, $order)
    {
        return $query;
    }
    public function addTranslationJoin($query)
    {
        return $query;
    }
}
