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

  /* ------------------------------------------------------ */
  /* --------------------- FORMULARIO CONTACTO---------------- */
  /* ------------------------------------------------------ */
  document
    .getElementById("form-contact")
    ?.addEventListener("submit", function (e) {
      e.preventDefault();
      const response = grecaptcha.getResponse();
      if (response.length === 0) {
        Swal.fire({
          icon: "warning",
          text: "Por favor, verifica que no eres un robot.",
          confirmButtonColor: "#5475a1",
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
                confirmButtonColor: "#5475a1",
                confirmButtonText: "Continuar",
              });
            } else if (data2.status === "error") {
              Swal.fire({
                icon: "error",
                text: "Ha ocurrido un error, por favor intenta de nuevo.",
                confirmButtonColor: "#5475a1",
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
              confirmButtonColor: "#5475a1",
              confirmButtonText: "Continuar",
            });
            // Habilitar botón y ocultar animación
            submitBtn.disabled = false;
            $(".loader-bx").removeClass("show");
          });
      }
    });

  /* ------------------------------------------------------ */
  /* --------------------- FORMULARIO CONTACTO---------------- */
  /* ------------------------------------------------------ */

  /* ------------------------------------------------------ */
  /* --------------------- FORMULARIO REGISTRO DE CORREOS ---------------- */
  /* ------------------------------------------------------ */
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
  /* ------------------------------------------------------ */
  /* --------------------- FORMULARIO REGISTRO DE CORREOS ---------------- */
  /* ------------------------------------------------------ */

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

  /* ------------------------------------------------------ */
  /* --------------------- FORMULARIO LOGIN ---------------- */
  /* ------------------------------------------------------ */

  document
    .getElementById("form-login")
    ?.addEventListener("submit", function (e) {
      e.preventDefault();

      const response = grecaptcha.getResponse();
      if (response.length === 0) {
        Swal.fire({
          icon: "warning",
          text: "Por favor, verifica que no eres un robot.",
          confirmButtonColor: "#5475a1",
          confirmButtonText: "Continuar",
        });
      } else {
        $(".loader-bx").addClass("show");

        let submitBtn = document.getElementById("submit-login");
        // Deshabilitar botón y mostrar animación
        submitBtn.disabled = true;

        let formData = new FormData(this);
        let data = {};
        formData.forEach((value, key) => {
          data[key] = value;
        });

        console.log(data);

        fetch(this.getAttribute("action"), {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(data),
        })
          .then((response) => response.json())
          .then((data2) => {
            console.log(data2); // Verifica el valor exacto

            if (data2.status.trim().toLowerCase() === "success") {
              Swal.fire({
                icon: "success",
                text: "Bienvenido.",
                confirmButtonColor: "#5475a1",
                confirmButtonText: "Continuar",
              }).then(() => {
                // Redirigir a otra página si es necesario
                window.location.href = data2.redirect;
              });
            } else if (data2.status === "error") {
              Swal.fire({
                icon: "error",
                text: data2.error,
                confirmButtonColor: "#5475a1",
                confirmButtonText: "Continuar",
              }).then((result) => {
                if (data2.error == "Captcha incorrecto") {
                  window.location.reload();
                }
              });
            }
            // document.getElementById("form-contact").reset();
            // Habilitar botón y ocultar animación
            submitBtn.disabled = false;
            $(".loader-bx").removeClass("show");
          })

          .catch((error) => {
            // console.log("Error:", error);

            Swal.fire({
              icon: "error",
              text: "Ha ocurrido un error, por favor intenta de nuevo.",
              confirmButtonColor: "#5475a1",
              confirmButtonText: "Continuar",
            });
            // Habilitar botón y ocultar animación
            submitBtn.disabled = false;
            $(".loader-bx").removeClass("show");
          });
      }
    });

  /* ------------------------------------------------------ */
  /* --------------------- FORMULARIO LOGIN FIN ---------------- */
  /* ------------------------------------------------------ */

  /* ------------------------------------------------------ */
  /* --------------------- FORMULARIO RECUPERACION---------------- */
  /* ------------------------------------------------------ */
  document
    .getElementById("form-recuperacion")
    ?.addEventListener("submit", function (e) {
      e.preventDefault();

      const response = grecaptcha.getResponse();
      if (response.length === 0) {
        Swal.fire({
          icon: "warning",
          text: "Por favor, verifica que no eres un robot.",
          confirmButtonColor: "#5475a1",
          confirmButtonText: "Continuar",
        });
      } else {
        $(".loader-bx").addClass("show");

        let submitBtn = document.getElementById("submit-recuperacion");
        // Deshabilitar botón y mostrar animación
        submitBtn.disabled = true;

        let formData = new FormData(this);
        let data = {};
        formData.forEach((value, key) => {
          data[key] = value;
        });

        fetch(this.getAttribute("action"), {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(data),
        })
          .then((response) => response.json())
          .then((data2) => {
            console.log(data2); // Verifica el valor exacto

            if (data2.status.trim().toLowerCase() === "success") {
              Swal.fire({
                icon: "success",
                text: data2.message,
                confirmButtonColor: "#5475a1",
                confirmButtonText: "Volver al inicio",
              }).then(() => {
                // Redirigir a otra página si es necesario
                window.location.href = "/page/login";
              });
            } else if (data2.status === "error") {
              Swal.fire({
                icon: "error",
                text: data2.message,
                confirmButtonColor: "#5475a1",
                confirmButtonText: "Continuar",
              }).then((result) => {
                if (data2.error == "Captcha incorrecto") {
                  window.location.reload();
                }
              });
            }
            // document.getElementById("form-contact").reset();
            // Habilitar botón y ocultar animación
            submitBtn.disabled = false;
            $(".loader-bx").removeClass("show");
          })

          .catch((error) => {
            // console.log("Error:", error);

            Swal.fire({
              icon: "error",
              text: "Ha ocurrido un error, por favor intenta de nuevo.",
              confirmButtonColor: "#5475a1",
              confirmButtonText: "Continuar",
            });
            // Habilitar botón y ocultar animación
            submitBtn.disabled = false;
            $(".loader-bx").removeClass("show");
          });
      }
    });

  /* ------------------------------------------------------ */
  /* --------------------- FORMULARIO RECUPERACION---------------- */
  /* ------------------------------------------------------ */











  /* ------------------------------------------------------ */
  /* --------------------- FORMULARIO RECUPERACION DE CLAVE---------------- */
  /* ------------------------------------------------------ */
  document
    .getElementById("form-enviardatos")
    ?.addEventListener("submit", function (e) {
      e.preventDefault();

      const response = grecaptcha.getResponse();
      if (response.length === 0) {
        Swal.fire({
          icon: "warning",
          text: "Por favor, verifica que no eres un robot.",
          confirmButtonColor: "#5475a1",
          confirmButtonText: "Continuar",
        });
      } else {
        $(".loader-bx").addClass("show");

        let submitBtn = document.getElementById("submit-create");
        // Deshabilitar botón y mostrar animación
        submitBtn.disabled = true;

        let formData = new FormData(this);
        let data = {};
        formData.forEach((value, key) => {
          data[key] = value;
        });

        fetch(this.getAttribute("action"), {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(data),
        })
          .then((response) => response.json())
          .then((data2) => {
            console.log(data2); // Verifica el valor exacto

            if (data2.status.trim().toLowerCase() === "success") {
              Swal.fire({
                icon: "success",
                text: data2.message,
                confirmButtonColor: "#5475a1",
                confirmButtonText: "Volver al inicio",
              }).then(() => {
                // Redirigir a otra página si es necesario
                window.location.reload();

              });
            } else if (data2.status === "error") {
              Swal.fire({
                icon: "error",
                text: data2.message,
                confirmButtonColor: "#5475a1",
                confirmButtonText: "Continuar",
              }).then((result) => {
                if (data2.error == "Captcha incorrecto") {
                  window.location.reload();
                }
              });
            }
            // document.getElementById("form-contact").reset();
            // Habilitar botón y ocultar animación
            submitBtn.disabled = false;
            $(".loader-bx").removeClass("show");
          })

          .catch((error) => {
            // console.log("Error:", error);

            Swal.fire({
              icon: "error",
              text: "Ha ocurrido un error, por favor intenta de nuevo.",
              confirmButtonColor: "#5475a1",
              confirmButtonText: "Continuar",
            });
            // Habilitar botón y ocultar animación
            submitBtn.disabled = false;
            $(".loader-bx").removeClass("show");
          });
      }
    });
  /* ------------------------------------------------------ */
  /* --------------------- FORMULARIO RECUPERACI /* ------------------------------------------------------ */


/* ------------------------------------------------------ */
  /* --------------------- FORMULARIO RECUPERACION---------------- */
  /* ------------------------------------------------------ */
  document
    .getElementById("form-recuperacion")
    ?.addEventListener("submit", function (e) {
      e.preventDefault();

      const response = grecaptcha.getResponse();
      if (response.length === 0) {
        Swal.fire({
          icon: "warning",
          text: "Por favor, verifica que no eres un robot.",
          confirmButtonColor: "#5475a1",
          confirmButtonText: "Continuar",
        });
      } else {
        $(".loader-bx").addClass("show");

        let submitBtn = document.getElementById("submit-recuperacion");
        // Deshabilitar botón y mostrar animación
        submitBtn.disabled = true;

        let formData = new FormData(this);
        let data = {};
        formData.forEach((value, key) => {
          data[key] = value;
        });

        fetch(this.getAttribute("action"), {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(data),
        })
          .then((response) => response.json())
          .then((data2) => {
            console.log(data2); // Verifica el valor exacto

            if (data2.status.trim().toLowerCase() === "success") {
              Swal.fire({
                icon: "success",
                text: data2.message,
                confirmButtonColor: "#5475a1",
                confirmButtonText: "Volver al inicio",
              }).then(() => {
                // Redirigir a otra página si es necesario
                window.location.href = "/page/login";
              });
            } else if (data2.status === "error") {
              Swal.fire({
                icon: "error",
                text: data2.message,
                confirmButtonColor: "#5475a1",
                confirmButtonText: "Continuar",
              }).then((result) => {
                if (data2.error == "Captcha incorrecto") {
                  window.location.reload();
                }
              });
            }
            // document.getElementById("form-contact").reset();
            // Habilitar botón y ocultar animación
            submitBtn.disabled = false;
            $(".loader-bx").removeClass("show");
          })

          .catch((error) => {
            // console.log("Error:", error);

            Swal.fire({
              icon: "error",
              text: "Ha ocurrido un error, por favor intenta de nuevo.",
              confirmButtonColor: "#5475a1",
              confirmButtonText: "Continuar",
            });
            // Habilitar botón y ocultar animación
            submitBtn.disabled = false;
            $(".loader-bx").removeClass("show");
          });
      }
    });

  /* ------------------------------------------------------ */
  /* --------------------- FORMULARIO RECUPERACION---------------- */
  /* ------------------------------------------------------ */

















  /* ------------------------------------------------------ */

  /* ------------------------------------------------------ */
  /* --------------------- ADD TO CART---------------- */
  /* ------------------------------------------------------ */
  const addToCartButtons = document.querySelectorAll(".btn-add-cart");
  addToCartButtons.forEach((button) => {
    button.addEventListener("click", function (event) {
      event.preventDefault();
      const productId = this.getAttribute("data-id");
      const quantityInput = document.querySelector(".quantity");

      const quantity = quantityInput ? parseInt(quantityInput.value) : 1;
      const product = {
        productId,
        quantity,
      };
      // Enviar el objeto `product` al controlador `additemAction`
      fetch("/page/index/additem", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(product),
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Error en la solicitud");
          }
          return response.json(); // Si esperas una respuesta en JSON
        })
        .then((data) => {
          console.log(data);
          resetQuantity();
          alertaSwal(data);
          getCart();
          traercarrito();
        })
        .catch((error) => {
          console.error("Error al añadir el producto:", error);
        });
    });
  });

  /* ------------------------------------------------------ */
  /* --------------------- ADD TO CART FIN ---------------- */
  /* ------------------------------------------------------ */

  /* ------------------------------------------------------ */
  /* --------------------- PLUS TO CART---------------- */
  /* ------------------------------------------------------ */
  const decreaseButton = document.querySelector(".btn-decrease");
  const increaseButton = document.querySelector(".btn-increase");
  const quantityInput = document.querySelector(".quantity");

  // Evento para disminuir la cantidad
  decreaseButton?.addEventListener("click", () => {
    let quantity = parseInt(quantityInput.value);
    if (quantity > 1) {
      quantityInput.value = quantity - 1;
    }
  });

  // Evento para aumentar la cantidad
  increaseButton?.addEventListener("click", () => {
    let quantity = parseInt(quantityInput.value);
    let maxQuantity = parseInt(quantityInput.getAttribute("max"));
    if (quantity < maxQuantity) {
      quantityInput.value = quantity + 1;
    }
  });
});

/* ------------------------------------------------------ */
/* --------------------- DELETE TO CART---------------- */
/* ------------------------------------------------------ */
function eliminarProducto(id) {
  Swal.fire({
    title: "¿Estás seguro?",
    text: "Este producto será eliminado de tu carrito.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#5475a1",
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      console.log("Eliminar producto con id:", id);

      fetch("/page/index/deleteitem", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ id }),
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Error en la solicitud");
          }
          return response.json(); // Si esperas una respuesta en JSON
        })
        .then((data) => {
          console.log(data);
          alertaSwal(data);
          getCart();
          traercarrito();
        })
        .catch((error) => {
          console.error("Error al eliminar el producto:", error);
        });
    }
  });
}

function resetQuantity() {
  const quantityInput = document.querySelector(".quantity");
  if (quantityInput) {
    quantityInput.value = 1;
  }
}

function alertaSwal(res) {
  Swal.fire({
    icon: res.icon,
    text: res.text,
    confirmButtonColor: "#5475a1",
    confirmButtonText: "Continuar",
  });
}
function traercarrito() {
  fetch("/page/carrito", {
    method: "GET",
    headers: {
      "Content-Type": "text/html",
    },
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error en la solicitud");
      }
      return response.text(); // Procesa la respuesta como texto HTML
    })
    .then((html) => {
      const contenedorCarrito = document.getElementById("micarrito");
      contenedorCarrito.innerHTML = html; // Inserta el HTML en el contenedor
      initQuantityButtons();
    })
    .catch((error) => {
      console.error("Error al obtener el carrito:", error);
    });
}

traercarrito();

/* ------------------------------------------------------ */
/* --------------------- PLUS AND DELETE FROM CART---------------- */
/* ------------------------------------------------------ */
function initQuantityButtons() {
  document.querySelectorAll(".product-detail-cart").forEach((cartItem) => {
    const decreaseBtn = cartItem.querySelector(".btn-decrease-cart");
    const increaseBtn = cartItem.querySelector(".btn-increase-cart");
    const quantityInput = cartItem.querySelector(".quantity-cart");
    const maxStock = parseInt(quantityInput.getAttribute("max"), 10);
    const productId = cartItem.getAttribute("data-id");

    // Define updateQuantity dentro de initQuantityButtons para que tenga acceso a las variables locales
    const updateQuantity = (isIncrease) => {
      let currentValue = parseInt(quantityInput.value, 10);
      if (isIncrease && currentValue < maxStock) {
        quantityInput.value = currentValue + 1;
      } else if (!isIncrease && currentValue > 1) {
        quantityInput.value = currentValue - 1;
      }

      // Enviar los datos actualizados al servidor
      const product = {
        productId,
        quantity: parseInt(quantityInput.value, 10),
      };

      fetch("/page/index/additemcart", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(product),
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Error en la solicitud");
          }
          return response.json();
        })
        .then((data) => {
          console.log(data);
          alertaSwal(data); // Llama a tu función de alerta personalizada
          getCart(); // Actualiza el carrito en la UI, si tienes esta función definida
          traercarrito();

        })
        .catch((error) => {
          console.error("Error al actualizar la cantidad del producto:", error);
        });
    };

    // Asocia los eventos de click a los botones de incremento/decremento
    decreaseBtn.addEventListener("click", () => updateQuantity(false));
    increaseBtn.addEventListener("click", () => updateQuantity(true));
  });
}

// Llama a initQuantityButtons al cargar la página
document.addEventListener("DOMContentLoaded", initQuantityButtons);
