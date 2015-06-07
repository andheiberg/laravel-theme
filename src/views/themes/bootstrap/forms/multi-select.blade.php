<?php $associative = is_array($data) ? is_associative($data) : false; ?>

<div class="form-group {{ $class }} {{ $errors->has($id) ? 'has-error' : false }}">
	<label class="control-label" for="{{{ $id }}}[]">{{{ $text }}} {{ $required ? '<span class="required-red">*</span>' : ''}}</label>
	<div class="form-controls">
		<select class="form-control" multiple id="{{{ $id }}}[]" name="{{{ $id }}}[]" {{ $disabled ? 'readonly' : '' }}>
			<option value="">-- {{{ $text }}} --</option>
			@foreach( $data as $dKey => $d )
				@if ( is_object($d) )
					<option value="{{{ $d->id }}}" {{{ theme_compare_values($d->id, $value) ? 'selected' : '' }}}>{{{ $d->name }}}</option>
				@elseif ( $associative )
					<option value="{{{ $dKey }}}" {{{ theme_compare_values($dKey, $value) ? 'selected' : '' }}}>{{{ $d }}}</option>
				@else
					<option value="{{{ $d }}}" {{{ theme_compare_values($d, $value) ? 'selected' : '' }}}>{{{ $d }}}</option>
				@endif
			@endforeach
		</select>
		@foreach($errors->get($id) as $message)
			{{ "<span class='help-block'>$message</span>" }}
		@endforeach
	</div>
</div>