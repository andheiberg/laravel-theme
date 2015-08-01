<?php
	isset($options['class']) ? $options['class'] .= ' form-inline' : $options['class'] = 'form-inline';
 ?>

{{ Form::open($options) }}
<!-- Content -->
{{ Form::close() }}