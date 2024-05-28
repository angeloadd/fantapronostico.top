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
            'home_score' => 'required|integer|numeric',
            'away_score' => 'required|integer|numeric',
            'sign' => 'required',
            'home_scorer_id' => 'required',
            'away_scorer_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'home_score.required' => 'Il campo è richiesto.',
            'home_score.integer' => 'Il campo deve essere numerico',
            'home_score.numeric' => 'Il campo deve essere numerico.',
            'away_score.required' => 'Il campo è richiesto.',
            'away_score.integer' => 'Il campo deve essere numerico',
            'away_score.numeric' => 'Il campo deve essere numerico',
            'sign.required' => 'Il campo è richiesto',
            'home_scorer_id.required' => 'Il campo è richiesto',
            'away_scorer_id.required' => 'Il campo è richiesto',
        ];
    }
}
