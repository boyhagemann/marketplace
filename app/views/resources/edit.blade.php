<h1>Create resource</h1>

{{ Form::model($resource, array('route' => array('resource.update', $resource->getIdentifier()), 'method' => 'PUT')) }}
{{ Form::text('name') }}
{{ Form::text('uri') }}
{{ Form::select('method', array('GET' => 'GET', 'POST' => 'POST', 'PUT' => 'PUT', 'DELETE' => 'DELETE', 'HEAD' => 'HEAD', 'OPTIONS' => 'OPTIONS')) }}
{{ Form::submit() }}
{{ Form::close() }}