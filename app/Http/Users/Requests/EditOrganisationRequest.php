<?php

namespace App\Http\Users\Requests;

use App\Http\Users\Models\User;
use Dingo\Api\Http\FormRequest;

class EditOrganisationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $id = $this->route('organisation');

        $organisation = User::find(auth()->user()->id)
            ->administrated_organisations()
            ->where('organisation_id', $id)
            ->get();

        return !$organisation->isEmpty();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required'
        ];
    }
}