<?php
$content1 = file_get_contents('app/Http/Controllers/User/DepositController.php');
$content2 = file_get_contents('app/Http/Controllers/User/UserController.php');

if (strpos($content1, 'catch (\Throwable') !== false && strpos($content2, 'catch (\Throwable') !== false) {
    echo "Try-catch blocks updated successfully.\n";
} else {
    echo "Try-catch blocks not fully updated.\n";
}
