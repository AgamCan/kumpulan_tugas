<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: auth/login.php");
    exit;
}

include "includes/header.php";
include "includes/navbar.php";
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-body">
            <h3>Selamat Datang, <?= $_SESSION['username']; ?> 👋</h3>
            <hr>

            <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="assets/img/slider/1.jpg" class="d-block w-100 rounded" style="height:400px; object-fit:cover;">
                    </div>
                    <div class="carousel-item">
                        <img src="assets/img/slider/2.jpg" class="d-block w-100 rounded" style="height:400px; object-fit:cover;">
                    </div>
                    <div class="carousel-item">
                        <img src="assets/img/slider/3.jpg" class="d-block w-100 rounded" style="height:400px; object-fit:cover;">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<?php
include "includes/footer.php";
?>