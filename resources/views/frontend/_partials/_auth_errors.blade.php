@if($errors->has($error_name))
    <span class="error-message">{{ $errors->first($error_name) }}</span>
@endif