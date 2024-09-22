{{-- <li class="treeview {{ request()->is('*managements*') ? 'is-expanded' : '' }}"> --}}
<li class="treeview {{ request()->routeIs($show) ? 'is-expanded' : '' }}">
    <a class="app-menu__item" href="#" data-toggle="treeview">
        <i class="app-menu__icon fa fa-user-circle"></i>
        <span class="app-menu__label">{{ trans($trans) }}</span>
        <i class="treeview-indicator fa fa-angle-right"></i>
    </a>
    <ul class="treeview-menu">
        
        {{ $slot }}

    </ul>
</li>