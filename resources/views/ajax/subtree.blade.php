@if (count($children))
    <ul class="hidden">

        @foreach ($children as $child)

            <li>
                <div class="wrapper">
                    <span class="expander">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="display" data-id="{{ $child->id }}">{{ $child->full_name }} - {{ $child->position->position }}</span>
                </div>
            </li>

        @endforeach

    </ul>
@endif