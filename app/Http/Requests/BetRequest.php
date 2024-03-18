<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class BetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'home_result' => 'required|integer|numeric',
            'away_result' => 'required|integer|numeric',
            'sign' => 'required',
            'homeScore' => 'required',
            'awayScore' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'home_result.required' => 'Il campo è richiesto.',
            'home_result.integer' => 'Il campo deve essere numerico',
            'home_result.numeric' => 'Il campo deve essere numerico.',
            'away_result.required' => 'Il campo è richiesto.',
            'away_result.integer' => 'Il campo deve essere numerico',
            'away_result.numeric' => 'Il campo deve essere numerico',
            'sign.required' => 'Il campo è richiesto',
            'homeScore.required' => 'Il campo è richiesto',
            'awayScore.required' => 'Il campo è richiesto',
        ];
    }
}
