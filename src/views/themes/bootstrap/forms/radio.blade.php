<div class="form-group {{ $errors->has($id) ? 'has-error' : false }}">
	<label class="control-label">{{{ $text }}} {{ $required ? '<span class="required-red">*</span>' : ''}}</label>
	<div class="form-controls">
		@foreach( $data as $dKey => $d )
			@if ( is_object($d) )
				<?php $checked = ($d->id == $value or (int) $d->id == (int) $value); ?>
				<label class="radio inline">
					<input type="radio" name="{{{ $id }}}" value="{{{ $d->id }}}" {{{ $checked ? 'checked' : '' }}} {{ $disabled ? 'readonly' : '' }}>
					{{{ $d->name }}}
				</label>
			@else
				<?php $checked = ($dKey == $value or (int) $dKey == (int) $value); ?>
				<label class="radio inline">
					<input type="radio" name="{{{ $id }}}" value="{{{ $dKey }}}" {{{ $checked ? 'checked' : '' }}} {{ $disabled ? 'readonly' : '' }}>
					{{{ $d }}}
				</label>
			@endif
		@endforeach
		@if ($helpText)
			<span class='help-block'>{{ $helpText }}</span>
		@endif
		@foreach($errors->get($id) as $message)
			<span class='help-block'>{{ $message }}</span>
		@endforeach
	</div>
</div>