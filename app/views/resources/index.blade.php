<h1>Resources</h1>

@foreach($resources as $resource)
<article>
	<header>
		<h1>{{{ $resource['name'] }}}</h1>
		<h2>ID: {{{ $resource['key'] }}}</h2>
	</header>
	<pre>{{{ $resource['method'] }}} {{{ $resource['uri'] }}}</pre>
</article>
@endforeach