@extends('layouts.app')

@section('script')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('menu')
    @include('layouts.menu')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class ="col-md-12">
                <h3>Add new</h3>
                <form id="form-add" action="/account/store" method="post">
                    {{ csrf_field() }}
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" type="text" id="name" name="name" value="{{ old('name') }}">
                        <label class="mdl-textfield__label" for="name">Name</label>
                        @if ($errors->has('name'))
                            <span class="mdl-textfield__error" style="visibility: visible;">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" type="password" id="password" name="password" value="{{ old('password') }}">
                        <label class="mdl-textfield__label" for="password">Password</label>
                        @if ($errors->has('password'))
                            <span class="mdl-textfield__error" style="visibility: visible;">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" name="email" value="{{ old('email') }}" type="email" id="email">
                        <label class="mdl-textfield__label" for="email">Email</label>
                        @if ($errors->has('email'))
                            <span class="mdl-textfield__error" style="visibility: visible;">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <input type="hidden" name="user_parents_id" value="{{ auth()->user()->id }}">
                    <div class="button-add">
                        <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" id="add">Add</button>
                        <div class="mdl-tooltip" data-mdl-for="add">Add new</div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
