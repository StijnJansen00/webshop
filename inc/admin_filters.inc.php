<?php
include 'php/db.php';

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'head') {

    $selectFilters = $conn->prepare("SELECT * FROM filter");
    $selectFilters->execute();

    ?>
    <div class="hide container border border-main mb-3 px-5" id="CRUD_Filters"  style="max-width: 40rem">

        <h4 class="my-2">Filters Overzicht</h4>

        <div class="row">
            <div class="col-lg-6 col-md-12 mb-3">
                <button type="button" class="btn btn-second" data-bs-toggle="modal" data-bs-target="#addFilterModal">
                    Filter Toevoegen
                </button>
            </div>
            <div class="col-lg-6 col-md-12 mb-3">
                <input type="search" class="form-control" id="filterSearch" placeholder="Zoek Filter"
                       aria-label="Search">
            </div>
        </div>

        <div class="table-scroll" style="height: 30rem">
            <table class="table">
                <thead>
                <tr>
                    <th>Naam</th>
                    <th class="text-center">*</th>
                </tr>
                </thead>
                <tbody id="filterTable">
                <?php
                foreach ($selectFilters as $filter) {
                    ?>
                    <tr class="align-middle">
                        <td><?= $filter['name'] ?></td>
                        <td>
                            <div class="row">
                                <div class="col">
                                    <button type="button" class="btn btn-main" data-bs-toggle="modal"
                                            data-bs-target="#editFilter"
                                            data-bs-info="<?= $filter['filterID'] ?>, <?= $filter['name'] ?>">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </div>
                                <form class="col" action="php/admin_delete_filter.php" method="post">
                                    <input type="hidden" value="<?= $filter['filterID'] ?>" name="filterID">
                                    <button type="submit" name="submit" class="btn btn-main"
                                            onclick="return confirm(`Weet je zeker dat je deze filter wilt verwijderen?`);">
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

        <div class="modal fade" id="addFilterModal" tabindex="-1" aria-labelledby="addFilterModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addFilterModal">Filter Toevoegen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="php/admin_add_filter.php" method="post">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="filterName" id="filterName"
                                       placeholder="Naam"
                                       required>
                                <label for="filterName">Naam</label>
                            </div>
                            <button type="submit" name="submit" value="submit" class="btn btn-main">Toevoegen
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editFilter" tabindex="-1" aria-labelledby="editFilterLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editFilterLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="php/admin_edit_filter.php" method="post">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="filterName" id="editFilterName"
                                       required>
                                <label for="editFilterName">Naam</label>
                                <input type="hidden" name="filterID" id="filterID">
                            </div>
                            <button type="submit" name="submit" value="submit" class="btn btn-main">Opslaan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        let editFilter = document.getElementById('editFilter')
        editFilter.addEventListener('show.bs.modal', function (event) {

            let button = event.relatedTarget
            let filter = button.getAttribute('data-bs-info')
            let info = filter.split(',')
            let title = editFilter.querySelector('.modal-title')
            let filterName = editFilter.querySelector('.modal-body #editFilterName')
            let filterID = editFilter.querySelector('.modal-body #filterID')

            title.textContent = 'Wijzig ' + info[1]
            filterName.value = info[1]
            filterID.value = info[0]
        })

        $(document).ready(function () {
            $("#filterSearch").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#filterTable tr").filter(function () {
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