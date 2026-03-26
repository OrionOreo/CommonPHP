<?php
$isProductPage = $_SERVER['REQUEST_URI'] === "/product_card/12345678-abcd-dcba-abcd-87654321";

$id = htmlspecialchars($product['id']);
$url = htmlspecialchars($product['url']);
$title = htmlspecialchars($product['title']);

$imageUrl = htmlspecialchars($product['primary_image']['url']);
$imageAlt = htmlspecialchars($product['primary_image']['alt']);

$price = htmlspecialchars($product['price']);
$salePrice = !empty($product['sale_price']) ? htmlspecialchars($product['sale_price']) : null;

$stock = (int)$product['stock'];
$maxPerOrderRaw = $product['max_per_order'] ?? null;
$maxPerOrder = !empty($maxPerOrderRaw) ? (int)$maxPerOrderRaw : -1;

$inStock = $stock > 0;
$hasSale = $salePrice !== null;

$showQuantity = $inStock && ($maxPerOrder > 1 || $maxPerOrder === -1);
$maxInput = $maxPerOrder >= 1 ? $maxPerOrder : $stock;

$buttonClass = "add_to_cart" . ($maxPerOrder === 1 ? " opc" : "");
?>

<?php if ($isProductPage): ?>
<head>
    <link rel="stylesheet" href="/assets/css/out/cards" />
</head>
<?php endif; ?>

<div class="product_card" data-product-id="<?= $id ?>">
    <a href="<?= $url ?>" draggable="false">
        <div class="product_image">
            <img
                src="<?= $imageUrl ?>"
                alt="<?= $imageAlt ?>"
                loading="lazy"
                decoding="async"
            />
        </div>

        <div class="product_details">
            <h2 class="product_title"><?= $title ?></h2>

            <div class="product_price">
                <?php if ($hasSale): ?>
                    <p class="old">£<?= $price ?></p>
                    <p class="sale">£<?= $salePrice ?></p>
                <?php else: ?>
                    <p>£<?= $price ?></p>
                <?php endif; ?>
            </div>

            <div class="stock">
                <p>
                    <img src="/assets/svg/<?= $inStock ? 'in_stock.svg' : 'out_of_stock.svg' ?>" alt="" />

                    <?php if ($inStock): ?>
                        <?= $stock ?> in stock<br />
                        <?php if ($maxPerOrderRaw): ?>
                            (Max <?= htmlspecialchars($maxPerOrderRaw) ?> per customer)
                        <?php else: ?>
                            <br />
                        <?php endif; ?>
                    <?php else: ?>
                        Out of stock<br /><br />
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </a>

    <div class="product_interact">
        <?php if ($inStock): ?>

            <?php if ($showQuantity): ?>
                <label for="add_to_cart_quantity_<?= $id ?>">Quantity</label>

                <input
                    id="add_to_cart_quantity_<?= $id ?>"
                    class="add_to_cart_quantity"
                    type="number"
                    aria-label="Product Quantity"
                    value="1"
                    min="1"
                    max="<?= $maxInput ?>"
                    step="1"
                    ondragover="event.preventDefault()"
                    ondrop="event.preventDefault()"
                    inputmode="numeric"
                    autocomplete="off"
                />

                <div class="quantity_buttons">
                    <button id="quantity_add_<?= $id ?>" class="quantity_add" type="button">+</button>
                    <button id="quantity_minus_<?= $id ?>" class="quantity_minus" type="button">-</button>
                </div>
            <?php endif; ?>

            <button id="add_to_cart_<?= $id ?>" class="<?= $buttonClass ?>" type="button">
                <img src="/assets/svg/cart" alt="" />
                Add To Cart
            </button>

        <?php else: ?>
            <button id="read_more_<?= $id ?>" class="product_read_more" type="button">
                <img src="/assets/svg/arrow_right" alt="" />
                Read More
            </button>
        <?php endif; ?>
    </div>
</div>
