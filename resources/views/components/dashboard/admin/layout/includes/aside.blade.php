<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>

<aside class="app-sidebar" style="::-webkit-scrollbar-track {box-shadow: inset 0 0 5px grey;border-radius: 10px;}">
    <div class="app-sidebar__user">
        <img class="app-sidebar__user-avatar" src="{{ auth('admin')->user()->image_path }}" alt="User Image">
        <div>
            <h2 class="app-sidebar__user-name">{{ auth('admin')->user()->name }}</p>
            <p class="app-sidebar__user-designation">{{ auth('admin')->user()->roles->first()->name }}</p>
        </div>
    </div>

    <ul class="app-menu">

        <x-dashboard.admin.layout.includes.slider.menu-item trans="admin.global.dashboard" active="dashboard.admin.index" route="dashboard.admin.index" svg="dashboard" permission="read-home"/>


        @if(permissionAdmin('read-admins') || permissionAdmin('read-roles') || permissionAdmin('read-languages'))
            {{-- managements --}}

            <x-dashboard.admin.layout.includes.slider.menu-group-item trans="admin.models.managements" svg="managements" show="dashboard.admin.managements.*">
                    
                <x-dashboard.admin.layout.includes.slider.menu-item trans="admin.models.admins" active="dashboard.admin.managements.admins.*" route="dashboard.admin.managements.admins.index" permission="read-admins"/>

                <x-dashboard.admin.layout.includes.slider.menu-item trans="admin.models.roles" active="dashboard.admin.managements.roles.*" route="dashboard.admin.managements.roles.index" permission="read-roles"/>

                <x-dashboard.admin.layout.includes.slider.menu-item trans="admin.models.languages" active="dashboard.admin.managements.languages.*" route="dashboard.admin.managements.languages.index" permission="read-languages"/>

            </x-dashboard.admin.layout.includes.slider.menu-group-item>

        @endif

    </ul>
</aside>
