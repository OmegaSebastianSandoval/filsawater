<div style=" background: #6e6e6e20; padding: 50px; font-size: 15px;">
  <table style="max-width: 600px; background: #FFF; border: 2px solid #192a4b; margin: auto; padding: 20px;">
    <tr>
      <td style="border-bottom: 2px solid #192a4b;">
        <img src="https://www.filsawater.com/images/FILSA%201.png" alt="Logo FILSA" height="100"  style="display:block; margin:auto; margin-bottom:10px">
      </td> 
    </tr>
    <tr>
      <td style="padding: 10px 20px; padding-bottom: 20px;">
        <span style="color: #202020;">
          <b>
            <?php 
            // echo $this->data['name'];
            ?>
          </b>
         Se ha enviado una solicitud de registro como cliente con los siguientes datos:
        </span>
      </td>
    </tr>
    <tr>
      <td style="padding: 3px 20px;">
        <span style="color: #6e6e6e;">
          <b>
            Empresa
          </b>
          <?php echo $this->data['company'] ?>
        </span>
      </td>
    </tr>
    <tr>
      <td style="padding: 3px 20px;">
        <span style="color: #6e6e6e;">
          <b>
            Nit
          </b>
          <?php echo $this->data['nit'] ?>
        </span>
      </td>
    </tr>

    <tr>
      <td style="padding: 3px 20px;">
        <span style="color: #6e6e6e;">
          <b>
            Correo electrónico:
          </b>
          <?php echo $this->data['email'] ?>
        </span>
      </td>
    </tr>
    <tr>
      <td style="padding: 3px 20px;">
        <span style="color: #6e6e6e;">
          <b>
            Teléfono:
          </b>
          <?php echo $this->data['phone'] ?>
      </td>
    </tr>
    <tr>
      <td style="padding: 3px 20px;">
        <span style="color: #6e6e6e;">
          <b>
            Dirección
          </b>
          <?php echo $this->data['address'] ?>
        </span>
      </td>
    </tr>

    <tr>
      <td style="padding: 3px 20px;">
        <span style="color: #6e6e6e;">
          <b>
            Nombre de contacto
          </b>
          <?php echo $this->data['name'] ?>
        </span>
      </td>
    </tr>
    <tr>
      <td style="padding: 3px 20px;">
        <span style="color: #6e6e6e;">
          <b>
            Teléfono del contacto
          </b>
          <?php echo $this->data['phone-contact'] ?>
        </span>
      </td>
    </tr>
    
    
   <!--  <tr>
      <td style="padding: 3px 20px;">
        <span style="color: #6e6e6e;">
          <b>
            Servicio
          </b>
          <?php echo $this->data['service'] ?>
      </td>
    </tr> -->
    <!-- <tr>
      <td style="padding: 3px 20px; padding-bottom: 30px;">
        <span style="color: #6e6e6e;">
          <b>
            Mensaje:
          </b>
          <?php 
          echo $this->data['message'] 
          ?>
      </td>
    </tr> -->
  </table>
</div>