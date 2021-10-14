<!--                <div class="col mb-2" id="productInfo">-->
<!--                    <div class="card">-->
<!--                        <div class="card-body">-->
<!--                            <form action="productSpecs" method="get">-->
<!--                                <input type="hidden" name="product" value="--><?//= $product['productID'] ?><!--">-->
<!--                                <input type="hidden" name="sort" value="--><?//= $_GET['sort'] ?><!--">-->
<!--                                <button class="btn text-start w-100 p-0" type="submit">-->
<!--                                    <p class="text-center mb-0">-->
<!--                                        <img loading="lazy" style="max-height: 7rem; max-width: 100%" alt=""-->
<!--                                             src="data:image/png;base64,--><?//= base64_encode($product['img']) ?><!--">-->
<!--                                    </p>-->
<!--                                    <div class="fs-6 title">-->
<!--                                        <span class="fw-bold fs-5">--><?//= $product['brand'] ?><!--</span>-->
<!--                                        <br>-->
<!--                                        --><?//= $product['productName'] ?>
<!--                                    </div>-->
<!--                                    <div class="fw-light">-->
<!--                                        <small>#--><?//= $product['productNumber'] ?><!--</small>-->
<!--                                    </div>-->
<!--                                    <div class="row row-cols-2">-->
<!--                                        <div class="col">-->
<!--                                            <small class="priceText text-decoration-line-through">&euro;--><?//= $suggestedPrice ?><!--</small>-->
<!--                                        </div>-->
<!--                                        <div class="col">-->
<!--                                            <small class="priceText font-monospace">Per stuk</small>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="row row-cols-1">-->
<!--                                        --><?php
//                                        if ($product['showInclPrice']) {
//                                            ?>
<!--                                            <div class="col fs-3 fw-bold">-->
<!--                                                &euro;--><?//= number_format((float)$priceIncl, 2, ',', '.') ?>
<!--                                            </div>-->
<!--                                            <div class="col mb-0">-->
<!--                                                <small class="priceText mb-0">-->
<!--                                                    &euro;--><?//= number_format((float)$priceExcl, 2, ',', '.') ?><!-- Excl.-->
<!--                                                </small>-->
<!--                                            </div>-->
<!--                                            <div class="w-100">-->
<!--                                                <p class="mb-0">Prijs is incl BTW</p>-->
<!--                                            </div>-->
<!--                                            --><?php
//                                        } else {
//                                            ?>
<!--                                            <div class="col fs-3 fw-bold">-->
<!--                                                &euro;--><?//= number_format((float)$priceExcl, 2, ',', '.') ?>
<!--                                            </div>-->
<!--                                            <div class="col mb-0">-->
<!--                                                <small class="priceText mb-0">-->
<!--                                                    &euro;--><?//= number_format((float)$priceIncl, 2, ',', '.') ?><!-- Incl.-->
<!--                                                </small>-->
<!--                                            </div>-->
<!--                                            --><?php
//                                        }
//                                        ?>
<!--                                    </div>-->
<!--                                    --><?php
//                                    if ($product['sale'] !== '0') {
//                                        echo '<div class="fs-4 text-danger">Nu ' . $product['sale'] . '% Korting!</div>';
//                                    }
//                                    ?>
<!--                                    --><?php
//                                    if ($product['supply'] <= 10) {
//                                        ?>
<!--                                        <p class="mb-0">-->
<!--                                            <small class="priceText text-danger">-->
<!--                                                Nog --><?//= $product['supply'] ?><!-- op voorraad!-->
<!--                                            </small>-->
<!--                                        </p>-->
<!--                                        --><?php
//                                    }
//                                    ?>
<!--                                </button>-->
<!--                            </form>-->
<!---->
<!--                            <form class="mt-1" action="" method="post">-->
<!--                                <input type="hidden" name="productID" value="--><?//= $product['productID'] ?><!--">-->
<!--                                <div class="quantity buttons_added">-->
<!--                                    <div class="row text-center">-->
<!--                                        <div class="col-9">-->
<!--                                            <div class="row justify-content-center">-->
<!--                                                <div class="col m-0 ms-2 p-0">-->
<!--                                                    <input class="minus btn w-100" type="button" value="-">-->
<!--                                                </div>-->
<!--                                                <div class="col px-1">-->
<!--                                                    <input class="form-control input-text qty text w-100" type="number"-->
<!--                                                           step="1" min="1" max="--><?//= $product['supply'] ?><!--"-->
<!--                                                           name="quantity" value="1" aria-label>-->
<!--                                                </div>-->
<!--                                                <div class="col m-0 me-2 p-0">-->
<!--                                                    <input class="plus btn w-100" type="button" value="+">-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                        <div class="col-3 p-0">-->
<!--                                            <button class="btn btn-main" type="submit" name="addCart" value="addCart">-->
<!--                                                <i class="bi bi-cart-plus"></i>-->
<!--                                            </button>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </form>-->
<!---->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->