<?php
include "php/db.php";
session_start();

if (isset($_SESSION['login']) && $_SESSION['role'] === 'head') {
    ?>
    <div class="container my-5 p-5">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <div class="form-floating">
                    <textarea id="productDescription" class="form-control" placeholder="Beschrijving"
                              style="height: 6rem" name="productDescription" required></textarea>
                    <label for="productDescription">Beschrijving</label>
                </div>
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="productImage">Upload</label>
                <input type="file" class="form-control" name="productImage" id="productImage" required>
            </div>
            <button type="submit" name="submit" class="btn btn-main">Opslaan</button>
        </form>
    </div>
    <?php
    if (isset($_POST['submit'])) {
        $desc = $_POST['productDescription'];
        $image = file_get_contents($_FILES['productImage']['tmp_name']);

        $selectProducts = $conn->prepare("SELECT * FROM product");
        $selectProducts->execute();

        foreach ($selectProducts as $s) {
            $updateImage = $conn->prepare("UPDATE product SET img = ?, description = ?");
            $updateImage->execute([$image, $desc]);
        }
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}