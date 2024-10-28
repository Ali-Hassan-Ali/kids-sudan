<x-dashboard.admin.layout.app>

    <x-slot name="title">{{ trans('admin.global.dashboard') }}</x-slot>

    <h2>{{ trans('admin.global.dashboard') }}</h2>

    <x-dashboard.admin.layout.includes.breadcrumb :breadcrumb='$breadcrumb'/>
    
    <h2>Welcome 😊 <i class="fa fa-home" name="sunny-outline"></i></h2>
    <h2>Welcome 😊 <i class="bi bi-sun icon" name="sunny-outline"></i></h2>

</x-dashboard.admin.layout.app>