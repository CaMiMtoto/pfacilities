<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('dist/img/moh.jpg') }}" style="height: 40px;width: 40px" class="img-circle"
                     alt="User Image">
            </div>
            <div class="pull-left info">
                <p> {{ Auth::user()->name }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Menus</li>
            <!-- Optionally, you can add icons to the links -->
            @if(Auth::user()->role!='normal')
                <li class="nav-dashboard">
                    <a href="{{ url('/dashboard') }}">
                        <i class="fa fa-link"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            @endif
            <li class="nav-facilities">
                <a href=" {{ Auth::user()->role=='normal'? route('facilities'):route('adminFacilities') }}">
                    <i class="fa fa-heart"></i>
                    <span>Health Facilities</span>
                </a>
            </li>
            <li class="nav-applications">
                <a href="{{ route('userApplication') }}">
                    <i class="fa fa-file-archive-o"></i>
                    <span>Applications</span>
                </a>
            </li>
     {{--       <li class="nav-appointments">
                <a href="{{ route('appointments') }}">
                    <i class="fa fa-clock-o"></i>
                    <span>Appointments</span>
                </a>
            </li>--}}
            @if(Auth::user()->role!='normal')
                <li class="nav-shared-applications">
                    <a href="{{ route('my.shared.app.all') }}">
                        <i class="fa fa-file-o"></i>
                        <span>For Approval</span>
                    </a>
                </li>
            @endif
            @if(\Illuminate\Support\Facades\Auth::user()->role=='admin')
                <li class="nav-users">
                    <a href="{{ route('users') }}">
                        <i class="fa fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li class="nav-employees">
                    <a href="{{ route('employees.all') }}">
                        <i class="fa fa-list"></i>
                        <span>Employees</span>
                    </a>
                </li>
            @endif

            @if(Auth::user()->role!='normal')
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-link"></i>
                        <span>Settings</span>
                        <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu ">
                        @if(Auth::user()->role=='admin')
                            <li class="nav-positions ">
                                <a href="{{ route('positions.all') }}">
                                    <i class="fa fa-circle"></i>
                                    <span>Positions</span>
                                </a>
                            </li>
                            <li class="nav-employee-positions ">
                                <a href="{{ route('employeePositions.all') }}">
                                    <i class="fa fa-circle"></i>
                                    <span>Employee Position</span>
                                </a>
                            </li>
                            <li class="nav-categories">
                                <a href="{{ route('categories.all') }}">
                                    <i class="fa fa-circle"></i>
                                    <span>Categories</span>
                                </a>
                            </li>
                            <li class="nav-services">
                                <a href="{{ route('services.all') }}">
                                    <i class="fa fa-circle"></i>
                                    <span>Services</span>
                                </a>
                            </li>
                            <li class="nav-services">
                                <a href="{{ route('documents.all') }}">
                                    <i class="fa fa-circle"></i>
                                    <span>Documents</span>
                                </a>
                            </li>
                            <li class="nav-services">
                                <a href="{{ route('app-types.all') }}">
                                    <i class="fa fa-circle"></i>
                                    <span>Application Types</span>
                                </a>
                            </li>

                        @endif

                    </ul>
                </li>
            @endif
            @if(Auth::user()->role=='admin')
                <li class="treeview tr-reports">
                    <a href="#">
                        <i class="fa fa-print"></i> <span>Report</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="mn-summary">
                            <a href="{{ route('summary') }}">
                                <i class="fa fa-circle"></i>
                                Facilities Summary
                            </a>
                        </li>
                        <li class="mn-expiring">
                            <a href="{{ route('expiring') }}">
                                <i class="fa fa-circle"></i>
                                Expiring Facilities
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
