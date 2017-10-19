<li class="{{ Request::is('spend/*') ? 'active' : '' }} dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Spend</a>
    <ul class="dropdown-menu">
        <li><a href="{{ url('/spend/my-spend')}}">My spend</a></li>
        @if(Auth()->user()->isParents())
            <li><a href="{{ url('/spend/children')}}">Children spend</a></li>
        @endif
    </ul>
</li>
@if(Auth()->user()->isParents())
    <li class="{{ Request::is('add/*') ? 'active' : '' }} dropdown">
        <a class="dropdown-toggle" href="{{ url('/add/account') }}">Add account</a>
    </li>
@endif
