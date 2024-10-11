<div class="{{ $col }}" id="{{ $id }}-hidden" {{ $hidden ? 'hidden' : '' }}>
    @if($label)
        <label class="form-check-label" for="{{ $id }}">{{ trans($label) }}</label>
    @endif
    <div class="form-group ml-3">
        <div class="form-check form-switch pe-auto">
            <input type="hidden" name="{{ $name }}" value="0" id="{{ $id }}-status-hidden">
            <input {{ $readonly ? 'readonly' : '' }} {{ $disabled ? 'disabled' : '' }} class="form-check-input" id="{{ $id }}" type="checkbox" name="{{ $name }}" value="{{ $value }}" {{ old($old, $value ?? false) ? 'checked' : '' }} {{ $disabled ? 'disabled=disabled' : '' }}>
        </div>
    </div>
</div>