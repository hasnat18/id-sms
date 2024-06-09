<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "gr_no" => "required|unique:admissions,gr_no|string|max:255",
            "student_name" => "required|string|max:255",
            "student_email" => "nullable|email|max:255",
            "student_gender" => "required|string|max:10",
            "student_phone" => "nullable|string|max:20",
            "student_dob" => "required|date",
            "student_address" => "required|string|max:255",
            "student_nationality" => "required|string|max:100",
            "student_religion" => "required|string|max:100",
            "student_last_school_attend" => "nullable|string|max:255",
            "student_admission_date" => "nullable|date",
            "student_state" => "required|string|max:100",
            "student_city" => "required|string|max:100",
            "student_country" => "required|string|max:100",
            "id_proof" => "required|image|mimes:jpeg,png,jpg,gif,webp|max:2048",
            "father_name" => "nullable|string|max:255",
            "father_occupation" => "nullable|string|max:255",
            "father_office_address" => "nullable|string|max:255",
            "father_contact" => "nullable|string|max:20",
            "guardian_name" => "nullable|string|max:255",
            "guardian_occupation" => "nullable|string|max:255",
            "guardian_office_address" => "nullable|string|max:255",
            "guardian_contact" => "nullable|string|max:20",
            "mother_name" => "nullable|string|max:255",
            "mother_contact" => "nullable|string|max:20",
            "transport_id" => "nullable|integer",
            "extra_note" => "nullable|string|max:1000",
        ];
    }
}