@extends('layouts.frontend')

@section('title', 'Scheduler')

@section('content')
    <div class="container">

        {{--        KED JE ADMIN PRIHLASENY --}}
        <div class="row custom-margin">
            <div class="col-12">
                <div class="card m-b-20">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <h4 class="mt-0 header-title">Pre deleted items</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row custom-margin">
            <div class="col">
                @include('frontend._partials._table_delete')
            </div>
        </div>
    </div>
@endsection


