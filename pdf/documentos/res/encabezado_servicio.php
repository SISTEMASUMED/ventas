<?php 
	if ($con){
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

<body>
<div></div>

    <table cellspacing="0" style="width:90%;margin-top:1%" >
        <tr>
            <td style="color: #444444;">
                <img style="width: 75%; margin-top:2%;" src="../../<?php echo get_row('perfil','logo_url', 'id_perfil', 1);?>" alt="Logo"><br>
                
            </td>
			  <td style="margin-left:5% ;width:30%; color: #34495e;font-size:10px;text-align:center">
                <?php echo get_row('perfil','direccion', 'id_perfil', 1).", ". get_row('perfil','ciudad', 'id_perfil', 1)." ".get_row('perfil','estado', 'id_perfil', 1);?><br> 
				Teléfono: <?php echo get_row('perfil','telefono', 'id_perfil', 1);?><br>
				Email: <?php echo get_row('perfil','email', 'id_perfil', 1);?>
                
            </td>
            <?php 
				$sql_cliente=mysqli_query($con,"select * from users where user_id='$id_vendedor'");
                $rw_letra=mysqli_fetch_array($sql_cliente);
				
			?>	
		   </td>
			<td style="margin-right:0%;width: 30%;text-align:right;color:#233978; font-weight:bold;font-size:14px;">
			<span>REMISIÓN S.I.<br> NO. DIG/<?php echo $rw_letra['letra']."-".$numero_servicio;?></span>
			</td>
		</tr>
    </table>
    <?php 
}
?>
	