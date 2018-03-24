@extends('layouts.app')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">

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
    </div>
@endsection
