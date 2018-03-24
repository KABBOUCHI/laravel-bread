@extends(config('bread.layout.master'))

@section(config('bread.layout.content'))
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info">
                <div class="panel-header text-right">
                    <div class="panel-title">
                        <a class="btn btn-primary" href="{{ route($data['as'].'create') }}">
                            Add new {{ $data['name'] }}
                        </a>
                    </div>

                </div>
                <div class="panel-body">
                    {{ $tableView->render() }}
                </div>
            </div>
        </div>
    </div>
@endsection
