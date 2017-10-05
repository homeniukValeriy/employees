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
