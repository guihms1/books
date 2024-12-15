<?php

namespace App\Validators;

use App\Exceptions\ValidationException;
use App\Validators\Interfaces\IValidator;
use Illuminate\Support\Facades\Validator;

abstract class AbstractValidator implements IValidator
{
    protected array $attributes = [];
    protected array $rules = [];
    protected array $messages = [];

    public function validate($data): array
    {
        $validator = Validator::make($data, $this->rules, $this->messages, $this->attributes);

        if ($validator->fails()) {
            throw new ValidationException($validator->messages()->all());
        }

        return $validator->validated();
    }
}
