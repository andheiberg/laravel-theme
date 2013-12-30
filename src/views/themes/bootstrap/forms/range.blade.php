<div class="control-group {{ $errors->has($id) ? 'error' : false }}">
	<label for="{{ $id }}" class="control-label">{{ $text }} {{ $required ? '<span class="required-red">*</span>' : ''}}</label>
	<div class="controls">
		<input type="range" id="{{{ $id }}}" name="{{{ $id }}}" min="{{{ $min }}}" max="{{{ $max }}}">
		@foreach($errors->get($id) as $message)
			{{ "<span class='help-inline'>$message</span>" }}
		@endforeach
	</div>
</div>