<html>
<head>

</head>
<body>
<h2>Subject:</h2>
Item <b>{{ $data['heading'] }}</b>is shared between:
<br>
<p>
    @foreach($data['usernames'] as $username)
        <b>{{ $username }}</b><br>
    @endforeach
</p>

</body>
</html>