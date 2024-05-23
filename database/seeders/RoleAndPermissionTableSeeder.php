<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleAndPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'Roles' => [
                'role-list',
                'role-create',
                'role-edit',
                'role-delete',
            ],
            'Departments' => [
                'department-list',
                'department-create',
                'department-edit',
                'department-delete',
            ],
            'Users' => [
                'user-list',
                'user-create',
                'user-edit',
                'user-delete',
            ],
            'Sections' => [
                'section-list',
                'section-create',
                'section-edit',
                'section-delete',
            ],
            'Classes' => [
                'class-list',
                'class-create',
                'class-edit',
                'class-delete',
            ],
            'Students' => [
                'student-list',
                'student-create',
                'student-edit',
                'student-delete',
                'student-view-my-account',
            ],
            'Transport' => [
                'transport-list',
                'transport-create',
                'transport-edit',
                'transport-delete',
            ],
            'Transport Routes' => [
                'troute-list',
                'troute-create',
                'troute-edit',
                'troute-delete',
            ],
            'Sessions' => [
                'session-list',
                'session-create',
                'session-edit',
                'session-delete',
            ],
            'Admissions' => [
                'admission-confirm',
                'admission-list',
                'admission-create',
                'admission-edit',
                'admission-delete',
            ],
            'Transfer' => [
                'transfer-list',
                'transfer-create',
                'transfer-edit',
                'transfer-delete',
            ],
            'Teachers' => [
                'teacher-list',
                'teacher-create',
                'teacher-edit',
                'teacher-delete',
            ],
            'Staff' => [
                'staff-list',
                'staff-create',
                'staff-edit',
                'staff-delete',
            ],
            'Subjects' => [
                'subject-list',
                'subject-create',
                'subject-edit',
                'subject-delete',
            ],
            'Fees' => [
                'fee-list',
                'fee-create',
                'fee-edit',
                'fee-delete',
            ],
            'Student Attendance' => [
                's_att-list',
                's_att-create',
                's_att-edit',
                's_att-delete',
            ],
            'Staff Attendance' => [
                'st_atd-list',
                'st_atd-create',
                'st_atd-edit',
                'st_atd-delete',
            ],
            'Salary' => [
                'salary-list',
                'salary-create',
                'salary-edit',
                'salary-delete',
            ],
            'Expenses' => [
                'expense-list',
                'expense-create',
                'expense-edit',
                'expense-delete',
            ],
            'Notices' => [
                'notice-list',
                'notice-create',
                'notice-edit',
                'notice-delete',
            ],
            'Results' => [
                'result-list',
                'result-create',
                'result-edit',
                'result-delete',
            ],
            'Staff Leave' => [
                'staff-leave-list',
                'staff-leave-create',
                'staff-leave-edit',
                'staff-leave-delete',
            ],
            'Student Leave' => [
                'student-leave-list',
                'student-leave-create',
                'student-leave-edit',
                'student-leave-delete',
            ],
            'Live Classes' => [
                'live-class-list',
                'live-class-create',
                'live-class-edit',
                'live-class-delete',
            ],
            'Study Materials' => [
                'study-material-list',
                'study-material-create',
                'study-material-edit',
                'study-material-delete',
            ],
            'Timetable' => [
                'time-table-list',
                'time-table-create',
                'time-table-edit',
                'time-table-delete',
            ],
            'Student Promote' => [
                'promote-list',
                'promote-create',
                'promote-edit',
                'promote-delete',
            ],
            'Gate Pass' => [
                'gate-pass-list',
                'gate-pass-create',
                'gate-pass-edit',
                'gate-pass-delete',
            ],
            'System Settings' => [
                'settings-list',
                'settings-create',
                'settings-edit',
                'settings-delete',
            ],
            'No Permission' => [
                'no-user',
            ],
        ];

        foreach ($permissions as $category => $permissionsList) {  
            // Create each permission for this category
            foreach ($permissionsList as $permission) {
                Permission::create(['name' => $permission, 'category' => $category]);
            }
        }
        

        $adminRole = Role::create(['name' => 'admin']);
        $tecaherRole = Role::create(['name' => 'teacher']);
        $studentRole = Role::create(['name' => 'student']);

        $tecaherRole->givePermissionTo(['class-list','student-list', 'subject-list','s_att-list','s_att-create','s_att-edit','s_att-delete','st_atd-list','result-list','result-create','result-edit','result-delete','staff-leave-list','staff-leave-create','staff-leave-edit','staff-leave-delete','student-leave-list','student-leave-edit','live-class-list','live-class-create','live-class-edit','live-class-delete','study-material-list','study-material-create','study-material-edit','study-material-delete','time-table-list']);
        $studentRole->givePermissionTo(['fee-list','s_att-list','result-list','student-leave-list','student-leave-create','student-leave-edit','student-leave-delete','live-class-list','study-material-list','time-table-list']);
    }
}
