<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Iniciar Sesión</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/login.css') }}" />
  </head>
  <body>
    <div class="container">
      {{-- Formulario de LOGIN FUNCIONAL --}}
      <div class="form-box login">
        <form method="POST" action="{{ route('login') }}">
          @csrf
          <h1>Acceso</h1>

          {{-- Errores de validación --}}
          @if ($errors->any())
              <div class="error-message" style="color: red; margin-bottom: 1rem;">
                  {{ $errors->first() }}
              </div>
          @endif

          <div class="input-box">
            <input type="email" name="email" placeholder="Correo electrónico" required value="{{ old('email') }}" />
            <i class="bx bxs-user"></i>
          </div>
          <div class="input-box">
            <input type="password" name="password" placeholder="Contraseña" required />
            <i class="bx bxs-lock-alt"></i>
          </div>
          <div class="forgot-link">
            <a href="{{ route('password.request') }}">¿Has olvidado la contraseña?</a>
          </div>
          <button type="submit" class="btn">Acceso</button>
          <p>o iniciar sesión con plataformas sociales</p>
          <div class="social-icons">
            <a href="#"><i class="bx bxl-google"></i></a>
            <a href="#"><i class="bx bxl-facebook"></i></a>
            <a href="#"><i class="bx bxl-github"></i></a>
            <a href="#"><i class="bx bxl-linkedin"></i></a>
          </div>
        </form>
      </div>

      {{-- Formulario de REGISTRO ACTIVO --}}
      <div class="form-box register">
        <form method="POST" action="{{ route('register') }}">
          @csrf
          <h1 style="font-size: 28px;">Registro</h1>

          {{-- Errores de validación --}}
          @if ($errors->any())
              <div class="error-message" style="color: red; margin-bottom: 1rem; font-size: 12px;">
                  @foreach ($errors->all() as $error)
                      <div>{{ $error }}</div>
                  @endforeach
              </div>
          @endif

          <div class="input-box" style="margin: 20px 0;">
            <input type="text" name="name" placeholder="Nombre completo" required value="{{ old('name') }}" style="padding: 10px 45px 10px 15px; font-size: 14px;" />
            <i class="bx bxs-user" style="font-size: 18px;"></i>
          </div>
          <div class="input-box" style="margin: 20px 0;">
            <input type="email" name="email" placeholder="Correo electrónico" required value="{{ old('email') }}" style="padding: 10px 45px 10px 15px; font-size: 14px;" />
            <i class="bx bxs-envelope" style="font-size: 18px;"></i>
          </div>
          <div class="input-box" style="margin: 20px 0;">
            <input type="password" name="password" placeholder="Contraseña" required style="padding: 10px 45px 10px 15px; font-size: 14px;" />
            <i class="bx bxs-lock-alt" style="font-size: 18px;"></i>
          </div>
          <div class="input-box" style="margin: 20px 0;">
            <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required style="padding: 10px 45px 10px 15px; font-size: 14px;" />
            <i class="bx bxs-lock-alt" style="font-size: 18px;"></i>
          </div>
          <button type="submit" class="btn" style="height: 42px; font-size: 14px;">Registrarse</button>
          <p style="font-size: 12px; margin: 10px 0;">o registrarse con plataformas sociales</p>
          <div class="social-icons">
            <a href="#" style="padding: 8px; font-size: 20px;"><i class="bx bxl-google"></i></a>
            <a href="#" style="padding: 8px; font-size: 20px;"><i class="bx bxl-facebook"></i></a>
            <a href="#" style="padding: 8px; font-size: 20px;"><i class="bx bxl-github"></i></a>
            <a href="#" style="padding: 8px; font-size: 20px;"><i class="bx bxl-linkedin"></i></a>
          </div>
        </form>
      </div>

      {{-- Panel de animación --}}
      <div class="toggle-box">
        <div class="toggle-panel toggle-left">
          <h1>¡Hola, Bienvenido!</h1>
          <p>¿No tienes una cuenta?</p>
          <button class="btn register-btn">Registro</button>
        </div>

        <div class="toggle-panel toggle-right">
          <h1>¡Bienvenido de Nuevo!</h1>
          <p>¿Ya tienes una cuenta?</p>
          <button class="btn login-btn">Login</button>
        </div>
      </div>
    </div>

    <script src="{{ asset('js/login.js') }}"></script>
  </body>
</html>
