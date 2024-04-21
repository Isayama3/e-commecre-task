<div class="form-group mb-3">
    <label class="mb-1" for="{{ $name }}">{{ __('admin.' . $label) }}</label>
    <textarea class="form-control" id="{{ $name }}" rows="5" cols="50" spellcheck="false" data-ms-editor="true" placeholder="{{ __('admin.' . $label) }}"
        placeholder="{{ $placeholder ? __('admin.' . $placeholder) : __('admin.' . $label) }}"
        {{ $disabled == true ? 'disabled' : '' }}>{{ $value ?? old($name) }}</textarea>
    <span class="help-block"><strong id="{{ $name }}_error">{{ $errors->first($name) }}</strong></span>
</div>
