<div class="{{ $col }}" id="{{ $id }}-hidden" {{ $hidden ? 'hidden' : '' }}>
    <div class="form-group">
        @if($label)
            <label for="{{ $id }}">{{ trans($label) }} @if($required)<span class="text-danger">*</span>@endif</label>
        @endif
        <select {{ $readonly ? 'readonly' : '' }} {{ $multiple ? 'multiple' : '' }} {{ $disabled ? 'disabled' : '' }} name="{{ $name }}" class="form-control select2 @error($invalid) is-invalid @enderror" id="{{ $id }}">
            @if($choose)
                <option value="" disabled>@lang('admin.global.choose')</option>
            @endif        

            @foreach($lists as $key=>$list)
                <option value="{{ $key }}" {{ $multiple ? (in_array($key, $value ?? []) ? 'selected' : '') : (old($old, $value) == $key ? 'selected' : '') }}>{{ $list }}</option>
            @endforeach
        </select>
        @error($invalid)
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>