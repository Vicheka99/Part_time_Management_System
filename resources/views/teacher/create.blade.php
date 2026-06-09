@extends('master_dashboard')
@section('title')
    Teacher | Create
@endsection

@section('content-title')
    <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-home"></i>
    </span> Create Teacher
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Teacher</a></li>
    <li class="breadcrumb-item active" aria-current="page">
        Create Teacher <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
    </li>

@endsection

@section('content-body')
    <div class="col-8 mx-auto bg-white py-3">
        <form action="{{route('store.user')}}" method="POST" enctype="multipart/form-data" class="row">
            @csrf
            <div class="col-6 my-2">
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" placeholder="First Name" class="form-control">
            </div>
            <div class="col-6 my-2">
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" placeholder="Last Name" class="form-control">
            </div>
            <div class="col-6 my-2">
                <label for="gender">Gender:</label>
                <div class="d-flex">
                    <div class="me-2 my-2">
                        <input type="radio" name="gender" id="male" value="Male"> <label for="Male">Male</label>
                    </div>
                    <div class="me-2 my-2">
                        <input type="radio" name="gender" id="female" value="Female"> <label for="Female">Female</label>
                    </div>
                </div>
            </div>
            <div class="col-6 my-2">
                <label for="email">Email:</label>
                <input type="text" name="email" placeholder="Email" class="form-control">
            </div>
            <div class="col-6 my-2">
                <label for="password">Password:</label>
                <input type="text" name="password" placeholder="Password" class="form-control">
            </div>
            <div class="col-6 my-2">
                <label for="profile">Profile:</label>
                <input type="file" name="profile" class="form-control" id="profile">
                 <input type="hidden" name="profile_name" class="form-control my-2 " id="profile_name">
                <div class="preview-profile border border-1 border-dark mt-2 " style="width: fit-content; cursor: pointer;">
                    <img src="{{asset('assets/images/uploadimage.jpg')}}" id="show-profile" alt="" style="width: 120px;">
                </div>
            </div>
            <div class="col-12 my-2 d-flex justify-content-end">
                <a href="{{route('home')}}" class="btn btn-secondary me-2">Back</a>
                <button class="btn btn-primary me-2">Save</button>
            </div>
        </form>
    </div>
@endsection
