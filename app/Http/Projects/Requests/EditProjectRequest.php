<?php

namespace App\Http\Projects\Requests;

use App\Http\Users\Models\User;
use Dingo\Api\Http\FormRequest;

class EditProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $id = $this->route('project');

        $project = User::find(auth()->user()->id)
            ->projects()
            ->where('project_id', $id)
            ->get();

        return !$project->isEmpty();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required'
        ];
    }
}