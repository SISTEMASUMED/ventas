
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<style>
.page-break {
	    page-break-after: always;
	}
</style>
<body style="margin-top: -5%;">
  <div class="container">
<div style="display: flex; flex-direction: row; width: 100%;   margin-top: 5%;">

<div><img src="res/img/logo_hospital.png" alt="" style="width: 330px; height: auto;"></div>

<div style="width: 450px; line-height:.5; height:auto;margin-left:-2%; padding: 10; text-align: center;">
    <h1 style="font-size: 8px;">HOSPITAL REGIONAL DE ALTA ESPECIALIDAD DE IXTAPALUCA</h1>
    <h1 style="font-size: 8px; margin-top:-1.7%;">ADMINISTRACIÓN Y FINANZAS</h1>
    <h2 style="font-size: 8px; margin-top:-1.7%;">RECURSOS MATERIALES </h2>
    <h3 style="font-size: 8px; margin-top:-1.7%;">HOJA DE CONSUMO DE INSUMOS Y/O MATERIALES 2024</h3>
</div>

<!--<div> <img src="res/img/logo_municipio.png" alt="" style="width: 250px; height: auto; margin-top: -10%; margin-left: 20%;"></div>-->
</div>

<div style="display: flex; flex-direction: row;margin-top:-1%;">
<div style="margin-left: 0%; ">
<?php 
 
?>
    <table cellspacing="0" style="width: 100%;">
  
    <td style="margin-left:5%; width:50%; color: #000000;font-size:9px;">
     <b>UBICACIÓN:</b> <?php echo $ubicacion//get_row('perfil','telefono', 'id_perfil', 1);?><br>
     <b>NOMBRE DEL PACIENTE:</b> <?php echo strtoupper($paterno)." ".strtoupper($materno)." ".strtoupper($nombre_paciente)//get_row('perfil','email', 'id_perfil', 1);?><br>
     <b>NOMBRE DEL PROCEDIMIENTO:</b> <?php echo strtoupper($nombre_cirugia);?><br>
  </td>
    </table>

</div>
<div style="margin-left: 40%;">
    <table cellspacing="0" style="width: 100%;">
    
    <td style="margin-left:90% ; width:30%; color: #000000;font-size:9px;">
      <b> FECHA:</b> <?php echo $fecha_cirugia//get_row('perfil','telefono', 'id_perfil', 1);?><br>
     <b>NÚMERO DE ETIQUETAS:</b> <?php echo "" //get_row('perfil','email', 'id_perfil', 1);?>
      
  </td>
    </table>
  
</div>
</div>

</div>


