<div class="checkbox {{ $class }} {{ $errors->has($id) ? 'has-error' : false }}">
	<label for="{{ $id }}" class="control-label">
		<input type="checkbox" id="{{ $id }}" name="{{ $id }}" value="1" placeholder="{{ $placeholder }}" {{ $disabled ? 'readonly' : '' }} {{ $required ? 'required' : '' }}>
		Gavekortet har ingen udløbsdato {{ $required ? '<span class="required-red">*</span>' : ''}}
		@foreach($errors->get($id) as $message)
			<span class='help-block'>{{ $message }}</span>
		@endforeach
	</label>
</div>