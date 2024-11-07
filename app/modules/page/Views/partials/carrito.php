<nav class="">
    <div class="container-fluid">


        <div class="offcanvas offcanvas-end container-carrito" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">
                    <i class="fa-solid fa-cart-shopping"></i>
                    Carrito de Compras
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div id="micarrito">

            </div>


        </div>
    </div>
</nav>
<script>
    function getCart() {
        fetch("/page/index/getcart", {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                },
            })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Error en la solicitud");
                }
                return response.json(); // Si esperas una respuesta en JSON
            })
            .then((data) => {
                // console.log(data);

                const sumaCantidad = Object.keys(data).reduce((acc, id) => acc + data[id].cantidad, 0);

                const cartCounter = document.querySelector("#count-carrito");
                const cartCounterResponsive = document.querySelector("#count-carrito-responsive");

                cartCounter.textContent = sumaCantidad;
                cartCounterResponsive.textContent = sumaCantidad;
            })
            .catch((error) => {
                console.error(error);
            });
    }
    getCart();
    document.addEventListener('DOMContentLoaded', () => {

    });
</script>