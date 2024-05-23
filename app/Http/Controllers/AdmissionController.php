<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdmissionRequest;
use App\Http\Requests\AdmissionUpdateRequest;
use App\Models\_Session;
use App\Models\Admission;
use App\Models\FeeDetails;
use App\Models\Fees;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdmissionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:admission-list|admission-create|admission-edit|admission-delete', ['only' => ['index','store']]);
        $this->middleware('permission:admission-create', ['only' => ['create']]);
        $this->middleware('permission:admission-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:admission-delete', ['only' => ['destroy']]);
        $this->middleware('permission:admission-confirm', ['only' => ['store']]);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            Fees::where('admission_id', $id)->delete();
            Student::where('admission_id', $id)->delete();
            Admission::where('id', $id)->delete();

            DB::commit();
            return redirect()->route('admission.index')
                ->with( 'success', 'Record deleted.....' );
        }
        catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('error',$exception->getMessage());
        }
    }

    public function update(AdmissionUpdateRequest $request, $id)
    {
        $data = $request->validated();

        //get session
        $session = _Session::where('status', 1)->first();

        if ($session == null){
            return redirect()->back()->with('error', 'No session created. please create session first.');
        }

        //save image
        $img = null;
        if ($request->id_proof !== null){
            $img = time().'.' . $request->id_proof->getClientOriginalExtension();
            \Image::make($request->id_proof)->save(public_path('uploads/students/').$img);
        }

        //update admission

        $admission = Admission::findOrFail($id);
        $admission->student_name = $request['student_name'];
        $admission->gender = $request['gender'];
        $admission->dob = $request['dob'];
        $admission->religion = $request['religion'];
        $admission->cast = $request['cast'];
        $admission->blood_group = $request['blood_group'];
        $admission->address = $request['address'];
        $admission->state = $request['state'];
        $admission->city = $request['city'];
        $admission->country = $request['country'];
        $admission->phone = $request['phone'];
        $admission->email = $request['email'];
        $admission->extra_note = $request['extra_note'];
        $admission->gr_no = $request['gr_no'];
        $admission->father_name = $request['father_name'];
        $admission->father_phone = $request['father_phone'];
        $admission->father_occ = $request['father_occ'];
        $admission->mother_name = $request['mother_name'];
        $admission->mother_phone = $request['mother_phone'];
        $admission->mother_occ = $request['mother_occ'];
        if ($img != null){
            $admission->student_pic = $img;
        }
        $admission->is_trans = $request['is_trans'];
        $admission->transport_id = $request['transportation'];
        $admission->__class_id = $request['selected_class'];
        $admission->__session_id = $session->id;
        $admission->user_id = Auth::user()->id;
        $admission->status = 'admitted';
        $admission->update();

        //update student
        $student = Student::where('admission_id', $id)->update([
            '__class_id' => $request['selected_class'],
            '__session_id' => $session->id,
            'name' => $request['student_name'],
        ]);

        //update fee
        $fee = Fees::where('admission_id', $id)->first();
        $feeDetails = FeeDetails::where('fee_id', $fee->id)->get();

        foreach ($feeDetails  as $fd){
            if ($fd->fee_type === 'admission'){
                $fd->fee_amount = $request['admission_fees'];
                $fd->update();
            }
            if ($fd->fee_type === 'tuition'){
                $fd->fee_amount = $request['tuition_fees'];
                $fd->update();
            }
            if ($fd->fee_type === 'transportation'){
                if ($admission->is_trans == 1 && $data['is_trans'] == 1){
                    $fd->fee_amount = $request['transportation_fees'];
                    $fd->update();
                }
                if ($admission->is_trans == 0 && $request['is_trans'] == 1){
                    FeeDetails::create([
                        'fee_id' => $fee->id,
                        'fee_type' => 'transportation',
                        'fee_amount' => $request['transportation_fees'],
                    ]);
                }
                if ($admission->is_trans == 1 && $request['is_trans'] == 0){
                    FeeDetails::where('fee_id', $fee->id)->where('fee_type', 'transportation')->delete();
                }
            }
        }

        //make login
        if ($request->is_login == 1){
            $user = User::create([
                'name' => $request->student_name,
                'email' => $request->email,
                'password' => Hash::make('student123'),
            ]);
            $role = Role::find(3);
            $user->assignRole([$role->id]);
            Admission::where('id', $id)->update([ 'student_auth_id' => $user->id ]);
            Fees::where('admission_id', $id)->update([ 'user_id' => $user->id ]);
        }

        // Update Login Email
        $user = User::find($admission->student_auth_id);
        if ($user) {
            // The user exists
            User::where('id', $admission->student_auth_id)->update(['email' => $admission->email]);
        }

        return redirect()->route('admission.index')
            ->with( 'success', 'Updated record ....' );
    }

    public function edit($id)
    {
        $data = Admission::findOrFail($id);
        $ad_fee = 0;
        $tt_fee = 0;
        $tp_fee = 0;
        foreach ($data->fees as $f){
            foreach ($f->feedetails as $fd){
                if ($fd->fee_type === 'admission'){
                    $ad_fee = $fd->fee_amount;
                }
                if ($fd->fee_type === 'tuition'){
                    $tt_fee = $fd->fee_amount;
                }
                if ($fd->fee_type === 'transportation'){
                    $tp_fee = $fd->fee_amount;
                }
            }
        }

        return view('admissions.edit', compact('data', 'ad_fee', 'tt_fee', 'tp_fee'));
    }

    public function create()
    {
        return view('admissions.create');
    }

    public function index()
    {
        $data = Admission::latest()->get();
        return view('admissions.index', compact('data'));
    }

    public function store(AdmissionRequest $request)
    {
        $data = $request->validated();

        
        //get session
        $session = _Session::where('status', 1)->first();
        
        if ($session == null){
            return redirect()->back()->with('error', 'No session created. please create session first.');
        }
        
        if ($request->hasFile('id_proof')) {
            $img = time().'.' . $request['id_proof']->getClientOriginalExtension();
            \Image::make($request['id_proof'])->save(public_path('uploads/students/').$img);
        }


        //save admission
        $admission = Admission::create([
            'gr_no' => $request['gr_no'],
            'student_name' => $request['student_name'],
            'student_email' => $request['student_email'],
            'student_gender' => $request['student_gender'],
            'student_phone' => $request['student_phone'],
            'student_dob' => $request['student_dob'],
            'student_address' => $request['student_address'],
            'student_nationality' => $request['student_nationality'],
            'student_religion' => $request['student_religion'],
            'student_last_school_attend' => $request['student_last_school_attend'],
            'student_admission_date' => $request['student_admission_date'],
            'student_state' => $request['student_state'],
            'student_city' => $request['student_city'],
            'student_country' => $request['student_country'],
            'student_pic' => $img,
            'father_name' => $request['father_name'],
            'father_occupation' => $request['father_occupation'],
            'father_office_address' => $request['father_office_address'],
            'father_contact' => $request['father_contact'],
            'guardian_name' => $request['guardian_name'],
            'guardian_occupation' => $request['guardian_occupation'],
            'guardian_office_address' => $request['guardian_office_address'],
            'guardian_contact' => $request['guardian_contact'],
            'mother_name' => $request['mother_name'],
            'mother_contact' => $request['mother_contact'],
            'transport_id' => $request['transport_id'],
            '__class_id' => $request['selected_class'],
            '__session_id' => $session->id,
            'user_id' => Auth::user()->id,
            'status' => 'pending',
            'extra_note' => $request['extra_note'],
        ]);

        //save student
        $student = Student::create([
            'admission_id' => $admission->id,
            '__class_id' => $request['selected_class'],
            '__session_id' => $session->id,
            'roll_no' => $request['roll_no'],
            'name' => $request['student_name'],
        ]);

        //create fee
        $fee_types = ['admission', 'tuition', 'transportation'];
        $trans = $request['is_trans'] == 1 ? $request['transportation_fees'] : 0;
        $total = $trans + (int)$request['admission_fees'] + (int)$request['tuition_fees'];


        $fee = Fees::create([
            'admission_id' => $admission->id,
            '__session_id' => $session->id,
            'student_id' => $student->id,
            'month_of' => Carbon::now()->format('M-Y'),
            'due_date' => Carbon::now()->addDays(10),
            'total' => $total,
        ]);
        $amount = 0;
        foreach ($fee_types as $type){
            if ($type == 'admission') {
                $amount = $request['admission_fees'];
            }
            if ($type == 'tuition') {
                $amount = $request['tuition_fees'];
            }
            if ($type == 'transportation') {
                if ($request['is_trans'] == 1){
                    $amount = $request['transportation_fees'];
                }
            }
            if ($amount > 0){
                FeeDetails::create([
                    'fee_id' => $fee->id,
                    'fee_type' => $type,
                    'fee_amount' => $amount,
                ]);
            }
        }

        //create login
        if ($request->is_login == 1){
            $user = User::create([
                'name' => $request->student_name,
                'email' => $request->email,
                'password' => Hash::make('student123'),
            ]);
            $role = Role::find(3);
            $user->assignRole([$role->id]);
            Admission::where('id', $admission->id)->update([ 'student_auth_id' => $user->id ]);
            Fees::where('admission_id', $admission->id)->update([ 'user_id' => $user->id ]);
        }

        return redirect()->back()
            ->with( 'success', 'Student admission successfull....' );
    }
}