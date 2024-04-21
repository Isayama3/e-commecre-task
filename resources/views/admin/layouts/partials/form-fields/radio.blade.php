<style>
    @media only screen and (min-width: 1024px) {
        #{{ $name }}_wrap {
            margin-top: 33px;
        }
    }
</style>

<div class="form-group {{ $errors->has($name) ? 'has-error' : '' }}" id="{{ $name }}_wrap">
    @if ($label)
        <label class="mb-1" for="{{ $name }}">{{ __('admin.' . $label) }}</label>
    @endif
    <div class="row">
        @foreach ($options as $key => $value)
            <div class="col-md-2">
                <div class="form-check {{ $errors->first($name) ? 'form-check-danger' : '' }}">
                    <div class="radio">
                        <input type="radio" id="{{ $key }}" class="form-check-input"
                            {{ $checked == $key ? 'checked' : '' }} value="{{ $key }}"
                            name="{{ $name }}" {{ $loop->first ? 'required' : '' }}>
                        <label for="{{ $key }}">{{ __('admin.' . $value) }}</label>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <span class="help-block"><strong
                id="{{ $name }}_error" class="text-danger">{{ $errors->first($name) }}</strong></span>
</div>
