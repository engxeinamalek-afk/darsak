<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UrlRule implements ValidationRule
{
 public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            $fail('حقل الرابط يجب أن يكون رابطاً إلكترونياً صحيحاً.');
            return;
        }

        $host = strtolower(parse_url($value, PHP_URL_HOST));

        $allowedDomains = [
            'youtube.com',
            'www.youtube.com',
            'm.youtube.com', 
            'youtu.be',     
            'vimeo.com',
            'player.vimeo.com'
        ];

        if (!in_array($host, $allowedDomains)) {
            $fail('يجب أن يكون الرابط تابعاً لمنصة يوتيوب (YouTube) أو فيميو (Vimeo) فقط.');
        }
    }


}
