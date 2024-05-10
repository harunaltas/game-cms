<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlayerUpdateRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $playerId = $this->player->id; // Eğer route model binding kullanıyorsanız
        return [
            'player_nick' => 'required|string|max:16|unique:players,player_nick,' . $playerId,
            'email' => 'required|string|email|max:26|unique:players,email,' . $playerId,
            'password' => 'nullable|string',
            'security_question' => 'required|string|max:255',
            'security_answer' => 'required|string|max:255',
        ];
    }
}
