<form action="{{route('store.course')}}" method="POST" class="row">
    @csrf
    <div class="col-6 my-2" >
        <label for="">Title</label>
        <input type="text" name="title" placeholder="Title" class="form-control" id="">
    </div>
    <div class="col-6 my-2" >
        <label for="">Price</label>
        <input type="text" name="price" placeholder="Price" class="form-control" id="">
    </div>
    <div class="col-6 my-2" >
        <label for="">Start Date</label>
        <input type="date" name="start_date" class="form-control" id="">
    </div>
     <div class="col-6 my-2" >
        <label for="">End Date</label>
        <input type="date" name="end_date" class="form-control" id="">
    </div>
     <div class="col-12 my-2" >
        <label for="">Teacher</label>
        <select name="teacher_id" id="" class="form-select">
            <option value="">--- Select Teacher ---</option>
            @foreach ($teachers as $teacher)
                <option value="{{$teacher->id}}">{{$teacher->fullName()}}</option>
            @endforeach
        </select>
    </div>
     <div class="col-12 my-2" >
        <label for="">Description</label>
        <textarea name="description" id="" cols="30" class="form-control" rows="10" placeholder="Description"></textarea>
    </div>
     <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary">Save</button>
    </div>
</form>
