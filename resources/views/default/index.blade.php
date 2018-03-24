@extends(config('bread.layout.master'))

@section(config('bread.layout.content'))
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-right">
                    <a class="btn btn-primary" href="{{ route($data['as'].'create') }}">
                        Add new {{ $data['name'] }}
                    </a>
                </div>
                <div class="card-body">
                    {{ $tableView->render() }}
                </div>
            </div>
        </div>
    </div>
@endsection
