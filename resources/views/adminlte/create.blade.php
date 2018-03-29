@extends(config('bread.layout.master'))

@php
    use KABBOUCHI\Bread\Http\BreadType as BreadType;
    extract($data);
@endphp

@section(config('bread.layout.content'))
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-header">

                    <h5>Create new {{ $data['name'] }}</h5>

                </div>
                <div class="box-body">
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
                                <div class="col-sm-10">
                                    {{ Bread::field($key,$item,[ 'class' => $item['type'] != BreadType::CHECKBOX ?'form-control': ''],old($key)) }}
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
