<?php 

require_once "../../config/connection.php";
include "../functions/function.php";

$users = getUsers();

$excel = new COM("Excel.Application");

$excel->DisplayAlerts = 1;

$workbook = $excel->Workbooks->Add();

$sheet = $workbook->Worksheets('Sheet1');
$sheet->activate;

$br = 1;
foreach($users as $user){

    //ID
    $field = $sheet->Range("A{$br}");
    $field->activate;
    $field->value = $user->id_user;

    // First name
    $field = $sheet->Range("B{$br}");
    $field->activate;
    $field->value = $user->user_first_name;

    // Last name
    $field = $sheet->Range("C{$br}");
    $field->activate;
    $field->value = $user->user_last_name;

    // Username
    $field = $sheet->Range("D{$br}");
    $field->activate;
    $field->value = $user->username;

    // Role name
    $field = $sheet->Range("E{$br}");
    $field->activate;
    $field->value = $user->role_name;
    $br++;
}


$field = $sheet->Range("E{$br}");
$field->activate;
$field->value = count($users);


$workbook->_SaveAs("users.xlsx", -4143);
$workbook->Save();


$workbook->Saved=true;
$workbook->Close;

$excel->Workbooks->Close();
$excel->Quit();

unset($sheet);
unset($workbook);
unset($excel);


header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=users.xls")


?>