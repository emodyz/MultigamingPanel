<?php

namespace App\Http\Requests\ModPacks;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditModPackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('modpack-edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      $modpack = $this->route('modpack');

      return [
        'name' => [
          'required',
          Rule::unique('modpacks', 'name')->ignore($modpack->id)
        ],

        'servers' => ['array'],
        'servers.*' => ['exists:servers,id'],

        'path' => [
          'nullable',
          Rule::unique('modpacks', 'path')->ignore($modpack->id)
        ],
        'disk' => ['nullable']
      ];
    }
}
