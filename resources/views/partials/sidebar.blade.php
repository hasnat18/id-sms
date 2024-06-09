<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="user-pro"> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                        aria-expanded="false">
                        <img src="{{ asset('assets/images/users/1.jpg') }}" alt="user-img" class="img-circle">
                        <span class="hide-menu">{{ Auth::user()->name }}</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <a href="{{ route('users.profile') }}">
                                <i class="fa mdi-face-profile"></i> Profile
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                                <i class="fa fa-power-off"></i> Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('home') }}">
                        <i class="ti-dashboard"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>


                @canany('student-list', 'reg-list', 'admission-list', 'transfer-list', 'promote-list', 's_att-list',
                    'student-leave-list')
                    <li>
                        <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="ti-user"></i>
                            <span class="hide-menu">Students Module</span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            @can('student-list')
                                <li>
                                    <a href="{{ route('students.index') }}">All Students</a>
                                </li>
                            @endcan
                            <li>
                                @canany('admission-list', 'admission-create')
                                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                        aria-expanded="false">
                                        <span class="hide-menu">Admissions</span>
                                    </a>
                                @endcanany
                                <ul aria-expanded="false" class="collapse">
                                    <li>
                                        @can('admission-list')
                                            <a href="{{ route('admission.index') }}">All Admissions</a>
                                        @endcan
                                        @can('admission-create')
                                            <a href="{{ route('admission.create') }}">Create Admission</a>
                                        @endcan
                                    </li>
                                </ul>
                            </li>
                            <li>
                                @canany('transfer-list', 'transfer-create')
                                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                        aria-expanded="false">
                                        <span class="hide-menu">Transfers</span>
                                    </a>
                                @endcanany
                                <ul aria-expanded="false" class="collapse">
                                    @can('transfer-list')
                                        <a href="{{ route('transfers.index') }}">All Transfers</a>
                                    @endcan
                                    @can('transfer-create')
                                        <a href="{{ route('transfers.create') }}">Create Transfers</a>
                                    @endcan
                                </ul>
                            </li>
                            <li>
                                @canany('promote-list', 'promote-create')
                                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                        aria-expanded="false">
                                        <span class="hide-menu">Promote Students</span>
                                    </a>
                                @endcanany
                                <ul aria-expanded="false" class="collapse">
                                    @can('promote-list')
                                        <a href="{{ route('promotes.index') }}">View Promote Students</a>
                                    @endcan
                                    @can('promote-create')
                                        <a href="{{ route('promotes.create') }}">Create Promote Students</a>
                                    @endcan
                                </ul>
                            </li>
                            <li>
                                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <span class="hide-menu">Attendance</span>
                                </a>
                                <ul aria-expanded="false" class="collapse">
                                    @can('s_att-list')
                                        <a href="{{ route('s_atd.list') }}">View Attendance</a>
                                    @endcan
                                    @can('s_att-create')
                                        <a href="{{ route('s_atd.create') }}">Add Attendance</a>
                                    @endcan
                                </ul>
                            </li>
                            <li>
                                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <span class="hide-menu">Student Leaves</span>
                                </a>
                                <ul aria-expanded="false" class="collapse">
                                    @can('student-leave-list')
                                        <a href="{{ route('student-leaves.index') }}">View Student Leaves</a>
                                    @endcan
                                    @can('student-leave-create')
                                        <a href="{{ route('student-leaves.create') }}">Create Student Leave</a>
                                    @endcan
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endcanany


                @canany('staff-list', 'staff-create', 'st_atd-list', 'st_atd-create', 'salary-list', 'salary-create',
                    'staff-leave-list', 'staff-leave-create')
                    <li>
                        <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="ti-user"></i>
                            <span class="hide-menu">Staffs Module</span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            <li>
                                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <span class="hide-menu">Staffs</span>
                                </a>
                                <ul aria-expanded="false" class="collapse">
                                    <a href="{{ route('staffs.index') }}">All Staffs</a>
                                    @can('staff-create')
                                        <a href="{{ route('staffs.create') }}">Create Staff</a>
                                    @endcan
                                </ul>
                            </li>
                            @can('st_atd-list')
                                <li>
                                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                        aria-expanded="false">
                                        <span class="hide-menu">Staffs Attendance</span>
                                    </a>
                                    <ul aria-expanded="false" class="collapse">
                                        <a href="{{ route('staff-attendance.index') }}">View Attendance</a>
                                        @can('st_atd-create')
                                            <a href="{{ route('staff-attendance.create') }}">Create Attendance</a>
                                        @endcan
                                    </ul>
                                </li>
                            @endcan
                            @can('salary-list')
                                <li>
                                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                        aria-expanded="false">
                                        <span class="hide-menu">Staffs Salary</span>
                                    </a>

                                    <ul aria-expanded="false" class="collapse">
                                        <a href="{{ route('salaries.index') }}">View Staff Salary</a>
                                        @can('salary-create')
                                            <a href="{{ route('salaries.create') }}">Create Staff Salary</a>
                                        @endcan
                                    </ul>
                                </li>
                            @endcanany

                            @can('staff-leave-list')
                                <li>
                                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                        aria-expanded="false">
                                        <span class="hide-menu">Staffs Leaves</span>
                                    </a>
                                    <ul aria-expanded="false" class="collapse">
                                        <a href="{{ route('staff-leaves.index') }}">View Staff Leaves</a>
                                        @can('staff-leave-create')
                                            <a href="{{ route('staff-leaves.create') }}">Create Staff Leave</a>
                                        @endcan
                                    </ul>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @canany('class-list', 'class-create', 'subject-list', 'subject-create')
                    <li>
                        <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="ti-panel"></i>
                            <span class="hide-menu">Classes Module</span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            <li>
                                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <span class="hide-menu">Classes</span>
                                </a>
                                <ul aria-expanded="false" class="collapse">
                                    <a href="{{ route('classes.index') }}">View Classes</a>
                                    @can('class-create')
                                        <a href="{{ route('classes.create') }}">Create Class</a>
                                    @endcan
                                </ul>
                            </li>
                            <li>
                                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <span class="hide-menu">Sections</span>
                                </a>
                                <ul aria-expanded="false" class="collapse">
                                    <a href="{{ route('sections.index') }}">View Sections</a>
                                    @can('class-create')
                                        <a href="{{ route('sections.create') }}">Create Section</a>
                                    @endcan
                                </ul>
                            </li>
                            <li>
                                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <span class="hide-menu">Subjects</span>
                                </a>
                                <ul aria-expanded="false" class="collapse">
                                    <a href="{{ route('subjects.index') }}">View Subjects</a>
                                    @can('subject-create')
                                        <a href="{{ route('subjects.create') }}">Create Subjects</a>
                                    @endcan
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endcanany
                @canany('study-material-list', 'study-material-create', 'live-class-list', 'live-class-create',
                    'subject-list', 'subject-create', 'subject-delete', 'subject-edit')
                    <li>
                        <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="ti-book"></i>
                            <span class="hide-menu">Study Material Module</span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            <li>
                                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <span class="hide-menu">Study Material</span>
                                </a>
                                <ul aria-expanded="false" class="collapse">
                                    <a href="{{ route('study-materials.index') }}">View Study Material</a>
                                    @can('study-material-create')
                                        <a href="{{ route('study-materials.create') }}">Create Study Material</a>
                                    @endcan
                                </ul>
                            </li>
                            <li>

                                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <span class="hide-menu">Live Classes</span>
                                </a>
                                <ul aria-expanded="false" class="collapse">
                                    <a href="{{ route('live-classes.index') }}">View Live Classes</a>
                                    @can('live-class-create')
                                        <a href="{{ route('live-classes.create') }}">Create Live Classes</a>
                                    @endcan
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endcanany

                @canany('transport-list', 'transport-create', 'troute-list', 'troute-create')
                    <li>
                        <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="ti-truck"></i>
                            <span class="hide-menu">Transports Module</span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            <li>
                                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <span class="hide-menu">Transports</span>
                                </a>
                                <ul aria-expanded="false" class="collapse">
                                    <a href="{{ route('transports.index') }}">All Transports</a>
                                    @can('transport-create')
                                        <a href="{{ route('transports.create') }}">Create Transport</a>
                                    @endcan
                                </ul>
                            </li>

                            @can('troute-list')
                                <li>
                                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                        aria-expanded="false">
                                        <span class="hide-menu">Transports Routes</span>
                                    </a>
                                    <ul aria-expanded="false" class="collapse">
                                        <a href="{{ route('transport-routes.index') }}">All Routes</a>
                                        @can('troute-create')
                                            <a href="{{ route('transport-routes.create') }}">Create Route</a>
                                        @endcan
                                    </ul>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany

                @can('teacher-list')
                    <li>
                        <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="ti-menu"></i>
                            <span class="hide-menu">Teachers</span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            <li>
                                <a href="{{ route('teachers.index') }}">All Teachers</a>
                            </li>
                            <li>
                                <a href="{{ route('teachers.create') }}">Create Teacher</a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('session-list')
                    <li>
                        <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="ti-bookmark-alt"></i>
                            <span class="hide-menu">Sessions</span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            <li>
                                <a href="{{ route('yearly-session.index') }}">All Sessions</a>
                                @can('session-create')
                                    <a href="{{ route('yearly-session.create') }}">Create Sessions</a>
                                @endcan
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('fee-list')
                    <li>
                        <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="ti-receipt"></i>
                            <span class="hide-menu">Fees</span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            <li>
                                <a href="{{ route('fees.index') }}">All Fees</a>
                                @can('fee-create')
                                    <a href="{{ route('fees.create') }}">Create Fee</a>
                                @endcan
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('result-list')
                    <li>
                        <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="ti-write"></i>
                            <span class="hide-menu">Exam Result</span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            <li>
                                <!--<a href="{{ route('results.index') }}">View Result</a>-->
                                @can('result-create')
                                    <a href="{{ route('results.create') }}">Create Result</a>
                                @endcan
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('time-table-list')
                    <li>
                        <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="ti-calendar"></i>
                            <span class="hide-menu">Time Tables</span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            <li>
                                <a href="{{ route('time-tables.index') }}">View Time Tables</a>
                                @can('time-table-create')
                                    <a href="{{ route('time-tables.create') }}">Create Time Tables</a>
                                @endcan
                            </li>
                        </ul>
                    </li>
                @endcan

                @canany(['role-list', 'department-list', 'notice-list', 'expense-list', 'gate-pass-list'])
                    <li>
                        @canany('role-list', 'department-list', 'notice-list', 'expense-list', 'gate-pass-list')
                            <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <i class="ti-settings"></i>
                                <span class="hide-menu">System Module</span>
                            </a>
                        @endcanany
                        <ul aria-expanded="false" class="collapse">
                            <li>
                                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <span class="hide-menu">Settings</span>
                                </a>
                                <ul aria-expanded="false" class="collapse">
                                    @can('settings-list')
                                        <a href="{{ route('settings.index') }}">Settings</a>
                                    @endcan
                                </ul>
                            </li>
                            <li>
                                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <span class="hide-menu">Roles</span>
                                </a>
                                <ul aria-expanded="false" class="collapse">
                                    @can('role-list')
                                        <a href="{{ route('roles.index') }}">All Roles</a>
                                    @endcan
                                    @can('role-create')
                                        <a href="{{ route('roles.create') }}">Create Role</a>
                                    @endcan
                                </ul>
                            </li>
                            <li>
                                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <span class="hide-menu">Departments</span>
                                </a>
                                <ul aria-expanded="false" class="collapse">
                                    @can('department-list')
                                        <a href="{{ route('departments.index') }}">All Department</a>
                                    @endcan
                                    @can('department-create')
                                        <a href="{{ route('departments.create') }}">Create Department</a>
                                    @endcan
                                </ul>
                            </li>
                            <li>
                                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <span class="hide-menu">Notices</span>
                                </a>
                                <ul aria-expanded="false" class="collapse">
                                    @can('notice-list')
                                        <a href="{{ route('notices.index') }}">View Notices</a>
                                    @endcan
                                    @can('notice-create')
                                        <a href="{{ route('notices.create') }}">Create Notice</a>
                                    @endcan
                                </ul>
                            </li>
                            <li>
                                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <span class="hide-menu">Expenses</span>
                                </a>
                                <ul aria-expanded="false" class="collapse">
                                    <li>
                                        <a href="{{ route('expenses.index') }}">View Expenses</a>
                                        @can('expense-create')
                                            <a href="{{ route('expenses.create') }}">Create Expenses</a>
                                        @endcan
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <span class="hide-menu">Gate Pass</span>
                                </a>
                                <ul aria-expanded="false" class="collapse">
                                    <li>
                                        <a href="{{ route('gate-pass.index') }}">View Gate Pass</a>
                                        @can('gate-pass-create')
                                            <a href="{{ route('gate-pass.create') }}">Create Gate Pass</a>
                                        @endcan
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endcanany

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
