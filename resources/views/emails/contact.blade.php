<!DOCTYPE html>
<html>
<head>
    <title>Nuevo mensaje de Contacto</title>
</head>
<body>
    <h1>Nuevo mensaje de contacto</h1>
    <p><strong>Nombre:</strong> {{ $data['name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Mensaje:</strong> {{ $data['message'] }}</p>
</body>
</html>