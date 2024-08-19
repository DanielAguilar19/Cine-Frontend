<!-- resources/views/login.blade.php -->
<html>
    <head>
    <style>
        .ref{
            
        }
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

        .login-form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-form .form-group {
            margin-bottom: 15px;    
        }

        .login-form label {
            font-weight: bold;
            color: #333333;
            display: block;
            margin-bottom: 5px;
        }

        .login-form .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            color: #333333;
            background-color: #fafafa;
            box-sizing: border-box;
        }

        .form-check{
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-check-label{
            margin: 0;
            padding: 0;
        }

        .login-form .form-control:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .login-form .form-text {
            font-size: 12px;
            color: #888888;
            margin-top: 5px;
        }

        .form-check-input{
            margin: 0;
        }

        .login-form .btn {
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

        .login-form .btn:hover {
            background-color: #0056b3;
        }
    </style>
    </head>
    <body>
        <form method="POST" action="/login" class="login-form">
            @csrf
            <div class="form-group">
                <label for="correo">Correo Electrónico</label>
                <input type="email" name="correo" class="form-control" required>
            </div>
    
            <div class="form-group">
                <label for="contrasenia">Contraseña</label>
                <input type="password" name="contrasenia" class="form-control" required>
            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="check">
                <label class="form-check-label" for="check">Check me out</label>
                <a class="ref" href="/registro">Registrarme</a>
            </div>

            <button type="submit" class="btn btn-primary">Ingresar</button>
        </form>
    </body>
</html>