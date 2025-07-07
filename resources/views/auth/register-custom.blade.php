<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registro</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/login.css') }}" />
  </head>
  <body>
    <div class="container active">
      {{-- Formulario de LOGIN (oculto en registro) --}}
      <div class="form-box login" style="display: none;">
        {{-- Formulario de login oculto --}}
      </div>

      {{-- Formulario de REGISTRO ACTIVO --}}
      <div class="form-box register">
        <form method="POST" action="{{ route('register') }}">
          @csrf
          <h1>Registro</h1>

          {{-- Errores de validación --}}
          @if ($errors->any())
              <div class="error-message" style="color: red; margin-bottom: 1rem;">
                  @foreach ($errors->all() as $error)
                      <div>{{ $error }}</div>
                  @endforeach
              </div>
          @endif

          <div class="input-box">
            <input type="text" name="name" placeholder="Nombre completo" required value="{{ old('name') }}" />
            <i class="bx bxs-user"></i>
          </div>
          <div class="input-box">
            <input type="email" name="email" placeholder="Correo electrónico" required value="{{ old('email') }}" />
            <i class="bx bxs-envelope"></i>
          </div>
          <div class="input-box">
            <input type="password" name="password" placeholder="Contraseña" required />
            <i class="bx bxs-lock-alt"></i>
          </div>
          <div class="input-box">
            <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required />
            <i class="bx bxs-lock-alt"></i>
          </div>
          <button type="submit" class="btn">Registrarse</button>
          <p>o registrarse con plataformas sociales</p>
          <div class="social-icons">
            <a href="#"><i class="bx bxl-google"></i></a>
            <a href="#"><i class="bx bxl-facebook"></i></a>
            <a href="#"><i class="bx bxl-github"></i></a>
            <a href="#"><i class="bx bxl-linkedin"></i></a>
          </div>
        </form>
      </div>

      {{-- Panel de animación --}}
      <div class="toggle-box">
        <div class="toggle-panel toggle-left">
          <h1>¡Hola, Bienvenido!</h1>
          <p>¿No tienes una cuenta?</p>
          <a href="{{ route('register') }}" class="btn register-btn" style="text-decoration: none; display: inline-block; text-align: center;">Registro</a>
        </div>

        <div class="toggle-panel toggle-right">
          <h1>¡Bienvenido de Nuevo!</h1>
          <p>¿Ya tienes una cuenta?</p>
          <a href="{{ route('login') }}" class="btn login-btn" style="text-decoration: none; display: inline-block; text-align: center;">Login</a>
        </div>
      </div>
    </div>

    <script src="{{ asset('js/login.js') }}"></script>
  </body>
</html>