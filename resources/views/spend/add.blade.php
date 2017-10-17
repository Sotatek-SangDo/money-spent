@extends('layouts.app')

@section('script')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <script type="text/javascript">
        jq(document).ready(function() {
            jq('#date').datepicker({
                format: 'yyyy-mm-dd',
            });
        })
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class ="col-md-12">
                <h3>Add new</h3>
                <form id="form-add" action="/spend/store" method="post">
                    {{ csrf_field() }}
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" type="text" id="title" name="title" value="{{ old('title') }}">
                        <label class="mdl-textfield__label" for="title">Title</label>
                        @if ($errors->has('title'))
                            <span class="mdl-textfield__error" style="visibility: visible;">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" type="text" id="amount" name="amount" value="{{ old('amount') }}">
                        <label class="mdl-textfield__label" for="amount">Amount</label>
                        @if ($errors->has('amount'))
                            <span class="mdl-textfield__error" style="visibility: visible;">
                                <strong>{{ $errors->first('amount') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="mdl-textfield mdl-js-textfield">
                        <input class="mdl-textfield__input" name="date_spend" value="{{ old('date_spend') }}" readonly placeholder="Date..." type="text" id="date">
                        <label class="mdl-textfield__label" for="date"></label>
                        @if ($errors->has('date_spend'))
                            <span class="mdl-textfield__error" style="visibility: visible;">
                                <strong>{{ $errors->first('date_spend') }}</strong>
                            </span>
                        @endif
                    </div>
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <div class="button-add">
                        <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" id="add">Add</button>
                        <div class="mdl-tooltip" data-mdl-for="add">Add new</div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
