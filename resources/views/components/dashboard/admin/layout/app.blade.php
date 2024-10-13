<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ session('dir') }}">
<head>

    <title>{{ getTransSetting('websit_title', app()->getLocale()) . ' - ' . $title ?? '' }}</title>
    
    <x-dashboard.admin.layout.includes.meta/>

    <x-dashboard.admin.layout.includes.styles/>

    {{ $styles ?? '' }}

</head>

<body class="app sidebar-mini">

    <x-dashboard.admin.layout.includes.header/>

    <x-dashboard.admin.layout.includes.aside/>

    <main class="app-content">

        <x-dashboard.admin.layout.includes.session/>

        {{ $slot }}

    </main><!-- end of main -->


    <x-dashboard.admin.layout.includes.scripts/>

    {{ $scripts ?? '' }}

    {{-- {{ debug() }} --}}

</body>
</html>