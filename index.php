<?php    

    echo "<center><h1>Generador de CÓDIGOS QR</center>";

    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
   
    $PNG_WEB_DIR = 'temp/';

    include "qrlib.php";    

    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    
    $filename = $PNG_TEMP_DIR.'test.png';
    
    $errorCorrectionLevel = 'L';
    if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
        $errorCorrectionLevel = $_REQUEST['level'];    

    $matrixPointSize = 4;
    if (isset($_REQUEST['size']))
        $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);


    if (isset($_REQUEST['data'])) { 
    
 
        if (trim($_REQUEST['data']) == '')
            die('Estos datos no pueden estar VACIOS <a href="?">Atras</a>');
    
        $filename = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    } else {    
        
        QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
    }    
        
    echo '<img src="'.$PNG_WEB_DIR.basename($filename).' " /><hr/>';

  
    echo '<form action="index.php" method="post">

        Descripcion :<textarea name="data" rows=4 width=550%  value=""'.(isset($_REQUEST['data'])?($_REQUEST['data']):'PHP QR Code :)').'" /></textarea>;

        Tipo de Codigo QR: <select name="level">

            <option value="L"'.(($errorCorrectionLevel=='L')?' selected':'').'>TELEFONO</option>
            <option value="M"'.(($errorCorrectionLevel=='M')?' selected':'').'>EMAIL</option>
            <option value="Q"'.(($errorCorrectionLevel=='Q')?' selected':'').'>MENSAJE</option>
            <option value="H"'.(($errorCorrectionLevel=='H')?' selected':'').'>TEXTO</option>
            <option value="H"'.(($errorCorrectionLevel=='H')?' selected':'').'>URL</option>
            <option value="M"'.(($errorCorrectionLevel=='M')?' selected':'').'>TARJETA COMERCIAL</option>
        </select>;
        Tamaño:<select name="size">';
        
    for($i=1;$i<=10;$i++)
        echo '<option value="'.$i.'"'.(($matrixPointSize==$i)?' selected':'').'>'.$i.'</option>';
        
    echo '</select>;
       <center><br><br><input type="submit" value="Generar Código QR"><hr/></center></br></br>';

    