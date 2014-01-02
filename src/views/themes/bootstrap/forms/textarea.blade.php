<div class="control-group {{{ $class }}} {{ $errors->has($id) ? 'error' : false }}">
	<label for="{{ $id }}" class="control-label">{{ $text }} {{ $required ? '<span class="required-red">*</span>' : ''}}</label>
	<div class="controls">
		<textarea name="{{ $id }}" id="{{ $id }}" cols="30" rows="10" {{ $disabled ? 'readonly' : '' }}>{{ $value }}</textarea>
		@if ($helpText)
			<span class='help-block'>{{ $helpText }}</span>
		@endif
		@foreach($errors->get($id) as $message)
			{{ "<span class='help-block'>$message</span>" }}
		@endforeach
	</div>
</div>