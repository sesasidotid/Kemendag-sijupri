@extends('layout.v_wrapper')
@section('title')
    Detail ROLE
@endsection
@push('ext_header')
    @include('layout.css_select')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.js_select')
    @include('layout.js_tables')
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Setup Akses Menu
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('/security/role/edit', ['code' => $roleData->code]) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="code" value="{{ $roleData->code }}">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="code" class="form-label">Code</label>
                                    <input type="text" class="form-control" id="code" disabled
                                        value="{{ $roleData->code }}">
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="name" disabled
                                        value="{{ $roleData->name }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="menu_access" class="form-label">Akses Menu</label>
                                    <div id="menu_access">
                                        <!-- Tree list with checkboxes -->

                                        <style>
                                            ul.tree {
                                                list-style-type: none;
                                                padding-left: 20px;
                                            }

                                            ul.tree li {
                                                position: relative;
                                            }

                                            ul.tree li:before {
                                                content: "";
                                                position: absolute;
                                                top: 0;
                                                left: -10px;
                                                border-left: 1px solid #ccc;
                                                height: 100%;
                                            }

                                            ul.tree li:last-child:before {
                                                border-left: none;
                                            }

                                            ul.tree li:before,
                                            ul.tree li:after {
                                                content: "";
                                                position: absolute;
                                                top: 0;
                                                left: -20px;
                                                width: 20px;
                                                border-top: 1px solid #ccc;
                                            }

                                            ul.tree li:after {
                                                top: auto;
                                                bottom: 0;
                                                border-top: none;
                                                border-bottom: 1px solid #ccc;
                                            }

                                            input[type="checkbox"] {
                                                margin-right: 5px;
                                            }
                                        </style>
                                        <ul class="tree">
                                            @foreach ($menuHierarchy as $menu)
                                                <li>
                                                    <input type="checkbox" @if ($menu->role_code !== null) checked @endif
                                                        @if ($menu->code == 'DAS_1') hidden @endif name="roleMenu[]"
                                                        value="{{ $menu->code }}" class="parent">
                                                    <span
                                                        @if ($menu->code == 'DAS_1') hidden @endif>{{ $menu->name }}</span>
                                                    @if (count($menu->children) > 0)
                                                        <ul class="tree">
                                                            @foreach ($menu->children as $child)
                                                                <li>
                                                                    <input type="checkbox"
                                                                        @if ($child->role_code !== null) checked @endif
                                                                        name="roleMenu[]" value="{{ $child->code }}"
                                                                        class="child-{{ $menu->code }}">
                                                                    <span>{{ $child->name }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-end">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Update parent checkbox status when child checkbox changes
            $('input[type="checkbox"]').change(function() {
                if ($(this).hasClass('parent')) {
                    var parentCode = $(this).val();
                    var isChecked = $(this).prop('checked');
                    $('.child-' + parentCode).prop('checked', isChecked);
                } else { // Child checkbox changed
                    var parentCode = $(this).attr('class').split(' ')[0].substring(
                        6); // Extract parent code from class
                    var isChecked = $(this).prop('checked');
                    if (isChecked) {
                        $('.parent[value="' + parentCode + '"]').prop('checked', true);
                    } else {
                        // Uncheck parent if no child is checked
                        if ($('.child-' + parentCode + ':checked').length == 0) {
                            $('.parent[value="' + parentCode + '"]').prop('checked', false);
                        }
                    }
                }
            });
        });
    </script>
@endsection
