<div style="font-family: Arial, sans-serif; color: #1c3455; background-color: #f4f5f5; padding-top:20px; padding-bottom:20px;">
  <div style="width: 100%;max-width:500px; margin: auto; padding: 20px; background-color: #5475a1; border-radius: 10px; color: #f4f5f5;">
    <div style="text-align: center; padding: 20px; background-color: #5475a1; color: #f4f5f5; border-radius: 10px;">
      <h1>Hola! <?php echo $this->data['user_empresa'] ?>
      </h1>
    </div>
    <p>
      Su solicitud de registro ha sido completada con éxito. Por favor, haga clic en el siguiente enlace para iniciar sesión con el correo registrado mediante código OTP.

    </p>
    <p style="text-align:center">
      <a href="<?php echo RUTA ?>/page/login?e=<?php echo $this->data['user_email'] ?>" style="border:1px solid #FFF;border-color:#FFF;color:#FFF;display:inline-block;font-family:HMSans,Arial,sans-serif;font-size:16px;font-weight:700;line-height:20px;margin:0;outline:0;padding:12px;text-align:center;text-decoration:none; margin-top:15px">Ingresar</a>
    </p>
    <div style="text-align: center; padding: 20px;  border-radius: 10px; background-color: #5475a1; color: #f4f5f5; border-radius: 10px;">

    </div>
  </div>
</div>