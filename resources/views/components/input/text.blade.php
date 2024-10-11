<div class="{{ $col }}" id="{{ $id }}-hidden" {{ $hidden ? 'hidden' : '' }}>
    <div class="form-group">
        @if($label)
            <label for="{{ $id }}">{{ trans($label) }} @if($required)<span class="text-danger">*</span>@endif</label>
        @endif
        <input type="{{ $type }}" name="{{ $name }}" {{ $readonly ? 'readonly' : '' }} {{ $disabled ? 'disabled' : '' }} id="{{ $id }}" autofocus class="form-control @error($invalid) is-invalid @enderror" value="{{ old($old, $value) }}">
        @error($invalid)
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>