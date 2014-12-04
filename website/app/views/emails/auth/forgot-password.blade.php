<!DOCTYPE html>
<html lang="en-US">
<head>
  <meta charset="utf-8">
</head>
<body>
  <p>Hello {{ $user->first_name }},</p>

  <p>Please click on the following link to updated your password:</p>

  <p><a href="{{ $forgotPasswordUrl }}">{{ $forgotPasswordUrl }}</a></p>
  <p>Best regards</p>
  
</div>
</body>
</html>