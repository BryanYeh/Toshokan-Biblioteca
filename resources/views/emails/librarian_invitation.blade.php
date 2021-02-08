<h1>{{ $first_name }} {{ $last_name }}, you can now be a librarian</h1>
<p>Follow the link below to finish registering as a librarian:</p>
<h3><a href="{{ route('invitation', ['code' => $invitation_token, 'email'=> $email ]) }}">{{ route('invitation', ['code' => $invitation_token, 'email'=> $email ]) }}</a></h3>
