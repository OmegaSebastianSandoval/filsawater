<div class="container-login">

  <div class="container  py-5">
    <div class="row  justify-content-center">
      <div class="col-12 col-md-9 col-lg-7">

        <div class="container-form-login shadow-sm p-5">

          <form class="form-contact" action="/page/login/login2" autocomplete="off" method="post" id="otpForm">
            <h2 class="text-white">Inicio de sesión FILSA WATER</h2>

            <p class="py-2 text-white text-center">
              Se ha enviado un código de verificación a su correo electrónico: <strong>

                <?php echo $this->email ?></strong> , por favor ingréselo a continuación.
            </p>
            <div class="otp-container">
              <input type="number" maxlength="1" class="otp-input" id="otp1" name="otp1">
              <input type="number" maxlength="1" class="otp-input" id="otp2" name="otp2">
              <input type="number" maxlength="1" class="otp-input" id="otp3" name="otp3">
              <input type="number" maxlength="1" class="otp-input" id="otp4" name="otp4">
              <input type="number" maxlength="1" class="otp-input" id="otp5" name="otp5">
              <input type="number" maxlength="1" class="otp-input" id="otp6" name="otp6">
            </div>
            <input type="hidden" name="email" value="<?php echo $this->emailHidden ?>">
            <button class="btn-blue border-0 mx-auto mt-4" id="btn-sumbit-opt">Iniciar sesión</button>

            <div class="container-newaccount mt-4">
              <span></span> <a href="/page/login">Volver al login</a>
            </div>
          </form>

        </div>
      </div>

    </div>

  </div>
</div>
<style>
  .main-general {
    min-height: auto;
    background-color: #f5f5f5;
    display: grid;
    place-items: center;
    /* height: calc(100dvh - 400px); */
  }

  /* footer{
  bottom: 0;
  position: fixed;
} */
  .otp-input {
    -moz-appearance: textfield;
    /* Para Firefox */
    -webkit-appearance: none;
    /* Para Chrome, Safari y Edge */
    appearance: none;
    /* Para navegadores modernos que soporten 'appearance' */

  }

  input[type="number"]::-webkit-inner-spin-button,
  input[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  @media (width >2500px) {
    .main-general {
      /* height: calc(100dvh - 400px) !important; */
    }
    footer{
      bottom: 0;
      position: fixed;
    }
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const inputs = document.querySelectorAll('.otp-input');
    const btnOpt = document.getElementById('btn-sumbit-opt'); // Botón de envío

    inputs.forEach((input, index) => {
      // Manejar la entrada de datos
      input.addEventListener('input', () => {
        // Mover al siguiente input si se ingresa un valor y no es el último campo
        if (input.value.length === 1 && index < inputs.length - 1) {
          inputs[index + 1].focus();
        }

        // Ejecutar el formulario cuando se complete el último campo
        if (index === inputs.length - 1 && input.value.length === 1) {
          btnOpt.click(); // Simula el clic en el botón de envío
        }
      });

      // Manejar el retroceso con "Backspace"
      input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace') {
          if (input.value === '' && index > 0) {
            inputs[index - 1].focus();
          } else {
            input.value = ''; // Limpia el valor actual
          }
        }
      });

      // Manejar el pegado de texto completo
      input.addEventListener('paste', (e) => {
        const paste = (e.clipboardData || window.clipboardData).getData('text');
        if (paste.length === inputs.length) {
          for (let i = 0; i < inputs.length; i++) {
            inputs[i].value = paste[i] || ''; // Manejar texto pegado
          }
          e.preventDefault();
          btnOpt.click(); // Enviar formulario si se pega el texto completo
        }
      });
    });
  });
</script>