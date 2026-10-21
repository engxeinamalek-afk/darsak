<?php

namespace App\Routing;

use App\Models\Scopes\PublishedCoursesScope;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Routing\Route;

class PolymorphicBinder
{
    public static function bind(
        string $paramName, 
        string $enumClass, 
        array $allowedTypes = [], 
        array $withoutGlobalScopes = []
    ) {
        return function ($value, Route $route) use ($paramName, $enumClass, $allowedTypes, $withoutGlobalScopes) {
            $typeString = $route->parameter($paramName . '_type');
            $enumType = $enumClass::tryFrom($typeString);

            if (! $enumType || (! empty($allowedTypes) && ! in_array($enumType, $allowedTypes, true))) {
                abort(422, "This resource cannot perform this action.");
            }

            $modelClass = Relation::getMorphedModel($enumType->value);
            $query = $modelClass::query();

            if (array_key_exists($enumType->value, $withoutGlobalScopes)) {
                $scopesToIgnore = $withoutGlobalScopes[$enumType->value];
                
                $query->withoutGlobalScopes($scopesToIgnore);
            }

            return $query->findOrFail($value);
        };
    }
}

