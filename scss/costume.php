<?php
require 'Fungctions\functions.php';
require_once 'Fungctions\koneksi.php';

// Dapatkan data pencarian jika ada
$searchName = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';
$searchResult = searchCostumesByName($searchName, $costumes);
$searchNames = getCostumeNames($costumes);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Jerapah - Costume</title>
    <link rel="icon" href="img/pp.png" type="image/png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php includeStylesheets(); ?>
</head>
<body>
    <?php includeNavbar(); ?>
    <!-- END nav -->
    <?php includeBanner(); ?>

    <section class="ftco-section bg-light">
    <div id="search-results-container">
    <div class="row justify-content-center mb-5"data-aos="fade-up">
            <div class="col-md-7 text-center heading-section ftco-animate" >
                <span class="subheading">Penyewaan</span>
                <h2 class="mb-3">Kostum Jerapah Cosrent</h2>
            </div>
        </div>
        <div class="row">
            <!-- Form Pencarian -->
            <div class="col-md-12 mb-4" data-aos="fade-up">
                <form id="search-form" class="search-form">
                    <div class="form-group">
                        <!-- Gunakan datalist untuk menampilkan opsi nama kostum -->
                        <input list="costumeNames" type="text" name="search" id="search-input" class="form-control" placeholder="Cari Nama Kostum...">
                        <datalist id="costumeNames">
                            <!-- Loop untuk menampilkan pilihan nama kostum -->
                            <?php foreach ($searchNames as $name) : ?>
                                <option value="<?php echo htmlspecialchars($name); ?>">
                            <?php endforeach; ?>
                        </datalist>
                    </div>
                </form>
            </div>

            <!-- Daftar Kostum -->
            <?php foreach ($costumes as $costume) : ?>
                <!-- Kode Kostum -->
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Tambahkan area untuk menampilkan hasil pencarian -->
<div id="search-results"></div>

<script>
    document.getElementById('search-input').addEventListener('input', function () {
        // Jalankan fungsi pencarian setiap kali input berubah
        searchCostumes();
    });

    function searchCostumes() {
        var searchName = document.getElementById('search-input').value;

        // Buat objek XMLHttpRequest
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById('search-results').innerHTML = xhr.responseText;
            }
        };

        xhr.open('GET', 'Fungctions/search.php?search=' + searchName, true);
        xhr.send();
    }
</script>

    <section class="ftco-section bg-light">
        <div id="costum" class="container">
            <div class="row">
                <?php
                // Tampilkan hasil pencarian di atas
                foreach ($searchResult as $result) : ?>
                    <div class="col-md-4">
                        <div class="car-wrap rounded ftco-animate">
                            <div class="img rounded d-flex align-items-end" style="background-image: url(<?php echo $result['image_url']; ?>); height: 350px;"></div>
                            <div class="text">
                            <h2 class="mb-0"><a href="costume-single.php"><?php echo htmlspecialchars($result['name']); ?></a></h2>
                                <div class="d-flex mb-3">
                                    <span class="cat"><?php echo $result['category']; ?></span>
                                    <p class="price ml-auto">Rp.<?php echo $result['price']; ?> <span>/<?php echo $result['rent_duration'] . ' ' . ($result['rent_duration'] > 1 ? 'Days' : 'Day'); ?></span></p>
                                </div>
                                <p class="d-flex mb-0 d-block">
                                    <a href="payment.php" class="btn btn-primary py-2 mr-1">Book now</a>
                                    <a href="costume-single.php?item=<?php echo $result['id']; ?>" class="btn btn-secondary py-2 ml-1">Details</a>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php
                // Tampilkan sisa kostum yang tidak sesuai dengan pencarian
                foreach ($costumes as $costume) :
                    if (!in_array($costume, $searchResult)) : ?>
                        <div class="col-md-4">
                            <div class="car-wrap rounded ftco-animate">
                                <div class="img rounded d-flex align-items-end" style="background-image: url(<?php echo $costume['image_url']; ?>); height: 350px;"></div>
                                <div class="text">
                                <h2 class="mb-0"><a href="costume-single.php"><?php echo htmlspecialchars($costume['name']); ?></a></h2>
                                    <div class="d-flex mb-3">
                                        <span class="cat"><?php echo $costume['category']; ?></span>
                                        <p class="price ml-auto">Rp.<?php echo $costume['price']; ?> <span>/<?php echo $costume['rent_duration'] . ' ' . ($costume['rent_duration'] > 1 ? 'Days' : 'Day'); ?></span></p>
                                    </div>
                                    <p class="d-flex mb-0 d-block">
                                        <a href="payment.php" class="btn btn-primary py-2 mr-1">Book now</a>
                                        <a href="costume-single.php?item=<?php echo $costume['id']; ?>" class="btn btn-secondary py-2 ml-1">Details</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                <?php endif; endforeach; ?>
            </div>
        </div>
    </section>

    <?php includeFooter(); ?>

    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>

    <?php includeScripts(); ?>
   


</body>
</html>
