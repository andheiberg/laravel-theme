<div class="control-group {{ $errors->has($id) ? 'error' : false }}">
	<label class="control-label">{{{ $text }}} {{ $required ? '<span class="required-red">*</span>' : ''}}</label>
	<div class="controls">
		@foreach( $data as $dKey => $d )
			@if ( is_object($d) )
				<label class="radio inline">
					<input type="radio" name="{{{ $id }}}" value="{{{ $d->id }}}" {{{ $d->id == $value ? 'checked' : '' }}} {{ $disabled ? 'readonly' : '' }}>
					{{{ $d->name }}}
				</label>
			@else
				<label class="radio inline">
					<input type="radio" name="{{{ $id }}}" value="{{{ $dKey }}}" {{{ $dKey == $value ? 'checked' : '' }}} {{ $disabled ? 'readonly' : '' }}>
					{{{ $d }}}
				</label>
			@endif
		@endforeach
		@foreach($errors->get($id) as $message)
			<span class='help-block'>{{ $message }}</span>
		@endforeach
	</div>
</div>