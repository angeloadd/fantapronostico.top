<?php

declare(strict_types=1);

namespace App\Http\Auth\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class RegisterRequest extends FormRequest
{
    use PasswordValidationRules;

    public const NAME = 'name';

    public const EMAIL = 'email';

    public const PASSWORD = 'password';

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            self::NAME => ['required', 'string', 'max:255'],
            self::EMAIL => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            self::PASSWORD => $this->passwordRules(),
        ];
    }

    public function email(): string
    {
        return $this->string(self::EMAIL)->toString();
    }

    public function name(): string
    {
        return $this->string(self::NAME)->toString();
    }

    public function password(): string
    {
        return $this->string(self::PASSWORD)->toString();
    }
}
