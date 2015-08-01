<div class="form-group {{ $class }} {{ $errors->has($id) ? 'has-error' : false }}">
	<label for="{{ $id }}" class="control-label">{{ $text }} {{ $required ? '<span class="required-red">*</span>' : ''}}</label>
	<div class="form-controls">
		<input type="range" id="{{{ $id }}}" name="{{{ $id }}}" min="{{{ $min }}}" max="{{{ $max }}}" {{ $disabled ? 'readonly' : '' }}>
		@foreach($errors->get($id) as $message)
			{{ "<span class='help-block'>$message</span>" }}
		@endforeach
	</div>
</div>