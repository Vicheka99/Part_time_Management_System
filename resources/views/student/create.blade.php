<form action="{{ route('store.student') }}" method="POST" class="row">
    @csrf

    <div class="col-6 my-2">
        <label for="">First Name</label>
        <input type="text" name="first_name" placeholder="First Name" class="form-control" id="">
    </div>
    <div class="col-6 my-2">
        <label for="">Last Name</label>
        <input type="text" name="last_name" placeholder="Last Name" class="form-control" id="">
    </div>
    <div class="col-6 my-2">
        <label for="">Username</label>
        <input type="text" name="username" placeholder="Username" class="form-control" id="">
    </div>
    <div class="col-6 my-2">
        <label for="">Email</label>
        <input type="email" name="email" placeholder="Email" class="form-control" id="">
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
        <label for="">Score</label>
        <input type="text" name="score" placeholder="Score" class="form-control" id="">
    </div>
    <div class="col-6 my-2">
        <label for="">Status</label>
        <select name="status" id="" class="form-select" >
            <option value="" >Select Status</option>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
        </select>
    </div>

    <div class="col-6 my-2">
        <label for="">Course</label>
        <select name="course_id" id="" class="form-select" >
            @foreach ($courses as $course)
                <option value="{{$course->id}}">{{$course->title}}</option>
            @endforeach
        </select>
    </div>

    <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary">Save</button>
    </div>
</form>
