<div class="container contendor-comprar pt-4 h-100 pb-4">
    <h2 class="text-center">Carrito de compras</h2>
    <?php if (is_countable($this->carrito) && count($this->carrito) > 0) { ?>
        <div class="row mt-4">
            <div class="col-12 col-md-12 col-lg-8">
                <div id="contenido_tabla">

                </div>

            </div>
            <div class="col-12 col-md-4 col-lg-4">

                <div id="contenido_info">

                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="alert alert-warning w-100 text-center mt-4" role="alert">
            <strong>¡Atención!</strong> No tienes productos en tu carrito.
        </div>
    <?php } ?>
</div>
<style>
    .main-general {
        background-color: #f5f5f5;
        min-height: auto;
    }

    #contenido_tabla {
        opacity: 0;
        animation: fadeIn 2s forwards;
    }

    @keyframes fadeIn {
        to {
            opacity: 1;
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        function traerproductos() {
            fetch("/page/comprar/productos", {
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
                    const contenedorCarrito = document.getElementById("contenido_tabla");
                    contenedorCarrito.innerHTML = html; // Inserta el HTML en el contenedor
                    $("#contenido_tabla").fadeIn();
                    initQuantityButtonsProducts();
                })
                .catch((error) => {
                    console.error("Error al obtener el carrito:", error);
                });
        }

        function traerinfo() {
            fetch("/page/comprar/info", {
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
                    const contenedorInfo = document.getElementById("contenido_info");
                    contenedorInfo.innerHTML = html; // Inserta el HTML en el contenedor


                })
                .catch((error) => {
                    console.error("Error al obtener el carrito:", error);
                });
        }

        traerinfo();
        traerproductos();

        function initQuantityButtonsProducts() {
            document.querySelectorAll(".product-detail-cart-shop").forEach((cartItemShop) => {

                const decreaseBtn = cartItemShop.querySelector(".btn-decrease-cart-shop");
                const increaseBtn = cartItemShop.querySelector(".btn-increase-cart-shop");
                const quantityInput = cartItemShop.querySelector(".quantity-cart-shop");
                const maxStock = parseInt(quantityInput.getAttribute("max"), 10);
                const productId = cartItemShop.getAttribute("data-shop-id");

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
                            // console.log(data);
                            alertaSwal(data); // Llama a tu función de alerta personalizada
                            getCart(); // Actualiza el carrito en la UI, si tienes esta función definida
                            traercarrito();
                            traerproductos();
                            traerinfo()

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


    });
    //  document.addEventListener("DOMContentLoaded", initQuantityButtonsProducts);

    // Llama a initQuantityButtons al cargar la página
</script>