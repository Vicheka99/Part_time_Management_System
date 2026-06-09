@extends('master_dashboard')
@section('title')
    Dashboard
@endsection

@section('content-title')
<span class="page-title-icon bg-gradient-primary text-white me-2">
    <i class="mdi mdi-home"></i>
  </span> Dashboard
@endsection

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">
    <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
  </li>
@endsection

@section('content-body')
@if($isAdmin)
<div class="col-md-4 stretch-card grid-margin">
    <div class="card bg-gradient-danger card-img-holder text-white">
      <div class="card-body">
        <img src="{{('assets/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image" />
        <h4 class="font-weight-normal mb-3">Total Teachers <i class="mdi mdi-account-multiple mdi-24px float-end"></i>
        </h4>
        <h2 class="mb-5">{{ $totalTeachers }}</h2>
        <h6 class="card-text">Registered Users</h6>
      </div>
    </div>
  </div>
@endif
  <div class="col-md-4 stretch-card grid-margin">
    <div class="card bg-gradient-info card-img-holder text-white">
      <div class="card-body">
        <img src="{{('assets/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image" />
        <h4 class="font-weight-normal mb-3">Total Courses <i class="mdi mdi-book-open-page-variant mdi-24px float-end"></i>
        </h4>
        <h2 class="mb-5">{{ $totalCourses }}</h2>
        <h6 class="card-text">Available Courses</h6>
      </div>
    </div>
  </div>
  <div class="col-md-4 stretch-card grid-margin">
    <div class="card bg-gradient-success card-img-holder text-white">
      <div class="card-body">
        <img src="{{('assets/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image" />
        <h4 class="font-weight-normal mb-3">Total Students <i class="mdi mdi-school mdi-24px float-end"></i>
        </h4>
        <h2 class="mb-5">{{ $totalStudents }}</h2>
        <h6 class="card-text">Enrolled Students</h6>
      </div>
    </div>
  </div>

@endsection
