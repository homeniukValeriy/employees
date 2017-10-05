@if (count($employees))

    <table class="table table-responsive table-striped">
        <thead>
        <tr>
            @foreach ($table_columns as $field => $column)
                <th>
                    <span class="sort"
                          data-field="{{ $field }}"
                          @isset ($column['sort'])
                            data-sort="{{ $column['sort'] }}"
                          @endisset
                    >
                        {{ $column['title'] }}
                        @isset ($column['sort'])
                        <i class="fa fa-sort-{{ $column['sort'] }}"></i>
                        @endisset
                    </span>
                </th>
            @endforeach
            <th class="text-center">Photo</th>
            <th class="text-center">Edit</th>
            <th class="text-center">Delete</th>
        </tr>
        </thead>
        <tbody>

            @foreach ($employees as $employee)
                <tr>
                    <th scope="row">{{ $employee->id }}</th>
                    <td>{{ $employee->pid }}</td>
                    <td>{{ $employee->full_name }}</td>
                    <td>{{ $employee->position }}</td>
                    <td>{{ $employee->employment_start }}</td>
                    <td>{{ $employee->salary }}</td>
                    <td class="text-center"><img style="width: 64px" src="{{ $employee->photo }}" alt="employee photo"></td>
                    <td class="text-center"><a href="/employees/{{ $employee->id }}/edit"><i class="fa fa-edit"></i></a></td>
                    <td class="text-center">
                        <form action="/employees/{{ $employee->id }}" method="post">
                            {{ csrf_field() }}
                            {!! method_field('delete') !!}
                            @if ($employee->pid != 0)
                                <a href="#" onclick="this.parentElement.submit();"><i class="fa fa-remove"></i></a>
                            @endif
                        </form>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

    {{ $employees->links() }}

@else
    <h4>We can't find any matching employees</h4>
@endif