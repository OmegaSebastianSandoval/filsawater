<?php

/**
 * 
 */
class Page_Model_Template_Template
{

	protected $_view;
	protected $_csrf_section = "omega_index";
	protected $_csrf;


	function __construct($view)
	{
		$this->_view = $view;
	}


	public function getContentseccion($seccion)
	{
		
		$contenidoModel = new Page_Model_DbTable_Contenido();
		$contenidos = [];
		$rescontenidos = $contenidoModel->getList("contenido_estado='1' AND contenido_seccion = '$seccion' AND contenido_padre = '0' ", "orden ASC");
		foreach ($rescontenidos as $key => $contenido) {
			$contenidos[$key] = [];
			$contenidos[$key]['detalle'] = $contenido;
			$padre = $contenido->contenido_id;
			$hijos = $contenidoModel->getList("contenido_estado='1' AND contenido_padre = '$padre' ", "orden ASC");
			foreach ($hijos as $key2 => $hijo) {
				$padre = $hijo->contenido_id;
				$contenidos[$key]['hijos'][$key2] = [];
				$contenidos[$key]['hijos'][$key2]['detalle'] = $hijo;
				$nietos = $contenidoModel->getList("contenido_padre = '$padre' ", "orden ASC");
				if ($nietos) {
					$contenidos[$key]['hijos'][$key2]['hijos'] = $nietos;
					foreach ($nietos as $key3 => $subnietos) {
						$padre = $subnietos->contenido_id;

						/* if ($_GET['prueba_ambiental'] == "1") {
						  echo $padre . " titulo:" . $subnietos->contenido_titulo . "<br>";
						} */

						//En Nuestros procedimientos > 7. Gestión sostenibilidad > plan ambiental 2020 – 2022 (id 2826) cambiar la información por la del plan ambiental (id 434)
						/* if ($padre == "2826") {
						  $padre = 434;
						} */

						$contenidos[$key]['hijos'][$key2]['hijos'][$key3] = [];
						$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['nietos'] = $subnietos;
						$subnietos2 = $contenidoModel->getList("contenido_padre = '$padre' AND contenido_estado = '1'", "orden ASC");

						//se agrego esta condición porque estaba ordenando las carpetas de plan ambiental en nuestros procedicimientos al reves
						/* if ($subnietos->contenido_id == "2826") {
						  $subnietos2 = $contenidoModel->getList("contenido_padre = '$padre' AND contenido_estado = '1'", "orden DESC");
						} */

						if ($subnietos2) {
							$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['subnietos'] = $subnietos2;
							//documentos y carpetas nivel3
							foreach ($subnietos2 as $key4 => $subsubnietos) {

								$padre = $subsubnietos->contenido_id;
								$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['subnietos'][$key4] = [];
								$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['detalle'][$key4]['subsubnietos'] = $subsubnietos;
								$subsubnietos2 = $contenidoModel->getList("contenido_padre = '$padre' AND contenido_estado = '1'", "orden ASC");

								$contenidos['hijos_' . $padre] = $subsubnietos2;

								if ($subsubnietos2) {
									$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['subnietos'][$key4]['subsubnietos'] = $subsubnietos2;
									//documentos y carpetas nivel4
									foreach ($subsubnietos2 as $key5 => $bisnietos) {
										$padre = $bisnietos->contenido_id;
										$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['hijos'][$key4]['subsubnietos'][$key5] = [];
										$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['hijos'][$key4]['detalle'][$key5]['bisnietos'] = $bisnietos;
										$bisnietos = $contenidoModel->getList("contenido_padre = '$padre' AND contenido_estado = '1'", "orden ASC");

										$contenidos['hijos_' . $padre] = $bisnietos;

										if ($bisnietos) {
											//documentos y carpetas nivel5
											$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['hijos'][$key4]['subsubnietos'][$key5]['bisnietos'] = $bisnietos;


											foreach ($bisnietos as $key6 => $bisnietos2) {
												$padre = $bisnietos2->contenido_id;
												$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['hijos'][$key4]['subsubnietos'][$key5]['bisnietos'][$key6] = [];
												$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['hijos'][$key4]['subsubnietos'][$key5]['bisnietos']['detalle'][$key6]['bisnietos2'] = $bisnietos2;
												$bisnietos2 = $contenidoModel->getList("contenido_padre = '$padre' AND contenido_estado = '1'", "orden ASC");

												$contenidos['hijos_' . $padre] = $bisnietos2;

												if ($bisnietos2) {
													//documentos y carpetas nivel6
													$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['hijos'][$key4]['subsubnietos'][$key5]['bisnietos'][$key6]['bisnietos2'] = $bisnietos2;


													foreach ($bisnietos2 as $key7 => $bisnietos3) {
														$padre = $bisnietos3->contenido_id;
														$bisnietos3 = $contenidoModel->getList("contenido_padre = '$padre' AND contenido_estado = '1'", "orden ASC");
														$contenidos['hijos_' . $padre] = $bisnietos3;
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
		$this->_view->contenidos = $contenidos;
		return $this->_view->getRoutPHP("modules/page/Views/template/contenedor.php");
	}

	public function getContentseccionById($id)
	{
		$contenidoModel = new Page_Model_DbTable_Contenido();
		$contenidos = [];
		$rescontenidos = $contenidoModel->getList("contenido_id = '$id' ", "orden ASC");
		foreach ($rescontenidos as $key => $contenido) {
			$contenidos[$key] = [];
			$contenidos[$key]['detalle'] = $contenido;
			$contenidos[$key]['detalle']->mostrar = 1;
			$padre = $contenido->contenido_id;
			$hijos = $contenidoModel->getList("contenido_estado='1' AND contenido_padre = '$padre' ", "orden ASC");

			foreach ($hijos as $key2 => $hijo) {
				$padre = $hijo->contenido_id;
				$contenidos[$key]['hijos'][$key2] = [];
				$contenidos[$key]['hijos'][$key2]['detalle'] = $hijo;


				$nietos = $contenidoModel->getList("contenido_estado='1' AND contenido_padre = '$padre' ", "orden ASC");


				if ($nietos) {
					$contenidos[$key]['hijos'][$key2]['hijos'] = $nietos;
					foreach ($nietos as $key3 => $subnietos) {
						$padre = $subnietos->contenido_id;


						$contenidos[$key]['hijos'][$key2]['hijos'][$key3] = [];
						$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['nietos'] = $subnietos;
						$subnietos2 = $contenidoModel->getList("contenido_padre = '$padre' AND contenido_estado = '1'", "orden ASC");

						//se agrego esta condición porque estaba ordenando las carpetas de plan ambiental en nuestros procedicimientos al reves
						/* if ($subnietos->contenido_id == "2826") {
						  $subnietos2 = $contenidoModel->getList("contenido_padre = '$padre' AND contenido_estado = '1'", "orden DESC");
						} */

						if ($subnietos2) {
							$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['subnietos'] = $subnietos2;
							//documentos y carpetas nivel3
							foreach ($subnietos2 as $key4 => $subsubnietos) {

								$padre = $subsubnietos->contenido_id;
								$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['subnietos'][$key4] = [];
								$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['detalle'][$key4]['subsubnietos'] = $subsubnietos;
								$subsubnietos2 = $contenidoModel->getList("contenido_padre = '$padre' AND contenido_estado = '1'", "orden ASC");

								$contenidos['hijos_' . $padre] = $subsubnietos2;

								if ($subsubnietos2) {
									$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['subnietos'][$key4]['subsubnietos'] = $subsubnietos2;
									//documentos y carpetas nivel4
									foreach ($subsubnietos2 as $key5 => $bisnietos) {
										$padre = $bisnietos->contenido_id;
										$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['hijos'][$key4]['subsubnietos'][$key5] = [];
										$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['hijos'][$key4]['detalle'][$key5]['bisnietos'] = $bisnietos;
										$bisnietos = $contenidoModel->getList("contenido_padre = '$padre' AND contenido_estado = '1'", "orden ASC");

										$contenidos['hijos_' . $padre] = $bisnietos;

										if ($bisnietos) {
											//documentos y carpetas nivel5
											$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['hijos'][$key4]['subsubnietos'][$key5]['bisnietos'] = $bisnietos;


											foreach ($bisnietos as $key6 => $bisnietos2) {
												$padre = $bisnietos2->contenido_id;
												$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['hijos'][$key4]['subsubnietos'][$key5]['bisnietos'][$key6] = [];
												$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['hijos'][$key4]['subsubnietos'][$key5]['bisnietos']['detalle'][$key6]['bisnietos2'] = $bisnietos2;
												$bisnietos2 = $contenidoModel->getList("contenido_padre = '$padre' AND contenido_estado = '1'", "orden ASC");

												$contenidos['hijos_' . $padre] = $bisnietos2;

												if ($bisnietos2) {
													//documentos y carpetas nivel6
													$contenidos[$key]['hijos'][$key2]['hijos'][$key3]['hijos'][$key4]['subsubnietos'][$key5]['bisnietos'][$key6]['bisnietos2'] = $bisnietos2;


													foreach ($bisnietos2 as $key7 => $bisnietos3) {
														$padre = $bisnietos3->contenido_id;
														$bisnietos3 = $contenidoModel->getList("contenido_padre = '$padre' AND contenido_estado = '1'", "orden ASC");
														$contenidos['hijos_' . $padre] = $bisnietos3;
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
		$this->_view->contenidos = $contenidos;
		return $this->_view->getRoutPHP("modules/page/Views/template/contenedor.php");
	}

	public function banner($seccion)
	{
		$this->_view->seccionbanner = $seccion;
		$publicidadModel = new Page_Model_DbTable_Publicidad();
		$this->_view->banners = $publicidadModel->getList("publicidad_seccion = '$seccion' AND publicidad_estado = '1'", "orden ASC");

		return $this->_view->getRoutPHP("modules/page/Views/template/bannerinternas.php");
	}

	public function bannerPrincipal()
	{
		$publicidadModel = new Page_Model_DbTable_Publicidad();
		// $this->_view->banners = $publicidadModel->getList(" (publicidad_seccion = '1' OR publicidad_seccion='2' or publicidad_seccion='3') AND publicidad_estado = '1'", "orden ASC");
		$banners = [];
		$banners['1'] = $publicidadModel->getList("publicidad_seccion = '1' AND publicidad_estado = '1'", "orden ASC");
		$banners['2'] = $publicidadModel->getList("publicidad_seccion = '2' AND publicidad_estado = '1'", "orden ASC");
		$banners['3'] = $publicidadModel->getList("publicidad_seccion = '3' AND publicidad_estado = '1'", "orden ASC");
		$this->_view->banners = $banners;
		echo "<pre>";
		print_r($this->_view->banners);
		echo "</pre>";
		return $this->_view->getRoutPHP("modules/page/Views/template/bannerprincipal.php");
	}

	public function bannerPrincipalInd($seccion)
	{
		$this->_view->seccionbanner = $seccion;
		$publicidadModel = new Page_Model_DbTable_Publicidad();
		$this->_view->banners = $publicidadModel->getList("publicidad_seccion = '$seccion' AND publicidad_estado = '1'", "orden ASC");

		return $this->_view->getRoutPHP("modules/page/Views/template/bannerprincipalind.php");
	}

	public function getFormulario($csrf_section, $csrf)
	{
		$this->_view->csrf_section = $csrf_section;
		$this->_view->csrf = $csrf;
		return $this->_view->getRoutPHP("modules/page/Views/template/formulario.php");
	}

	public function productosDestacados()
	{
		$productosModel = new Administracion_Model_DbTable_Productos();
		$this->_view->productosImportantes = $productosModel->getList("producto_importante = '1' AND producto_estado = '1'", "orden ASC");
		return $this->_view->getRoutPHP("modules/page/Views/template/importantes.php");
	
	}
}
