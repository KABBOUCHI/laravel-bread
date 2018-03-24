@extends(config('bread.layout.master'))

@section(config('bread.layout.content'))

        <div class="row">
            <div class="col-lg-12">
                <div class="box box-danger">

                    <div class="box-header">
                        <h5>Delete {{ $data['name'] }}</h5>
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
                        <form action="{{ route($data['as'].'destroy',$model)}}" method="post" class="form-horizontal">
                        {{method_field('DELETE')}}
                        {{ csrf_field() }}
                        <!-- Name input field -->
                            <p>
                                Are your sure you want to delete this {{ $data['name'] }}.
                            </p>
                            <div class="form-group">
                                <div class="col-lg-offset-10 col-lg-2">
                                    <a href="{{ url($data['redirectTo']) }}" class="btn btn-default">Cancel</a>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

@endsection