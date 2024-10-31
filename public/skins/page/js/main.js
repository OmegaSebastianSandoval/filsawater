const videos = [];
$(document).ready(function () {
  $(".dropdown-toggle").dropdown();
  $(".carouselsection").carousel({
    quantity: 4,
    sizes: {
      900: 3,
      500: 1,
    },
  });

  $(".banner-video-youtube").each(function () {
    const datavideo = $(this).attr("data-video");
    const idvideo = $(this).attr("id");
    const playerDefaults = {
      autoplay: 0,
      autohide: 0,
      modestbranding: 0,
      rel: 0,
      showinfo: 0,
      disablekb: 1,
      enablejsapi: 1, // Cambia a 1 para habilitar la API de JavaScript de YouTube
      iv_load_policy: 3,
      controls: 1,
      fs: 1,
    };

    videos.push(
      new YT.Player(idvideo, {
        videoId: datavideo,
        playerVars: playerDefaults,
        events: {
          onReady: onAutoPlay,
          onStateChange: onFinish,
        },
      })
    );
  });

  function onAutoPlay(event) {
    event.target.playVideo();
    //event.target.mute(); // Mute el video automáticamente
  }

  function onFinish(event) {
    if (event.data === YT.PlayerState.ENDED) {
      // Usar constante para estado "ENDED"
      event.target.playVideo();
    }
  }

  // Función llamada cuando la API de YouTube está lista
  function onYouTubeIframeAPIReady() {
    $(".banner-video-youtube").each(function () {
      // Aquí se puede colocar el código de inicialización si es necesario
    });
  }

  const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
  );
  const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
  );
});

document.addEventListener("DOMContentLoaded", () => {
  $(".counter").counterUp({
    triggerOnce: false,
  });

  const animaciones = [
    "fade-up",
    "fade-down",
    "fade-left",
    "fade-right",
    "zoom-in",
    "zoom-out",
    "flip-left",
    "flip-right",
  ];
  document.querySelectorAll("[data-aos]").forEach((element) => {
    const animacionAleatoria =
      animaciones[Math.floor(Math.random() * animaciones.length)];
    element.setAttribute("data-aos", animacionAleatoria);
  });

  AOS.init({
    // once: true,
    duration: 500,
  });

  document
    .getElementById("form-contact")
    ?.addEventListener("submit", function (e) {
      e.preventDefault();
      const response = grecaptcha.getResponse();
      if (response.length === 0) {
        Swal.fire({
          icon: "warning",
          text: "Por favor, verifica que no eres un robot.",
          confirmButtonColor: "#192a4b",
          confirmButtonText: "Continuar",
        });
      } else {
        $(".loader-bx").addClass("show");

        let submitBtn = document.getElementById("submit-btn");
        // Deshabilitar botón y mostrar animación
        submitBtn.disabled = true;

        let formData = new FormData(this);
        let data = {};
        formData.forEach((value, key) => {
          data[key] = value;
        });

        // console.log(data);

        fetch(this.getAttribute("action"), {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(data),
        })
          .then((response) => response.json())
          .then((data2) => {
            // console.log("Status:", data2.status); // Verifica el valor exacto

            if (data2.status.trim().toLowerCase() === "success") {
              Swal.fire({
                icon: "success",
                text: "Hemos recibido tu mensaje, te responderemos a la brevedad.",
                confirmButtonColor: "#192a4b",
                confirmButtonText: "Continuar",
              });
            } else if (data2.status === "error") {
              Swal.fire({
                icon: "error",
                text: "Ha ocurrido un error, por favor intenta de nuevo.",
                confirmButtonColor: "#192a4b",
                confirmButtonText: "Continuar",
              });
            }
            document.getElementById("form-contact").reset();
            // Habilitar botón y ocultar animación
            submitBtn.disabled = false;
            $(".loader-bx").removeClass("show");
          })

          .catch((error) => {
            // console.log("Error:", error);

            Swal.fire({
              icon: "error",
              text: "Ha ocurrido un error, por favor intenta de nuevo.",
              confirmButtonColor: "#192a4b",
              confirmButtonText: "Continuar",
            });
            // Habilitar botón y ocultar animación
            submitBtn.disabled = false;
            $(".loader-bx").removeClass("show");
          });
      }
    });

  document
    .getElementById("emailForm")
    ?.addEventListener("submit", function (event) {
      event.preventDefault(); // Evita el envío normal del formulario

      // Mostrar animación de carga
      $(".loader-bx").addClass("show");

      let formData = new FormData(this);

      // Validación del email en el lado del cliente
      let email = formData.get("email");
      // console.log(email);
      if (!validateEmail(email)) {
        alert("Por favor, introduce un correo electrónico válido.");
        $(".loader-bx").removeClass("show");
        return;
      }

      // Convertir FormData a JSON
      let data = {};
      formData.forEach((value, key) => {
        data[key] = value;
      });

      // Enviar los datos por fetch
      fetch(this.getAttribute("action"), {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-Requested-With": "XMLHttpRequest",
        },
        body: JSON.stringify(data),
      })
        .then((response) => response.json())
        .then((data2) => {
          $(".loader-bx").removeClass("show");

          if (data2.success) {
            Swal.fire({
              icon: "success",
              text: data2.message,
              confirmButtonColor: "#00b8c3",
              confirmButtonText: "Continuar",
            });
            // Limpiar el formulario si es necesario
            document.getElementById("emailForm").reset();
          } else {
            Swal.fire({
              icon: "error",
              text: data2.message,
              confirmButtonColor: "#00b8c3",
              confirmButtonText: "Continuar",
            });
          }
        })
        .catch((error) => {
          $(".loader-bx").removeClass("show");

          Swal.fire({
            icon: "error",
            text: "Hubo un error al enviar el correo.",
            confirmButtonColor: "#00b8c3",
            confirmButtonText: "Continuar",
          });
          console.error("Error:", error);
        });
    });

  // Función para validar el email en el lado del cliente
  function validateEmail(email) {
    var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
  }

  // Función para alternar la visibilidad de la contraseña
  document.querySelectorAll(".toggle-password").forEach((button) => {
    button.addEventListener("click", () => {
      const input = button
        .closest(".container-password")
        .querySelector('input[type="password"], input[type="text"]');
      if (input) {
        input.type = input.type === "password" ? "text" : "password";
        button.querySelector("i").classList.toggle("fa-eye"); // Cambia icono
        button.querySelector("i").classList.toggle("fa-eye-slash"); // Alterna con el icono de ocultar
      }
    });
  });
});
