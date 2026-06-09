<form action="{{ route('update.student', $student->id) }}" method="POST" class="row">
    @csrf
    @method('PUT')
    <div class="col-6 my-2">
        <label for="">First Name</label>
        <input type="text" name="first_name" value="{{ $student->first_name }}" placeholder="First Name"
            class="form-control" id="">
    </div>
    <div class="col-6 my-2">
        <label for="">Last Name</label>
        <input type="text" name="last_name" value="{{ $student->last_name }}" placeholder="Last Name"
            class="form-control" id="">
    </div>
    <div class="col-6 my-2">
        <label for="">Username</label>
        <input type="text" name="username" value="{{ $student->user->username ?? '' }}" placeholder="Username" class="form-control" id="">
    </div>
    <div class="col-6 my-2">
        <label for="">Email</label>
        <input type="email" name="email" value="{{ $student->user->email ?? '' }}" placeholder="Email" class="form-control" id="">
    </div>
    <div class="col-6 my-2">
        <label for="gender">Gender:</label>
        <div class="d-flex">
            <div class="me-2 my-2">
                <input type="radio" name="gender" {{ $student->gender == 'Male' ? 'checked' : '' }} id="male"
                    value="Male"> <label for="Male">Male</label>
            </div>
            <div class="me-2 my-2">
                <input type="radio" name="gender" {{ $student->gender == 'Female' ? 'checked' : '' }} id="female"
                    value="Female"> <label for="Female">Female</label>
            </div>
        </div>
    </div>
    <div class="col-6 my-2">
        <label for="">Score</label>
        <input type="text" name="score" value="{{ $student->score }}" placeholder="Score" class="form-control"
            id="">
    </div>
    <div class="col-6 my-2">
        <label for="">Status</label>
        <select name="status" id="" class="form-select">
            <option value="">Select Status</option>
            <option value="Active" {{ $student->status == 'Active' ? 'selected' : '' }}>Active</option>
            <option value="Inactive" {{ $student->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    <div class="col-6 my-2">
        <label for="">Course</label>
        <select name="course_id" id="" class="form-select">
            @foreach ($courses as $course)
                <option value="{{ $course->id }}" {{ $student->course_id == $course->id ? 'selected' : '' }}>
                    {{ $course->title }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary">Save</button>
    </div>
</form>
