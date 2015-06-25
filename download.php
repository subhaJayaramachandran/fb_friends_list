<?php 
$userid=$_GET['userid'];
require_once 'dbconfig.php';
require_once 'DataWriter.php';
$sqlUsers = "SELECT * FROM tbl_friends where user_id='".$userid."'" ;
$Users = mysqli_query($connection,$sqlUsers);
$sheet2 =  array(
  array('Sno.','Names'),
 );
$i=1;
while($data = mysqli_fetch_array($Users )){
$sheet2[]=array($i,$data['user_first_name']);
$i++;
}
$workbook = new Spreadsheet_Excel_Writer();
$format_und =& $workbook->addFormat();
$format_und->setBottom(2);//thick
$format_und->setBold();
$format_und->setColor('black');
$format_und->setFontFamily('Arial');
$format_und->setSize(8);
$format_reg =& $workbook->addFormat();
$format_reg->setColor('black');
$format_reg->setFontFamily('Arial');
$format_reg->setSize(8);
$arr = array(
      'Names'   =>$sheet2,
      );
foreach($arr as $wbname=>$rows)
{
    $rowcount = count($rows);
    $colcount = count($rows[0]);
    $worksheet =& $workbook->addWorksheet($wbname);
    $worksheet->setColumn(0,0, 6.14);//setColumn(startcol,endcol,float)
    $worksheet->setColumn(1,3,15.00);
    $worksheet->setColumn(4,4, 8.00); 
    for( $j=0; $j<$rowcount; $j++ )
    {
        for($i=0; $i<$colcount;$i++)
        {
            $fmt  =& $format_reg;
            if ($j==0)
                $fmt =& $format_und;

            if (isset($rows[$j][$i]))
            {
                $data=$rows[$j][$i];
                $worksheet->write($j, $i, $data );
            }
        }
    }
}
$workbook->send('export_friends.xls');
$workbook->close();
?>