<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Employee;
use DB;

class EmployeesController extends Controller
{
    public function index()
    {
        $employees = Employee::with('position')->where('position_id', '<', '3')->get();
        $tree = [];

        foreach ($employees as $employee) {

            if (isset($tree[$employee->pid])) {
                $tree[$employee->pid]['children'][] = $employee->id;
            } else {
                $tree[$employee->pid] = [
                    'children' => [$employee->id]
                ];
            }

            $tree[$employee->id]['element'] = $employee;
        }

        return view('index', compact('tree'));
    }

    public function subtree($id)
    {
        $children = Employee::with('position')->where('pid', '=', $id)->get();

        return view('ajax.subtree', compact('children'));
    }

    public function showList(Request $request)
    {
        $sort_type = $request->has('sort_type') ? $request->sort_type : 'asc';
        $sort_field = $request->has('sort_field') ? $request->sort_field : 'id';

        $search_field = $request->has('search_field') ? $request->search_field : '';
        $search_value = $request->has('search_value') ? $request->search_value : '';

        if ($search_field == 'id') {
            $search_field = 'employees.id';
        }

        $table_columns = [
            'id' => ['title' => 'ID'],
            'pid' => ['title' => 'PID'],
            'full_name' => ['title' => 'Full Name'],
            'position' => ['title' => 'Position'],
            'employment_start' => ['title' => 'Employment Start'],
            'salary' => ['title' => 'Salary']
        ];
        $table_columns[$sort_field]['sort'] = $sort_type;

        $employees = DB::table('employees')
            ->join('positions', 'employees.position_id', '=', 'positions.id')
            ->select('employees.id as id', 'pid', 'full_name', 'positions.position', 'employment_start', 'salary', 'photo')
            ->when($search_field && $search_value, function ($query) use ($search_field, $search_value) {
                return $query->where($search_field, '=', $search_value);
            })
            ->orderBy($sort_field, $sort_type)
            ->paginate(20);

        foreach ($employees as &$employee) {
            $employee->photo = $employee->photo ? Storage::url($employee->photo) : Storage::url('public/img/no_image.png');
        }

        if ($request->ajax()) {
            return view('ajax.employees_list', compact('employees', 'table_columns'));
        } else {
            return view('employees_list', compact('employees', 'table_columns'));
        }

    }

    public function getBosses(Request $request)
    {
        if ($request->has('position_id')) {

            $bosses = DB::table('employees')
                ->select('id', 'full_name')
                ->where('position_id', '<', $request->position_id)
                ->orderBy('full_name', 'asc')
                ->get();

            return view('ajax.bosses', compact('bosses'));
        }
    }

    public function create()
    {
        $positions = DB::table('positions')->get();

        return view('add_employee', compact('positions'));
    }

    public function store(Request $request)
    {
        if ($request->position_id == 1) { //CEO
            $request->merge(['pid' => 0]);
        }

        $this->validate(request(), [
            'pid' => ['required', 'regex:/^\d+$/i'],
            'position_id' => ['required', 'regex:/^\d+$/i'],
            'full_name' => 'required|max:255',
            'employment_start' => 'required|date_format:Y-m-d',
            'salary' => ['required', 'regex:/^\d{1,7}(\.\d{2})?$/i'],
            'file' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ],
        [
            'pid.required' => 'The boss field is required.',
            'position_id.required' => 'The position field is required.',
            'salary.regex' => 'The salary must be between 0.00 and 9999999.99',
            'pid.regex' => 'The boss field is required.',
            'position_id.regex' => 'The position field is required.'
        ]);

        $path = 'img/no_image.png';
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $path = Storage::putFile('public/img', $request->file('file'));
        }

        $request->merge(['photo' => $path]);

        Employee::create(
            request(['pid', 'position_id', 'full_name', 'employment_start', 'salary', 'photo'])
        );

        return redirect('/');
    }

    public function edit(Employee $employee)
    {
        $positions = DB::table('positions')->get();

        $bosses = [];
        if ($employee->position_id > 1) {
            $bosses = DB::table('employees')
                ->select('id', 'full_name')
                ->where('position_id', '<', $employee->position_id)
                ->orderBy('full_name', 'asc')
                ->get();
        }

        $employee->photo = $employee->photo ? Storage::url($employee->photo) : Storage::url('public/img/no_image.png');

        return view('edit_employee', compact('employee', 'positions', 'bosses'));
    }

    public function update(Request $request, Employee $employee)
    {
        if ($request->position_id == 1) { //CEO
            $request->merge([
                'pid' => 0
            ]);
        }

        $this->validate(request(), [
            'pid' => ['required', 'regex:/^\d+$/i'],
            'position_id' => ['required', 'regex:/^\d+$/i'],
            'full_name' => 'required|max:255',
            'employment_start' => 'required|date_format:Y-m-d',
            'salary' => ['required', 'regex:/^\d{1,7}(\.\d{2})?$/i'],
            'file' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ],
            [
                'pid.required' => 'The boss field is required.',
                'position_id.required' => 'The position field is required.',
                'salary.regex' => 'The salary must be between 0.00 and 9999999.99',
                'pid.regex' => 'The boss field is required.',
                'position_id.regex' => 'The position field is required.'
            ]);

        $path = 'img/no_image.png';
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $path = Storage::putFile('public/img', $request->file('file'));
        }

        $request->merge(['photo' => $path]);

        $employee->update(
            request(['pid', 'position_id', 'full_name', 'employment_start', 'salary', 'photo'])
        );

        return redirect('/employees');
    }

    public function destroy(Employee $employee)
    {
        DB::table('employees')
            ->where('pid', '=', $employee->id)
            ->update(['pid' => $employee->pid]);

        $employee->delete();

        return redirect('/employees');
    }
}
