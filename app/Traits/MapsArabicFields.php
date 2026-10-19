<?php

namespace App\Traits;

trait MapsArabicFields
{
    protected function prepareForValidation()
    {
        if (!method_exists($this, 'fieldsMapping')) {
            return;
        }

        $mapping = $this->fieldsMapping();
        $newInputs = [];

        foreach ($mapping as $arabicKey => $englishKey) {
            if ($this->has($arabicKey)) {
                $value = $this->file($arabicKey) ?: $this->input($arabicKey);
                
                $newInputs[$englishKey] = $value;

                $this->request->remove($arabicKey);
                $this->query->remove($arabicKey);
            }
        }

        $this->merge($newInputs);
    }

}
