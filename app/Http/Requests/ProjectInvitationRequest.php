<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ProjectInvitationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('manage', $this->route('project'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $project = $this->route('project');

        $members_email = $project->members->pluck('email')->push($project->owner->email)->toArray();

        return [
            'email' => ['required', 'exists:users,email', Rule::notIn($members_email)]
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        $project = $this->route('project');
        $username = request('email') === $project->owner->email ? __('projects.activity.self_ownership') : request('email');

        return [
            'email.exists' => __('projects.invitation.no_user'),
            'email.not_in' => __('projects.invitation.already_in', ['user' => $username]),
        ];
    }
}
