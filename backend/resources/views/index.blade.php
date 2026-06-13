@extends('master_dashboard')

@section('title', 'Dashboard')

@section('content-title')
    <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-home"></i>
    </span>
    Dashboard
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Overview</li>
@endsection

@section('content-body')
    @php
        $cards = [
            ['show' => $isAdmin, 'label' => 'Total Teachers', 'value' => $totalTeachers, 'detail' => 'Registered users', 'icon' => 'mdi-account-multiple', 'color' => 'danger'],
            ['show' => true, 'label' => 'Total Classes', 'value' => $totalCourses, 'detail' => 'Available classes', 'icon' => 'mdi-book-open-page-variant', 'color' => 'info'],
            ['show' => true, 'label' => 'Total Students', 'value' => $totalStudents, 'detail' => 'Enrolled students', 'icon' => 'mdi-school', 'color' => 'success'],
            ['show' => true, 'label' => 'Attendance Today', 'value' => $todayAttendance, 'detail' => $presentToday . ' marked present', 'icon' => 'mdi-calendar-check', 'color' => 'primary'],
        ];
    @endphp

    @foreach ($cards as $card)
        @if ($card['show'])
            <div class="col-md-6 col-xl-3 stretch-card grid-margin">
                <div class="card bg-gradient-{{ $card['color'] }} card-img-holder text-white">
                    <div class="card-body">
                        <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="">
                        <h4 class="font-weight-normal mb-3">
                            {{ $card['label'] }}
                            <i class="mdi {{ $card['icon'] }} mdi-24px float-end"></i>
                        </h4>
                        <h2 class="mb-4">{{ $card['value'] }}</h2>
                        <h6 class="card-text">{{ $card['detail'] }}</h6>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endsection
