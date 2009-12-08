<?php
require('immosite/common.php');
require_once 'immosite/ajax/xajax.inc.php';
require_once 'immosite/ajax/xajaxResponse.inc.php';
#define ('XAJAX_DEFAULT_CHAR_ENCODING', 'ISO-8859-1' );
$xajax = new xajax("","xajax_",'UTF-8'); // Encoding important for FF or it will not work
function addOptionData($fd,$fd_val)
{
  $mysqli = new mysqli(MY_HOST, MY_USER, MY_PASSWORD, MY_DB);
  
  $objResponse = new myXajaxResponse();
  $objResponse->setCharEncoding('UTF-8'); // is need for IE or we get an Alert Error
  $sql="SELECT * FROM `regions` where cID=".$fd_val['suchart']." and locked!=0;";
  $aOptions=array();
  if ($result = $mysqli->query($sql)) {
   $count = $result->num_rows;
     while($data = $result->fetch_array(MYSQLI_ASSOC))
    {
    #array_push ($aOptions, $data['name']);
    $aOptions[$data['name']]=$data['name'];
    }
    }
  $objResponse->addCreateOptions($fd, $aOptions);
  #$objResponse->addAlert($sql);
  return $objResponse->getXML();
  $mysqli->close();
}

class myXajaxResponse extends xajaxResponse
{  
     function addCreateOption($sSelectId, $sOptionText, $sOptionValue)  
    {  
        $sScript  = "var objOption = new Option('".$sOptionText."', '".$sOptionValue."');";
        $sScript .= "document.getElementById('".$sSelectId."').options.add(objOption);";
        $this->addScript($sScript);
    }

    function addCreateOptions($sSelectId, $aOptions)
    {
        foreach($aOptions as $sOptionText => $sOptionValue)
        {
            $this->addCreateOption($sSelectId, $sOptionText, $sOptionValue);
        }
    }
}

$xajax->registerFunction("addOptionData");
$xajax->processRequests();
$smarty->assign('xajaxPrintJavascript', $xajax->getJavascript(AJAX_FILE_PATH,"xajax.js"));
$smarty->display('combo.tpl', NULL, DEFAULT_LANG);
?>