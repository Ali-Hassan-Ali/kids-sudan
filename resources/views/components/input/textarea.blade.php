<div class="{{ $col }}" id="{{ $id }}-hidden" {{ $hidden ? 'hidden' : '' }}>
    <div class="form-group">
        @if(!empty($label))
            <label for="{{ $id }}">{{ trans($label) }} @if($required)<span class="text-danger">*</span>@endif</label>
        @endif
        <textarea id="{{ $id }}" {{ $readonly ? 'readonly' : '' }} {{ $disabled ? 'disabled' : '' }} class="form-control {{ $ckeditor ? 'ckeditor' : '' }} @error(!empty($invalid) ? $invalid : $name) is-invalid @enderror" name="{{ $name }}" rows="{{ $rows }}">{!! old($name, $value) !!}</textarea>
        @error(!empty($invalid) ? $invalid : $name)
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>