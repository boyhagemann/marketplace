<h1>Resources</h1>

@foreach($resources as $resource)
<article>
	<header>
		<h1>{{{ $resource['name'] }}}</h1>
		<h2>ID: {{{ $resource['key'] }}}</h2>
	</header>
	<pre>{{{ $resource['method'] }}} {{{ $resource['uri'] }}}</pre>
    <a href="{{ URL::route('resource.edit', $resource->getIdentifier()) }}">Edit</a>
    
    {{ Form::open(array('route' => array('resource.destroy', $resource->getIdentifier()), 'method' => 'DELETE')) }}
    {{ Form::submit('Delete') }}
    {{ Form::close() }}
</article>
@endforeach

<section>
    <a href="{{ URL::route('resource.create') }}">Create resource</a>
</section>