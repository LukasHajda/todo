<html>
<head>

</head>
<body>

<div>
    <b>User:</b>
    {{ ucfirst($data['from']) }}
</div>

<div>
    <b>E-mail:</b>
    {{ $data['email'] }}
</div>

<br>

<h2>Subject:</h2>
New item is successfully finished.

<br>
<p>
    <b>{{ $data['item']->heading }}</b> is now successfully finished.
</p>

</body>
</html>