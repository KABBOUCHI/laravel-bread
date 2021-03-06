@extends(config('bread.layout.master'))

@section(config('bread.layout.content'))
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <div class="ibox-tools">
                        <a class="btn btn-primary" href="{{ route($data['as'].'create') }}">
                            Add new {{ $data['name'] }}
                        </a>
                    </div>

                </div>
                <div class="ibox-content">
                    {{ $tableView->render() }}
                </div>
            </div>
        </div>
    </div>
@endsection
