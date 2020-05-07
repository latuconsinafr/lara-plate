<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class UserValidator.
 *
 * @package namespace App\Validators;
 */
class UserValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|string|max:180',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required|min:6|confirmed',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required|string|max:180',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'sometimes|required|min:6|confirmed',
        ],
    ];
}
