<?php

namespace App\ThrustHelpers\Fields;

use BadChoice\Thrust\Fields\BelongsToMany;

class Tags extends BelongsToMany
{
    public function displayInIndex($object)
    {
        return $object->presenter()->tags;
    }

    public function displayInEdit($object, $inline = false)
    {
        return view('components.fields.tags', [
            'title'       => $this->getTitle(),
            'description' => $this->getDescription(),
            'field'       => $this->field,
            'inline'      => $inline,
            'object'      => $object
        ]);
    }
}
