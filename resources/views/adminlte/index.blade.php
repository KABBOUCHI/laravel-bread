@extends(config('bread.layout.master'))

@section(config('bread.layout.content'))
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-header text-right">
                    <div class="box-title">
                        <a class="btn btn-primary" href="{{ route($data['as'].'create') }}">
                            Add new {{ $data['name'] }}
                        </a>
                    </div>

                </div>
                <div class="box-body">
                    {{ $tableView->render() }}
                </div>
            </div>
        </div>
    </div>
@endsection
