@extends('layouts.app')

@section('script')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <script type="text/javascript">
        jq(document).ready(function() {
            jq('#time').on('change', function() {
                jq('#query-form').submit()
            })
            jq('#limit').on('change', function() {
                jq('#query-form').submit()
            })
        })
    </script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class ="col-md-12">
            <div class="add-new-page">
                <a href="{{ url('/spend/store') }}">
                    <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--colored" id="add-page">
                        <i class="material-icons">add</i>
                    </button>
                    <div class="mdl-tooltip" data-mdl-for="add-page">Add new</div>
                </a>
            </div>
            <form action="/" method="get" id="query-form">
                <div class="select-list">
                    <div class="select-time">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fullwidth">
                            <input class="mdl-textfield__input" type="text" name="time" id="time" value="{{ $time }}" readonly tabIndex="-1">
                            <label for="time" class="mdl-textfield__label">Time</label>
                            <ul for="time" class="mdl-menu mdl-menu--bottom-left mdl-js-menu" s>
                                <li class="mdl-menu__item">week</li>
                                <li class="mdl-menu__item">month</li>
                                <li class="mdl-menu__item">year</li>
                            </ul>
                        </div>
                    </div>
                    <div class="select-limit">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fullwidth">
                            <input class="mdl-textfield__input" type="text" name="limit" id="limit" value="{{ $limit }}" readonly tabIndex="-1">
                            <label for="limit" class="mdl-textfield__label">Limit</label>
                            <ul for="limit" class="mdl-menu mdl-menu--bottom-left mdl-js-menu" s>
                                <li class="mdl-menu__item">10</li>
                                <li class="mdl-menu__item">20</li>
                                <li class="mdl-menu__item">30</li>
                            </ul>
                        </div>
                    </div>
                </div>
                </form>
            <h2>List spend</h2>
            <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 100%">
                <thead>
                    <tr>
                        <th class="mdl-data-table__cell--non-numeric">Title</th>
                        <th>Date</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($spends))
                        @foreach($spends as $key => $spend)
                            <tr>
                                <td class="mdl-data-table__cell--non-numeric">{{ $spend['title'] }}</td>
                                <td>{{ $spend['date_spend'] }}</td>
                                <td>{{ $spend['amount'] }} VND</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            {{ $spends->links('spend.pagination') }}
        </div>
    </div>
</div>
@endsection
