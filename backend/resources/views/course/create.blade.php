<form action="{{ route('store.course') }}" method="POST" class="student-form course-form">
    @csrf

    <div class="student-form-header">
        <div>
            <strong>Add New Class</strong>
            <small>Create a class and assign its teacher and semester dates.</small>
        </div>
        <span>New Class</span>
    </div>

    <div class="student-form-body">
        <label class="form-span-2">
            <span>Class Name</span>
            <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g. Mathematics 10A" required>
        </label>
        <label>
            <span>Teacher</span>
            <select name="teacher_id" required>
                <option value="">Select teacher</option>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ (string) old('teacher_id') === (string) $teacher->id ? 'selected' : '' }}>{{ $teacher->fullName() }}</option>
                @endforeach
            </select>
        </label>
        <label>
            <span>Class Price</span>
            <input type="number" name="price" value="{{ old('price') }}" min="0" step="0.01" placeholder="0.00" required>
        </label>
        <label>
            <span>Start Date</span>
            <input type="date" name="start_date" value="{{ old('start_date') }}" required>
        </label>
        <label>
            <span>End Date</span>
            <input type="date" name="end_date" value="{{ old('end_date') }}">
        </label>
    </div>

    <div class="student-form-actions">
        <button type="button" class="btn student-cancel-button" data-bs-dismiss="modal">Cancel</button>
        <button class="btn student-add-button">Add Class</button>
    </div>
</form>
