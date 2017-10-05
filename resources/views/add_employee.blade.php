@extends('layouts.layout')

@section('content')

    <div class="container">
        <h2>Add employee</h2>
        <br>

        @include('layouts.errors')

        <form enctype="multipart/form-data" id="add_employee" method="post" action="/employees">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" required class="form-control" id="full_name" name="full_name" placeholder="Enter name">
            </div>

            <div class="form-group">
                <label for="position_id">Position</label>
                <select class="form-control" id="position_id" name="position_id" onchange="selectPosition(this);">
                    <option value="-1">Select Position</option>
                    @foreach($positions as $position)
                        <option value="{{ $position->id }}">{{ $position->position }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="pid">Boss</label>
                <select class="form-control" id="pid" name="pid" disabled>
                    <option value="-1">Select Boss</option>
                </select>
            </div>

            <div class="form-group">
                <label for="employment_start">Employment Start</label>
                <input type="text" required class="form-control" id="employment_start" name="employment_start" placeholder="YYYY-MM-DD">
            </div>

            <div class="form-group">
                <label for="salary">Salary</label>
                <input type="text" required class="form-control" id="salary" name="salary" placeholder="Enter Salary">
            </div>

            <div class="form-group">
                <label>Photo</label>
                <div>
                    <label class="custom-file">
                        <input type="file" id="file" name="file" accept=".jpg,.gif,.png" class="custom-file-input">
                        <span class="custom-file-control"></span>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <button class="btn btn-primary" type="submit">Post</button>
            </div>
        </form>

    </div>

@endsection