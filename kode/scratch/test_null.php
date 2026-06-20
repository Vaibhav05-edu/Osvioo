<?php
class User { public $name = 'test'; }
class Invoice { public $user = null; }

$inv = new Invoice();
try {
    echo $inv->user->name ?? 'Unknown';
} catch (Exception $e) {
    echo $e->getMessage();
} catch (Error $e) {
    echo $e->getMessage();
}
