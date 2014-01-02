<?php $associative = is_array($data) ? is_associative($data) : false; ?>

<div class="control-group {{ $errors->has($id) ? 'error' : false }}">
	<label class="control-label" for="{{{ $id }}}">{{{ $text }}} {{ $required ? '<span class="required-red">*</span>' : ''}}</label>
	<div class="controls">
		<select id="{{{ $id }}}" name="{{{ $id }}}" {{ $disabled ? 'readonly' : '' }}>
			<option value="">-- choose a {{{ $text }}} --</option>
			@foreach( $data as $dKey => $d )
				@if ( is_object($d) )
					<option value="{{{ $d->id }}}" {{{ $d->id == $value ? 'selected' : '' }}}>{{{ $d->name }}}</option>
				@elseif ( $associative )
					<option value="{{{ $dKey }}}" {{{ $dKey == $value ? 'selected' : '' }}}>{{{ $d }}}</option>
				@else
					<option value="{{{ $d }}}" {{{ $d == $value ? 'selected' : '' }}}>{{{ $d }}}</option>
				@endif
			@endforeach
		</select>
		@foreach($errors->get($id) as $message)
			{{ "<span class='help-block'>$message</span>" }}
		@endforeach
	</div>
</div>