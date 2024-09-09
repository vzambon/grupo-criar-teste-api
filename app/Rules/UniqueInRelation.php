<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueInRelation implements ValidationRule
{
    public function __construct(
        protected readonly string $modelClass,
        protected readonly string $relationship,
        protected readonly array|string $foreign_id,
    )
    {
    }

    public static function make($modelClass, $relationship, $foreign_id)
    {
        return new self($modelClass, $relationship, $foreign_id);
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if($this->modelClass::whereHas($this->relationship, function ($query) use ($value) {
            $query->where($this->foreign_id, $value);
        })->exists()) {
            $fail("{$this->modelClass}({$value}) Must belong to only one ". $this->relationship);
        }
    }
}
