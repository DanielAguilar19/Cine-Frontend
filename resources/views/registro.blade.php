<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .register-form .form-group {
            margin-bottom: 15px;
        }

        .register-form label {
            font-weight: bold;
            color: #333333;
            display: block;
            margin-bottom: 5px;
        }

        .register-form .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            color: #333333;
            background-color: #fafafa;
            box-sizing: border-box;
        }

        .register-form .form-control:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .register-form .form-text {
            font-size: 12px;
            color: #888888;
            margin-top: 5px;
        }

        .register-form .form-check-input {
            margin-right: 10px;
        }

        .register-form .btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .register-form .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <form method="POST" action="{{ route('guardarCliente') }}" class="register-form">
        @csrf
        <div class="form-group">
            <label for="nombreCompleto">Nombre Completo</label>
            <input type="text" name="nombreCompleto" class="form-control" required>
        </div>
    
        <div class="form-group">
            <label for="clienteFrecuente">Cliente Frecuente</label>
            <input type="checkbox" name="clienteFrecuente" class="form-check-input">
        </div>
    
        <div class="form-group">
            <label for="fechaNacimiento">Fecha de Nacimiento</label>
            <input type="date" name="fechaNacimiento" class="form-control" required>
        </div>
    
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" name="telefono" class="form-control" required>
        </div>
    
        <div class="form-group">
            <label for="correo">Correo Electrónico</label>
            <input type="email" name="correo" class="form-control" required>
        </div>
    
        <div class="form-group">
            <label for="contrasenia">Contraseña</label>
            <input type="password" name="contrasenia" class="form-control" required>
        </div>
    
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>    
</body>
</html>
