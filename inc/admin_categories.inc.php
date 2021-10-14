<?php
include 'php/db.php';

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {

        $selectCategories = $conn->prepare("SELECT * FROM category");
        $selectCategories->execute();

        ?>
        <div class="hide container border border-main px-5 mb-3" id="CRUD_Category" style="max-width: 40rem">

            <h4 class="my-2">Categorieën Overzicht</h4>

            <div class="row">
                <div class="col-lg-6 col-md-12 mb-3">
                    <button type="button" class="btn btn-second" data-bs-toggle="modal"
                            data-bs-target="#addCategoryModal">
                        Categorie Toevoegen
                    </button>
                </div>
                <div class="col-lg-6 col-md-12 mb-3">
                    <input type="search" class="form-control" id="categorySearch" placeholder="Zoek Category"
                           aria-label="Search">
                </div>
            </div>

            <div class="table-scroll" style="height: 30rem">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Afbeelding</th>
                        <th class="text-center">*</th>
                    </tr>
                    </thead>
                    <tbody id="categoryTable">
                    <?php
                    foreach ($selectCategories as $category) {
                        ?>
                        <tr class="align-middle">
                            <td><?= $category['categoryName'] ?></td>
                            <td>
                                <img loading="lazy" style="height: 3rem;"
                                     src="data:image/svg+xml;base64,<?= base64_encode($category['categoryImg']) ?>"
                                     alt="">
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col">
                                        <button type="button" class="btn btn-main" data-bs-toggle="modal"
                                                data-bs-target="#editCategory"
                                                data-bs-info="<?= $category['categoryID'] ?>, <?= $category['categoryName'] ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </div>
                                    <form class="col" action="php/admin_delete_category.php" method="post">
                                        <input type="hidden" value="<?= $category['categoryID'] ?>" name="categoryID">
                                        <button type="submit" name="submit" class="btn btn-main"
                                                onclick="return confirm(`Weet je zeker dat je deze categorie wilt verwijderen?`);">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>

            <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModal"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCategoryModal">Categorie Toevoegen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="php/admin_add_category.php" method="post" enctype="multipart/form-data">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="categoryName" id="categoryName"
                                           placeholder="Naam" required>
                                    <label for="categoryName">Naam</label>
                                </div>
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="categoryImage">Foto</label>
                                    <input type="file" class="form-control" name="categoryImage" id="categoryImage" required>
                                </div>
                                <button type="submit" name="submit" value="submit" class="btn btn-main">Toevoegen
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="editCategory" tabindex="-1" aria-labelledby="editCategoryLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCategoryLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="php/admin_edit_category.php" method="post" enctype="multipart/form-data">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="editCategoryName" id="editCategoryName"
                                           required>
                                    <label for="editCategoryName">Naam</label>
                                    <input type="hidden" name="categoryID" id="categoryID">
                                </div>
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="editCategoryImage">Foto</label>
                                    <input type="file" class="form-control" name="editCategoryImage" id="editCategoryImage">
                                </div>
                                <button type="submit" name="submit" value="submit" class="btn btn-main">Opslaan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <script>
            let editCategory = document.getElementById('editCategory')
            editCategory.addEventListener('show.bs.modal', function (event) {

                let button = event.relatedTarget
                let category = button.getAttribute('data-bs-info')
                let info = category.split(',')
                let title = editCategory.querySelector('.modal-title')
                let name = editCategory.querySelector('.modal-body #editCategoryName')
                let categoryID = editCategory.querySelector('.modal-body #categoryID')

                title.textContent = 'Wijzig ' + info[1]
                name.value = info[1]
                categoryID.value = info[0]
            })

            $(document).ready(function () {
                $("#categorySearch").on("keyup", function () {
                    var value = $(this).val().toLowerCase();
                    $("#categoryTable tr").filter(function () {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });
        </script>

        <?php
    }
} else {
    echo "<script>window.location.href='404';</script>";
    exit;
}