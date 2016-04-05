Hello, {{$user->username}}
	Click <a href="{{ url('acl/api/v1/users/reset/'.$token) }}">here</a> to reset your password