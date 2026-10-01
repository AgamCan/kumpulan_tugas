<?php
require __DIR__ . '/config/koneksi.php';
session_destroy();
header('Location: ' . BASE_URL . '/login.php');
