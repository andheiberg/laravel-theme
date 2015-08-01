<div class="form-group {{ $class }} {{ $errors->has($id) ? 'has-error' : false }}">
	<label for="{{ $id }}" class="control-label">{{ $text }} {{ $required ? '<span class="required-red">*</span>' : ''}}</label>
	<div class="form-controls">
		<textarea class="form-control" name="{{ $id }}" id="{{ $id }}" cols="{{ $cols }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}" {{ $disabled ? 'readonly' : '' }}>{{ $value }}</textarea>
		@if ($helpText)
			<span class='help-block'>{{ $helpText }}</span>
		@endif
		@foreach($errors->get($id) as $message)
			{{ "<span class='help-block'>$message</span>" }}
		@endforeach
	</div>
</div>