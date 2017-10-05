@extends('layouts.layout')

@section('content')

    <div class="container">
        <h2>List of all employees</h2>
        <br>

        <form id="search_employee" class="form-inline">
            <div class="form-group">
                <label for="search_field" class="mr-2">Search by: </label>
                <select class="form-control" id="search_field" name="search_field">
                    <option value="id">ID</option>
                    <option value="pid">PID</option>
                    <option value="full_name">Full Name</option>
                    <option value="position">Position</option>
                    <option value="employment_start">Employment Start</option>
                    <option value="salary">Salary</option>
                </select>
            </div>
            <div class="form-group mx-sm-3">
                <input type="text" class="form-control" id="search_value" name="search_value" placeholder="Value">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <br>

        <div class="employees-table-wrapper">
            @include('ajax.employees_list', ['employees' => $employees, 'table_columns' => $table_columns])

            <div id="overlay"></div>
        </div>

    </div>

@endsection