<div class="{{ $col }}" id="{{ $id }}-hidden" {{ $hidden ? 'hidden' : '' }}>
    <div class="form-group">
        @if(!empty($label))
            <label for="{{ $id }}">{{ trans($label) }} @if($required)<span class="text-danger">*</span>@endif</label>
        @endif
        <select {{ $readonly ? 'readonly' : '' }} {{ $multiple ? 'multiple' : '' }} {{ $disabled ? 'disabled' : '' }} name="{{ $name }}" class="form-control select2 @error(!empty($invalid) ? $invalid : $name) is-invalid @enderror" id="{{ $id }}">
            @if ($choose)
                <option value="" disabled {{ $multiple ? '' : 'selected'; }}>@lang('admin.global.choose')</option>
            @endif
            @foreach($lists as $key=>$list)
            <option value="{{ $key }}" 
                @if($multiple)
                    {{ in_array($key, $value ?? []) ? 'selected' : '' }}
                @else
                    {{ old(!empty($invalid) ? $invalid : $name, $value) == $key ? 'selected' : '' }}
                @endif
                >{{ $list }}</option>
            @endforeach
        </select>
        @error(!empty($invalid) ? $invalid : $name)
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>