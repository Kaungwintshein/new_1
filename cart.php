<?php
    include "./php/config/db.connect.php";
    include "./php/config/auth.php";

    $id = $_SESSION['userid'];
    $sql = "select auth.id as customer_id, auth.username as customer_name,product.item_name as product_name,product.*, order_product.* FROM order_product INNER JOIN auth ON order_product.customer_id=auth.id INNER JOIN product ON order_product.product_id=product.id WHERE auth.id='$id'";
    $res = mysqli_query($conn, $sql);
    $preorders = mysqli_fetch_all($res,MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/public/css/cart.css">
    <script src="/public/Js/cart.js" type="text/javascript"></script>
</head>

<body>

    <div class="shopping-cart">
        <div class="cart-title">
            <h1>CART</h1>
        </div>
        <div class="cart-title-bar">
            <span class="cart-quantity cart-header cart-column">IMG</span>
            <span class="cart-item cart-header cart-column">ITEM</span>
            <span class="cart-price cart-header cart-column">PRICE</span>
            <span class="cart-quantity cart-header cart-column">QUANTITY</span>
            <span class="cart-quantity cart-header cart-column">Check Out</span>
            <span class="cart-quantity cart-header cart-column">DELETE</span>
        </div>
        <div class="cart-items">

            <?php foreach($preorders as $preorder): ?>
                
            <div class="cart-row">

                <div class="cart-item cart-column">
                    <img class="cart-item-image" src="./images/product/<?php echo $preorder['img'] ?>" width="100" height="100">
                    <span class="cart-item-title"><?php echo $preorder['item_name'] ?></span>
                </div>
                <div class="cart-price cart-column">$ <?php echo $preorder['price'] ?></div>
                <div class="cart-quantity cart-column">
                    <!-- <form action='<?php //echo $_SERVER['PHP_SELF'] ?>' method='POST'> -->
                    <input class="cart-quantity-input" name='quantity' type="number" value="<?php echo $preorder['order_quantity'] ?>">
                    <!-- <input type="hidden" name="id_to_delete" value="<?php //echo $preorder['id'] ?>" />
                    <button type='submit' name='delete' class="btn btn-danger" type="button">REMOVE</button> -->
                    <!-- </form> -->
                   
                </div>

                <div class="cart-column">
                <form action="/checkout.php?id=<?php echo $preorder['order_product_id'] ?>&customerid=<?php echo $preorder['customer_id']; ?>" method="post">
                    <input type="hidden" name="product_id" value="<?php echo $preorder['product_id']; ?>">
                    <input type="hidden" name="price" value="<?php echo $preorder['price']; ?>">
                    <input type="hidden" name="order_quantity" value="<?php echo $preorder['order_quantity']; ?>">
                    <input type="hidden" name="img" value="<?php echo $preorder['img']; ?>">
                    <button type='submit' name='checkout' class="btn" type="button">Order</button>
                </div>
                <div class="cart-column">
                    <button type='submit' name='delete' id="btn-danger" class="btn btn-danger" type="button"> <a href="/cartDel.php?id=<?php echo $preorder['order_product_id'] ?>">REMOVE</a></button>
                </div>
            </div>
            <?php endforeach; ?>

        </div>  
        <div class="cart-total">
            <strong class="cart-total-title">Total</strong>
            <span class="cart-total-price">$0</span>
            <button class="btn btn-primary btn-purchase" type="button"><a href="/shop.php">Continue Shopping</a></button>
        </div>
        
    </div>


    
</body>

</html>