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
                                <h4 class="mt-0 header-title">Filters</h4>
                            </div>
                        </div>
                        <form>
                            @include('frontend._partials._filter_form')
                        </form>
                        <div class="row">
                            @include('frontend._partials._action_navbar')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row custom-margin">
            <div class="col">
                @include('frontend._partials._table')
            </div>
        </div>
    </div>
    @include('frontend._partials.modal._modal_form')
    @include('frontend._partials.modal._modal_show')
@endsection

