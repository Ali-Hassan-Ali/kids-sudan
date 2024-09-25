<div class="{{ $col }}" id="{{ $name }}-hidden" {{ $hidden ? 'hidden' : '' }}>
    <div class="form-group">
        @if(!empty($label))
            <label for="{{ $name }}">{{ trans($label) }} @if($required)<span class="text-danger">*</span>@endif</label>
        @endif
        <select {{ $readonly ? 'readonly' : '' }} {{ $multiple ? 'multiple' : '' }} {{ $disabled ? 'disabled' : '' }} name="{{ $name }}" class="form-control select2 @error(!empty($invalid) ? $invalid : $name) is-invalid @enderror" id="{{ $name }}">
            {{-- <option value="" disabled>@lang('admin.global.choose')</option> --}}
            @foreach($lists as $key=>$list)
                <option selected="selected">orange</option>
  <option>white</option>
  <option selected="selected">purple</option>
            @endforeach
        </select>
        @error(!empty($invalid) ? $invalid : $name)
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>