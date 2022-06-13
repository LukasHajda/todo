@if($errors->has($error_name))
    <span class="text-danger">{{ $errors->first($error_name) }}</span>
@endif