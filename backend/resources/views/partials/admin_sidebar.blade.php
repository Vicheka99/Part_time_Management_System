@php
    $menus = [
        ['label' => 'Students', 'icon' => 'mdi-account-multiple-outline', 'url' => route('index.student'), 'paths' => ['student/index', 'student/create', 'student/update/*', 'admin/student-add', 'admin/student-attendance']],
        ['label' => 'Teachers', 'icon' => 'mdi-account-outline', 'url' => route('index.user'), 'paths' => ['user/index', 'user/create', 'user/update/*', 'admin/teacher-classes']],
        ['label' => 'Classes', 'icon' => 'mdi-book-open-variant', 'url' => route('index.course'), 'paths' => ['course/index', 'course/create', 'course/update/*', 'admin/class-schedule', 'admin/class-students']],
        ['label' => 'Attendance', 'icon' => 'mdi-calendar-check-outline', 'url' => route('admin.page', 'attendance-take'), 'paths' => ['admin/attendance-take', 'admin/attendance-records']],
        ['label' => 'Subjects', 'icon' => 'mdi-book-outline', 'url' => route('admin.page', 'subject-list'), 'paths' => ['admin/subject-list', 'admin/subject-assign']],
        ['label' => 'Reports', 'icon' => 'mdi-chart-bar', 'url' => route('admin.page', 'attendance-summary'), 'paths' => ['admin/attendance-reports', 'admin/attendance-summary', 'admin/student-performance']],
        ['label' => 'Settings', 'icon' => 'mdi-cog-outline', 'url' => route('admin.page', 'settings'), 'paths' => ['admin/settings', 'admin/user-management', 'admin/profile']],
    ];
@endphp
<ul class="nav admin-nav" data-custom-sidebar="true">
    <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="mdi mdi-view-grid-outline menu-icon"></i>
            <span class="menu-title">Dashboard</span>
        </a>
    </li>
    @foreach ($menus as $menu)
        <li class="nav-item {{ request()->is($menu['paths']) ? 'active' : '' }}">
            <a class="nav-link" href="{{ $menu['url'] }}">
                <i class="mdi {{ $menu['icon'] }} menu-icon"></i>
                <span class="menu-title">{{ $menu['label'] }}</span>
            </a>
        </li>
    @endforeach
</ul>
