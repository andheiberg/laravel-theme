<div class="control-group {{ $errors->has($id) ? 'error' : false }}">
	<label class="control-label">{{{ $text }}} {{ $required ? '<span class="required-red">*</span>' : ''}}</label>
	<div class="controls">
		@foreach( $data as $dKey => $d )
			@if ( is_object($d) )
				<label class="radio inline">
					<input type="radio" name="{{{ $id }}}" value="{{{ $d->id }}}" {{{ $d->id == $value ? 'checked' : '' }}}>
					{{{ $d->name }}}
				</label>
			@else
				<label class="radio inline">
					<input type="radio" name="{{{ $id }}}" value="{{{ $dKey }}}" {{{ $dKey == $value ? 'checked' : '' }}}>
					{{{ $d }}}
				</label>
			@endif
		@endforeach
		@foreach($errors->get($id) as $message)
			<span class='help-inline'>{{ $message }}</span>
		@endforeach
	</div>
</div>