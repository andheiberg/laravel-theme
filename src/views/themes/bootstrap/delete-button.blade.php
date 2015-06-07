{{ Form::open(['url' => $url, 'method' => 'DELETE', 'class' => 'form-inline']) }}
	<input type="submit" class="btn btn-danger {{ $class }}" value="{{ $text }}">
{{ Form::close() }}