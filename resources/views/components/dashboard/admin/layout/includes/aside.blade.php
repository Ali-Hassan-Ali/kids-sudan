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

        @if(permissionAdmin('read-banner') || permissionAdmin('read-skills') || permissionAdmin('read-tools'))
            {{-- managements --}}

            <x-dashboard.admin.layout.includes.slider.menu-group-item trans="admin.models.websites" svg="websites" show="dashboard.admin.websites.*">
                    
                <x-dashboard.admin.layout.includes.slider.menu-item trans="admin.websites.banner" active="dashboard.admin.websites.banner.*" route="dashboard.admin.websites.banner.index" permission="read-banner"/>

                <x-dashboard.admin.layout.includes.slider.menu-item trans="admin.models.faqs" active="dashboard.admin.websites.faqs.*" route="dashboard.admin.websites.faqs.index" permission="read-faqs"/>

                <x-dashboard.admin.layout.includes.slider.menu-item trans="admin.websites.banners.skills" active="dashboard.admin.websites.skills.*" route="dashboard.admin.websites.skills.index" permission="read-skills"/>

                <x-dashboard.admin.layout.includes.slider.menu-item trans="admin.websites.tools" active="dashboard.admin.websites.tools.*" route="dashboard.admin.websites.tools.index" permission="read-tools"/>

                <x-dashboard.admin.layout.includes.slider.menu-item trans="admin.models.creatives" active="dashboard.admin.websites.creatives.*" route="dashboard.admin.websites.creatives.index" permission="read-creatives"/>

                <x-dashboard.admin.layout.includes.slider.menu-item trans="admin.models.clients" active="dashboard.admin.websites.clients.*" route="dashboard.admin.websites.clients.index" permission="read-clients"/>

                <x-dashboard.admin.layout.includes.slider.menu-item trans="admin.models.volunteerings" active="dashboard.admin.websites.volunteerings.*" route="dashboard.admin.websites.volunteerings.index" permission="read-volunteerings"/>

                <x-dashboard.admin.layout.includes.slider.menu-item trans="admin.models.services" active="dashboard.admin.websites.services.*" route="dashboard.admin.websites.services.index" permission="read-services"/>

            </x-dashboard.admin.layout.includes.slider.menu-group-item>

        @endif

        @if(permissionAdmin('read-settings'))
            {{-- settings --}}

            <x-dashboard.admin.layout.includes.slider.menu-group-item trans="admin.models.settings" svg="settings" show="dashboard.admin.settings.*">
                    
                <x-dashboard.admin.layout.includes.slider.menu-item trans="admin.settings.meta" active="dashboard.admin.settings.meta.*" route="dashboard.admin.settings.meta.index" permission="read-settings"/>

                <x-dashboard.admin.layout.includes.slider.menu-item trans="admin.settings.websit" active="dashboard.admin.settings.websit.*" route="dashboard.admin.settings.websit.index" permission="read-settings"/>

                <x-dashboard.admin.layout.includes.slider.menu-item trans="admin.settings.media" active="dashboard.admin.settings.media.*" route="dashboard.admin.settings.media.index" permission="read-settings"/>

                <x-dashboard.admin.layout.includes.slider.menu-item trans="admin.settings.contact" active="dashboard.admin.settings.contact.*" route="dashboard.admin.settings.contact.index" permission="read-settings"/>

            </x-dashboard.admin.layout.includes.slider.menu-group-item>

        @endif

        @auth('admin')
            {{-- settings --}}
            <x-dashboard.admin.layout.includes.slider.menu-group-item trans="admin.models.profiles" svg="profiles" show="dashboard.admin.auth.accounts.*">
                    
                <x-dashboard.admin.layout.includes.slider.menu-item trans="admin.auth.edit_password" active="dashboard.admin.auth.accounts.profile.*" route="dashboard.admin.auth.accounts.profile.edit" permission="read-home"/>

                <x-dashboard.admin.layout.includes.slider.menu-item trans="admin.auth.edit_profile" active="dashboard.admin.auth.accounts.password.*" route="dashboard.admin.auth.accounts.password.edit" permission="read-home"/>
                

            </x-dashboard.admin.layout.includes.slider.menu-group-item>

        @endauth

    </ul>
</aside>
