<ul>
  <?php if (Session::getInstance()->get('kt_login_level') == '1') { ?>
    <li <?php if ($this->botonpanel == 1) { ?>class="activo" <?php } ?>>
      <a href="/administracion/panel">
        <i class="fas fa-info-circle"></i>
        Información Página
      </a>
    </li>
  <?php } ?>
  <li <?php if ($this->botonpanel == 11) { ?>class="activo" <?php } ?>>
    <a href="/administracion/config">
      <i class="fa-solid fa-gear"></i>
      Administrar Configuración
    </a>
  </li>

  <li <?php if ($this->botonpanel == 2) { ?>class="activo" <?php } ?>>
    <a href="/administracion/publicidad">
      <i class="far fa-images"></i>
      Administrar Publicidad
    </a>
  </li>
  <li <?php if ($this->botonpanel == 3) { ?>class="activo" <?php } ?>>
    <a href="/administracion/contenido">
      <i class="fas fa-file-invoice"></i>
      Administrar Contenidos
    </a>
  </li>
  <!--   <li <?php if ($this->botonpanel == 5) { ?>class="activo" <?php } ?>>
    <a href="/administracion/categorias">
      <i class="fa-solid fa-list"></i>
      Administrar Categorías Blogs
    </a>
  </li>
  <li <?php if ($this->botonpanel == 6) { ?>class="activo" <?php } ?>>
    <a href="/administracion/blogs">
      <i class="fa-brands fa-blogger-b"></i>
      Administrar Blogs
    </a>
  </li> -->

  <li <?php if ($this->botonpanel == 7) { ?>class="activo" <?php } ?>>
    <a href="/administracion/soluciones">
      <i class="fa-brands fa-blogger-b"></i>
      Administrar Soluciones
    </a>
  </li>

  <li <?php if ($this->botonpanel == 8) { ?>class="activo" <?php } ?>>
    <a href="/administracion/tiendacategorias">
      <i class="fa-solid fa-list"></i>
      Administrar Categorias
    </a>
  </li>
  <li <?php if ($this->botonpanel == 9) { ?>class="activo" <?php } ?>>
    <a href="/administracion/productos">
      <i class="fa-brands fa-product-hunt"></i>
      Administrar Productos
    </a>
  </li>

  <li <?php if ($this->botonpanel == 12) { ?>class="activo" <?php } ?>>
    <a href="/administracion/pedidos">
      <i class="fa-solid fa-boxes-packing"></i>
      Administrar Pedidos
    </a>
  </li>
  <li <?php if ($this->botonpanel == 13) { ?>class="activo" <?php } ?>>
    <a href="/administracion/pedidos/exportar">
      <!-- icono de excel -->
      <i class="fa-solid fa-file-excel"></i>
      Exportar Pedidos
    </a>
  </li>

  <li <?php if ($this->botonpanel == 15) { ?>class="activo" <?php } ?>>
    <a href="/administracion/correosinformacion">
      <i class="fa-regular fa-envelope"></i>
      Administrar Correos Información
    </a>
  </li>

  <li <?php if ($this->botonpanel == 16) { ?>class="activo" <?php } ?>>
    <a href="/administracion/niveles">
      <i class="fa-solid fa-layer-group"></i>
      Administrar Niveles de Usuarios
    </a>
  </li>


  <?php if (Session::getInstance()->get('kt_login_level') == '1') { ?>
    <li <?php if ($this->botonpanel == 4) { ?>class="activo" <?php } ?>>
      <a href="/administracion/usuario">
        <i class="fas fa-users"></i>
        Administrar Usuarios
      </a>
    </li>
  <?php } ?>
</ul>