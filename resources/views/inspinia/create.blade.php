@extends(config('bread.layout.master'))

@php
    use KABBOUCHI\Bread\Http\BreadType as BreadType;
    extract($data);
@endphp

@section(config('bread.layout.content'))
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

                        @foreach($fields as $key => $item)
                            <div class="form-group">
                                <label for="{{$key}}"
                                       class="col-sm-2 control-label">{{ $item['title'] }}</label>
                                @php $item = collect($item); @endphp
                                <div class="col-sm-10">
                                    @if($item['type'] == BreadType::TEXT)
                                        <input type="text"
                                               id="{{$key}}"
                                               class="form-control"
                                               name="{{$key}}"
                                               value="{{ old($key) }}"
                                               @if(str_contains("required",$item['validation'])) required @endif
                                        >
                                    @elseif($item['type'] == BreadType::EMAIL)
                                        <input type="email"
                                               id="{{$key}}"
                                               class="form-control"
                                               name="{{$key}}"
                                               value="{{ old($key) }}"
                                               @if(str_contains("required",$item['validation'])) required @endif
                                        >
                                    @elseif($item['type'] == BreadType::PASSWORD)
                                        <input type="password"
                                               id="{{$key}}"
                                               class="form-control"
                                               name="{{$key}}"
                                               value="{{ old($key) }}"
                                               @if(str_contains("required",$item['validation'])) required @endif
                                        >
                                    @elseif($item['type'] == BreadType::SELECT)
                                        <select name="{{$key}}" id="{{$key}}" class="form-control">
                                            @foreach($item['select']['data'] as $option)
                                                <option value="{{$option[$item['select']['value']]}}"
                                                        @if(old($key) == $option[$item['select']['value']])
                                                        selected
                                                        @endif
                                                > {{$option[$item['select']['name']]}}</option>
                                            @endforeach
                                        </select>
                                    @elseif($item['type'] == BreadType::MULTIPLE_SELECT)
                                        <select name="{{$key}}[]" id="{{$key}}" class="form-control" multiple>
                                            @foreach($item['select']['data'] as $option)
                                                <option value="{{$option[$item['select']['value']]}}"
                                                        @if(str_contains($option[$item['select']['value']],old($key,$model->{$key})))
                                                        selected
                                                        @endif
                                                > {{$option[$item['select']['name']]}}</option>
                                            @endforeach
                                        </select>
                                    @elseif($item['type'] == BreadType::DATETIME)
                                        <input type="datetime-local"
                                               id="{{$key}}"
                                               class="form-control"
                                               name="{{$key}}"
                                               @if(str_contains("required",$item['validation'])) required @endif
                                        >
                                    @elseif($item['type'] == BreadType::DATE)
                                        <input type="date"
                                               id="{{$key}}"
                                               class="form-control"
                                               name="{{$key}}"
                                               @if(str_contains("required",$item['validation'])) required @endif
                                        >

                                    @elseif($item['type'] == BreadType::IMAGE)
                                        <input type="file"
                                               id="{{$key}}"
                                               class="form-control"
                                               name="{{$key}}"
                                               @if(str_contains("required",$item['validation'])) required @endif
                                        >
                                    @elseif($item['type'] == BreadType::TEXT_AREA || $item['type'] == BreadType::RICH_TEXT)
                                        <textarea
                                                id="{{$key}}"
                                                class="form-control {{  $item['type'] == BreadType::RICH_TEXT ? 'rich-text' : '' }}"
                                                name="{{$key}}"
                                                @if(str_contains("required",$item['validation'])) required @endif
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
@endsection
