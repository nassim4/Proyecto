<?php include('Connections/connect.php'); ?>
<?php
//$rec= $_REQUEST['recordID'];
//echo $rec;



$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_connect, $connect);


/*------SELECT PRODUCTOS DEL USUARIO-----------*/
if (!isset($_REQUEST['recordID'])){
$query_Recordset1 = "SELECT * FROM tblproducto ORDER BY tblproducto.strNombre ASC";
}else{
$regs = "SELECT * FROM tblcategoria where strDescripcion='$_REQUEST[recordID]' ORDER BY tblcategoria.idCategoria ASC";

$registros=mysql_query($regs,$connect) or
  die("Problemas en el select:".mysql_error());

if ($reg=mysql_fetch_array($registros))
{$cat= $reg['idCategoria'];}
$query_Recordset1 = "SELECT * FROM tblproducto where intCategoria = $cat ORDER BY tblproducto.strNombre ASC";
}
/*------------END SELECT-----------------------*/

$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $connect) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;
?>
<link href="includes/twoColFixLtHdr.css" rel="stylesheet" type="text/css" />
<div id="content">
 <table width="541" height="76" <!--border="1"-->
     <tr class="tablaprincipal" bgcolor="#66CCCC">
	   <td width="105"></td>
       <td width="105">Nombre Producto </td>
       <td width="165">Precio</td>
       <td width="188">Contactar</td>
     </tr>
     
       <?php do { ?>
	   <tr class="brillo">
	     <td><img width="105" src="documentos/productos/<?php echo $row_Recordset1['strImagen']; ?>" > </img></td>
         <td><?php echo $row_Recordset1['strNombre']; ?></td>
         <td><?php echo $row_Recordset1['dblPrecio']; echo '&#8364'; ?></td>
         <td><a href="contactos.php?recordID=<?php echo $row_Recordset1['strSEO']; ?>"><?php echo $row_Recordset1['strSEO']; ?></a>  </td>
		 </tr>
         <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
   </table>
</div>