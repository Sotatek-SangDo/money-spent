@extends('layouts.app')

@section('script')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <script type="text/javascript">
        jq(document).ready(function() {
            jq('#date_start').datepicker({
                format: 'yyyy-mm-dd',
            });
            jq('#date_end').datepicker({
                format: 'yyyy-mm-dd',
            });
            jq('.query-form').on('change', function() {
                if(!jq('#child').length) {
                    jq('#query-form').submit()
                } else {
                    var url = window.location.pathname;
                    window.location.href = url + '?user_child_name=' + jq('#child').val() + '&' +jq('#query-form').serialize();
                }
            })
            jq('.date').on('change', function() {
                if(!jq('#child').length) {
                    jq('#date-form').submit()
                } else {
                    var url = window.location.pathname;
                    window.location.href = url + '?user_child_name=' + jq('#child').val() + '&' + jq('#date-form').serialize();
                }
            })
            jq('#child').on('change', function() {
                var url = window.location.pathname;
                window.location.href = url + '?user_child_name=' + jq(this).val()
            })
        })
    </script>
@endsection

@section('menu')
    @include('layouts.menu')
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
            <div class="query">
                @if(isset($children) && auth()->user()->hasChildren())
                    <div class="select-limit">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fullwidth">
                            <input class="mdl-textfield__input" type="text" name="user_child_name" id="child" value="{{ $user_child }}" readonly tabIndex="-1">
                            <label for="child" class="mdl-textfield__label">Children name</label>
                            <ul for="child" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                                @foreach($children as $child)
                                    <li class="mdl-menu__item">{{ $child['name'] }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                <form action="/spend/{{$url}}" method="get" id="query-form">
                    <div class="select-list">
                        <div class="select-time">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fullwidth">
                                <input class="mdl-textfield__input query-form" type="text" name="time" id="time" value="{{ $time }}" readonly tabIndex="-1">
                                <label for="time" class="mdl-textfield__label">Time</label>
                                <ul for="time" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                                    <li class="mdl-menu__item">week</li>
                                    <li class="mdl-menu__item">month</li>
                                    <li class="mdl-menu__item">year</li>
                                </ul>
                            </div>
                        </div>
                        <div class="select-limit">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fullwidth">
                                <input class="mdl-textfield__input query-form" type="text" name="month" id="month" value="{{ $month }}" readonly tabIndex="-1">
                                <label for="month" class="mdl-textfield__label">Month</label>
                                <ul for="month" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                                    <li class="mdl-menu__item">1</li>
                                    <li class="mdl-menu__item">2</li>
                                    <li class="mdl-menu__item">3</li>
                                    <li class="mdl-menu__item">4</li>
                                    <li class="mdl-menu__item">5</li>
                                    <li class="mdl-menu__item">6</li>
                                    <li class="mdl-menu__item">7</li>
                                    <li class="mdl-menu__item">8</li>
                                    <li class="mdl-menu__item">9</li>
                                    <li class="mdl-menu__item">10</li>
                                    <li class="mdl-menu__item">11</li>
                                    <li class="mdl-menu__item">12</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>
                <form action="/spend/{{$url}}" method="get" id="date-form">
                    <div class="select-list">
                        <div class="select-time">
                            <div class="mdl-textfield mdl-js-textfield">
                                <input class="mdl-textfield__input date" value="{{ $start_date }}" name="date_start" readonly placeholder="Start Date..." type="text" id="date_start">
                                <label class="mdl-textfield__label" for="date_start"></label>
                            </div>
                        </div>
                         <div class="select-time">
                            <div class="mdl-textfield mdl-js-textfield">
                                <input class="mdl-textfield__input date" name="date_end" value="{{ $end_date }}" readonly placeholder="End Date..." type="text" id="date_end">
                                <label class="mdl-textfield__label" for="date_end"></label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
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
                    @php $total = 0; @endphp
                    @if(count($spends))
                        @foreach($spends as $key => $spend)
                            <tr>
                                <td class="mdl-data-table__cell--non-numeric">{{ $spend['title'] }}</td>
                                <td>{{ $spend['date_spend'] }}</td>
                                <td>{{ number_format($spend['amount']) }} VND</td>
                            </tr>
                            @php $total += $spend['amount']; @endphp
                        @endforeach
                    @endif
                    <tr>
                        <td colspan="2" style="text-align: right;">Total:</td>
                        <td>{{ number_format($total) }} VND</td>
                    </tr>
                </tbody>
            </table>
            @if(count($spends))
                {{ $spends->links('spend.pagination') }}
            @endif
        </div>
    </div>
</div>
@endsection
