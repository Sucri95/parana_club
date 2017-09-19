<html>
<body>

<p><br/><strong>{{$user->name}} {{$user->last_name}}</strong>,</p>

<p>Has solicitado recuperar tu contraseña</p>
<p>Hacé click en el siguiente enlace para confirmar:</p>
<a href="http://localhost:8000/mobile/reset_password?id={{$user->id}}&token={{$topica['especificaciones']}}">http://localhost:8000/reset_password?token=<?php echo $topica['especificaciones']; ?></a>

<p>Saludos,</p>

<p><strong>Paraná Club</strong></p>

</body>
</html>

 

	

	

