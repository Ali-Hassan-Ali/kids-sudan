@if (!empty($breadcrumb) && isset($breadcrumb))
    
    <ul class="breadcrumb mt-2">

        <li class="breadcrumb-item"><a class="back-page" href="{{ route('dashboard.admin.index') }}">@lang('admin.global.home')</a></li>

        @foreach ($breadcrumb as $item)
            <li class="breadcrumb-item">
                @if (isset($item['route']))

                    @if ($item['route'] !== "#")
                        
                        <a class="back-page" href="{{ route($item['route']) }}">
                            {{ trans($item['trans']) }}
                        </a>

                    @else

                        {{ trans($item['trans']) }}

                    @endif

                @else

                    {{ trans($item['trans']) }}

                @endif
            </li>
            
        @endforeach
        
    </ul>

@endif