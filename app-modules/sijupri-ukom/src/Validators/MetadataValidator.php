<?php

namespace Eyegil\SijupriUkom\Validators;

use Eyegil\Base\Exceptions\BusinessException;

class MetadataValidator
{

    public static function validateCatMetadata($metadata)
    {
        $validatedMetadata = [];

        if (!isset($metadata['choices']) || !is_array($metadata['choices'])) {
            throw new BusinessException("Invalid format: 'choices' is required and must be an array.", "VAL-0002");
        }

        $choices = $metadata['choices'];
        $requiredKeys = range('a', 'd');
        $validKeys = range('a', 'z');

        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $choices)) {
                throw new BusinessException("Invalid format: 'choices' must contain at least keys A to D.", "VAL-0002");
            }
        }

        $keys = array_keys($choices);
        sort($keys);

        if ($keys !== range('a', end($keys))) {
            throw new BusinessException("Invalid format: 'choices' keys must be sorted and contiguous.", "VAL-0002");
        }

        $validatedMetadata['choices'] = array_intersect_key($choices, array_flip($validKeys));

        if (isset($metadata['attachment'])) {
            $validatedMetadata['attachment'] = $metadata['attachment'];
        }

        return $validatedMetadata;
    }

}
