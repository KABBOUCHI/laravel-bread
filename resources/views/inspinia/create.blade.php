@extends('layouts.app')

@php
    extract($data);
@endphp

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">

                        <h5>Create new {{ $data['name'] }}</h5>

                    </div>
                    <div class="ibox-content">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route($data['as'].'store')}}" method="post" class="form-horizontal"
                              enctype="multipart/form-data">
                            {{ csrf_field() }}

                            @foreach($create_fields as $key => $item)
                                <div class="form-group">
                                    <label for="{{$key}}"
                                           class="col-sm-2 control-label">{{ str_replace("_"," ",ucfirst($key)) }}</label>
                                    @php $item = collect($item); @endphp
                                    <div class="col-sm-10">
                                        @if($item->contains('text'))
                                            <input type="text"
                                                   id="{{$key}}"
                                                   class="form-control"
                                                   name="{{$key}}"
                                                   value="{{ old($key) }}"
                                                   @if($item->contains('required')) required @endif
                                            >
                                        @elseif($item->contains('select'))
                                            <select name="{{$key}}" id="{{$key}}" class="form-control">
                                                @foreach($selects[$key] as $k => $name)
                                                    <option value="{{$k}}"
                                                            @if(old($key) == $k)
                                                            selected
                                                            @endif
                                                    > {{$name}}</option>
                                                @endforeach
                                            </select>
                                        @elseif($item->contains('datetime'))
                                            <input type="datetime-local"
                                                   id="{{$key}}"
                                                   class="form-control"
                                                   name="{{$key}}"
                                                   @if($item->contains('required')) required @endif
                                            >
                                        @elseif($item->contains('date'))
                                            <input type="date"
                                                   id="{{$key}}"
                                                   class="form-control"
                                                   name="{{$key}}"
                                                   @if($item->contains('required')) required @endif
                                            >

                                        @elseif($item->contains('image'))
                                            <input type="file"
                                                   id="{{$key}}"
                                                   class="form-control"
                                                   name="{{$key}}"
                                                   @if($item->contains('required')) required @endif
                                            >
                                        @elseif($item->contains('textarea') || $item->contains('ckeditor'))
                                            <textarea
                                                    id="{{$key}}"
                                                    class="form-control {{  $item->contains('ckeditor') ? 'ckeditor' : '' }}"
                                                    name="{{$key}}"
                                                    @if($item->contains('required')) required @endif
                                            >{{ old($key) }}</textarea>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button type="submit" class="btn btn-primary pull-right">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script>
        $(function () {
            $('#tags_select').chosen({width: "100%"}).change(function () {
                $('[name=tags]').val($(this).val());
            });
        });
    </script>
@endpush
