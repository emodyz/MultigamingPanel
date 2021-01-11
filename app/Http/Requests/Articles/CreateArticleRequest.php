<?php

namespace App\Http\Requests\Articles;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('articles-create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:80', 'unique:articles'],
            'subTitle' => ['nullable', 'string', 'max:256'],
            'servers.*' => ['nullable', 'uuid', 'exists:servers,id'],
            'status' => ['nullable', 'string', Rule::in(['draft', 'published'])],
            'coverImage' => ['required', 'file', 'image', 'max:8192'],
            'content' => ['required', 'string'],
        ];
    }
}
