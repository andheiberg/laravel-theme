<?php $associative = is_array($data) ? is_associative($data) : false; ?>

<div class="form-group {{ $errors->has($id) ? 'has-error' : false }}">
	<label class="control-label" for="{{{ $id }}}">{{{ $text }}} {{ $required ? '<span class="required-red">*</span>' : ''}}</label>
	<div class="form-controls">
		<select id="{{{ $id }}}" name="{{{ $id }}}" {{ $disabled ? 'readonly' : '' }}>
			<option value="">-- {{{ $text }}} --</option>
			@foreach( $data as $dKey => $d )
				@if ( is_object($d) )
					<?php $checked = ($d->id == $value or (int) $d->id == (int) $value); ?>
					<option value="{{{ $d->id }}}" {{{ $checked ? 'selected' : '' }}}>{{{ $d->name }}}</option>
				@elseif ( $associative )
					<?php $checked = ($dKey == $value or (int) $dKey == (int) $value); ?>
					<option value="{{{ $dKey }}}" {{{ $checked ? 'selected' : '' }}}>{{{ $d }}}</option>
				@else
					<?php $checked = ($d == $value or (int) $d == (int) $value); ?>
					<option value="{{{ $d }}}" {{{ $checked ? 'selected' : '' }}}>{{{ $d }}}</option>
				@endif
			@endforeach
		</select>
		@foreach($errors->get($id) as $message)
			{{ "<span class='help-block'>$message</span>" }}
		@endforeach
	</div>
</div>