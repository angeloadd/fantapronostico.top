<?php

declare(strict_types=1);

namespace App\Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class LoginRequest extends FormRequest
{
    public const EMAIL = 'email';

    public const PASSWORD = 'password';

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, string[]>>
     */
    public function rules(): array
    {
        return [
            self::EMAIL => ['required', 'string'],
            self::PASSWORD => ['required', 'string'],
        ];
    }

    public function email(): string
    {
        return $this->string(self::EMAIL)->toString();
    }

    public function password(): string
    {
        return $this->string(self::PASSWORD)->toString();
    }
}
