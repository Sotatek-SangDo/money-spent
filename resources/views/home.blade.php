@extends('layouts.app')

@section('script')
    <style type="text/css">
        .panel-default {
            border-color: transparent !important;
        }
    </style>
@endsection

@section('menu')
    @include('layouts.menu')
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <h1>WELCOME TO SITE</h1>
                @if(auth()->user()->hasChildren())
                    <livemessage></livemessage>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
