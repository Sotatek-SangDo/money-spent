<li class="{{ Request::is('spend/*') ? 'active' : '' }} dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Spend</a>
    <ul class="dropdown-menu">
        <li class="kopie"><a href="{{ url('/spend')}}">My spend</a></li>
    </ul>
</li>
