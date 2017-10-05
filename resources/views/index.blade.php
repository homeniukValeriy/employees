@extends('layouts.layout')

@section('content')

    <div class="container">
        <h2>Employee hierarchy</h2>

        @if (count($tree))

            <ul class="tree">

                @foreach ($tree[0]['children'] as $child_id)

                    <li>
                        <div class="wrapper">
                            <span class="expander">
                                @isset ($tree[$child_id]['children'])
                                    <i class="fa fa-plus"></i>
                                @endisset
                            </span>
                            <span class="display" data-id="{{ $tree[$child_id]['element']->id }}">{{ $tree[$child_id]['element']->full_name }} - {{ $tree[$child_id]['element']->position->position }}</span>
                        </div>

                        @isset ($tree[$child_id]['children'])
                            <ul class="hidden">
                                @foreach ($tree[$child_id]['children'] as $child_id_lvl_2)
                                    <li>
                                        <div class="wrapper">
                                            <span class="expander">
                                                <i class="fa fa-plus"></i>
                                            </span>
                                            <span class="display" data-id="{{ $tree[$child_id_lvl_2]['element']->id }}">{{ $tree[$child_id_lvl_2]['element']->full_name }} - {{ $tree[$child_id_lvl_2]['element']->position->position }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endisset
                    </li>

                @endforeach

            </ul>

        @endif

    </div>

@endsection