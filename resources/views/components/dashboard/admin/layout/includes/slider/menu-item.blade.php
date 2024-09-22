@if(permissionAdmin($permission))
    <li>
        <a class="treeview-item {{ request()->routeIs($active) ? 'active' : '' }}" href="{{ route($route) }}">
            <i class="icon fa fa-circle"></i>
            {{ trans($trans) }}
        </a>
    </li>
@endif