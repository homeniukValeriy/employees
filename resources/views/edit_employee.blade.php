@extends('layouts.layout')

@section('content')

    <div class="container">
        <h2>Edit employee</h2>
        <br>

        @include('layouts.errors')

        <img style="max-width: 300px;" src="{{ $employee->photo }}" alt="employee photo" class="img-thumbnail">
        <br>
        <br>

        <form enctype="multipart/form-data" id="add_employee" method="post" action="/employees/{{ $employee->id }}">
            {{ csrf_field() }}
            {!! method_field('patch') !!}

            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" required class="form-control" id="full_name" name="full_name" value="{{ $employee->full_name }}" placeholder="Enter name">
            </div>

            <div class="form-group">
                <label for="position_id">Position</label>
                <select class="form-control" id="position_id" name="position_id" onchange="selectPosition(this);">
                    @foreach($positions as $position)
                        <option
                            value="{{ $position->id }}"
                            @if ($employee->position_id == $position->id)
                                selected="selected"
                            @endif
                        >
                            {{ $position->position }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="pid">Boss</label>
                @if (count($bosses))
                    <select class="form-control" id="pid" name="pid">
                        @foreach ($bosses as $boss)
                            <option value="{{ $boss->id }}">{{ $boss->full_name }}</option>
                        @endforeach
                    </select>
                @else
                    <select class="form-control" id="pid" name="pid" disabled>
                        <option value="-1">Select Boss</option>
                    </select>
                @endif
            </div>

            <div class="form-group">
                <label for="employment_start">Employment Start</label>
                <input type="text" required class="form-control" id="employment_start" value="{{ $employee->employment_start }}" name="employment_start" placeholder="YYYY-MM-DD">
            </div>

            <div class="form-group">
                <label for="salary">Salary</label>
                <input type="text" required class="form-control" id="salary" name="salary" value="{{ $employee->salary }}" placeholder="Enter Salary">
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
                <button class="btn btn-primary" type="submit">Update</button>
            </div>
        </form>

    </div>

@endsection