<?php
	isset($options['class']) ? $options['class'] .= ' form-horizontal' : $options['class'] = 'form-horizontal';
 ?>

{{ Form::open($options) }}
<!-- Content -->
{{ Form::close() }}