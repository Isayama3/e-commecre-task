<div class="form-group {{ $errors->has($name) ? 'is-invalid' : '' }}">
    <label class="mb-1" for="{{ $name }}">{{ __('admin.' . $label) }}</label>
    <div style="text-align: center;">
        <select class="choices form-select" name="{{ $name }}" data-placeholder="{{ $placeholder }}"
            {{ $disabled == true ? 'disabled' : '' }}>
            <option value="" disabled {{ empty($selected) ? 'selected' : '' }}>Please select...</option>
            @foreach ($options ?? [] as $key => $value)
                <option value="{{ $key }}" {{ $key == $selected ? 'selected' : '' }}>{{ $value }}
                </option>
            @endforeach
        </select>
    </div>
    <span class="help-block"><strong id="{{ $name }}_error">{{ $errors->first($name) }}</strong></span>
</div>
