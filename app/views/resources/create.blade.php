<h1>Create resource</h1>

{{ Form::open(array('route' => 'resource.store')) }}
{{ Form::text('name') }}
{{ Form::text('uri') }}
{{ Form::select('method', array('GET' => 'GET', 'POST' => 'POST', 'PUT' => 'PUT', 'DELETE' => 'DELETE', 'HEAD' => 'HEAD', 'OPTIONS' => 'OPTIONS')) }}
{{ Form::submit() }}
{{ Form::close() }}