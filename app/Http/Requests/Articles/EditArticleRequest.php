<?php

namespace App\Http\Requests\Articles;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('articles-edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $article = $this->route('article');
        return [
            'title' => ['required', 'string', 'max:80', Rule::unique('articles')->ignore($article->id)],
            'subTitle' => ['nullable', 'string', 'max:256'],
            'servers.*' => ['nullable', 'uuid', 'exists:servers,id'],
            'status' => ['nullable', 'string', Rule::in(['draft', 'published'])],
            'coverImage' => ['nullable', 'file', 'image', 'max:8192'],
            'content' => ['required', 'string', 'max:4294967294'],
        ];
    }
}
