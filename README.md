Theme
===

###A simple modular approach to theming created to blend in with Blade.
The concept is to split your theme up into modules that can be reused and changed easily. These modules are stored as simple view files in resources/views/vendor/theme. An example of a typical module could be a hero unit. You would store your hero model like so:

	+@form(['route' => 'auth.register'])
		+@formText('username', 'What do you want to be called?')->placeholder('darthvader')
		
		+@formPassword('password') // if you don't provide a label it will capitalize the key
		
		+@formHidden('awesomeness', 11)

		+@formSelect('gender', 'Your gender', ['Male', 'Female'])->required()

		+@formDate('born_at', 'Birthdate')
	-@form

It's especially powerful for forms. By default it will fill old values and show validation messages. It reduces view code by +10x for typical forms.

It can be used for anything though. Modules are easy to define.

	// resources/views/vendor/theme/hero.blade.php
	<div class="hero row {{ $class }}">
		<div class="column">

	<!-- Content -->

		</div>
	</div>

This module can then intern be used from a view like so:

	+@hero()
		<h1>It might be yet another twitter client, but this one is really nice</h1>
		<p>Seriously I mean it I wouldn't want to disapoint you, but it's amazing.</p>
	-@hero

As you can see the html comment ```<!-- Content -->``` seperates the start and ending of modules. If you choose to exclude this comment you could create a module like so:

	// app/views/theme/button.blade.php
	<a class="button {{ $class }}" href="{{ $link }}">{{ $text }}</a>

And use it like so (without an ending tag):

	+@button('url', 'text')

Also multiword modules are like so:

	// app/views/theme/page-header.blade.php
	<div class="page-header {{ $class }}">
	<!-- Content -->
	</div>

And called like so:

	+@pageHeader()
		<h1>Some header</h1>
	-@pageHeader

Why is this helpful?
---
* Easily change your markup site wide (this is really useful if you start prototyping with Bootstrap or Foundation and then want to use your own markup later)
* Easier to modify and understand than something like Former
* Easier to read (ever seen comments like ```<!-- end of hero -->```? well now the modules end is prefixed by ```-@``` so that should no longer be needed)


Installation
---
Add the following to your composer.json:

	"andheiberg/theme": "3.0.*" // "1.0.*" for Laravel 4.1 support, "2.0.*" for Laravel 4.2 support

Add Theme's service provider to your Laravel application in config/app.php. Add the following to the providers:

	Andheiberg\Theme\ThemeServiceProvider:class,
	Illuminate\Html\HtmlServiceProvider::class,

And to the aliases:

	'Form'      => Illuminate\Html\FormFacade::class,

If you would like to use another theme than default you would have to publish the settings and change the theme setting:

	php artisan vendor:publish --provider="Andheiberg\Theme\ThemeServiceProvider"
