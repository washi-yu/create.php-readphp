<?php
$dsn = 'mysql:dbname=php_db_app;host=localhost;charset=utf8mb4';
$user = 'root';
$password = 'root';

if(isset($_POST['submit'])){
    try{
        $pdo = new PDO($dsn,$user,$password);
        $sql_insert = '
        INSERT INTO products (product_code,product_nme,price,stok_quantity,vendor_code)
        VALUE(:product_code,:product_nme,:price,:stock_quantity,:vendor_code)
        ';
        $stmt_insert = $pdo->prepare($sql_insert);

        $stmt_insert->bindValue(':product_code',$_POST['product_code'],PDO::PARAM_INT);
        $stmt_insert->bindValue(':product_nme',$_POST['product_nme'],PDO::PARAM_INT);
        $stmt_insert->bindValue(':price',$_POST['price'],PDO::PARAM_INT);
        $stmt_insert->bindValue(':stock_quantity',$_POST['stock_quantity'],PDO::PARAM_INT);
        $stmt_insert->bindValue(':vendor_code',$_POST['vendor_code'],PDO::PARAM_INT);

        $stmt_insert->execute();

        $count = $stmt_insert->rowCount();
        $message="商品を{$count}件登録しました";
        header("Location: read.php?message={$message}");
    }catch(PDOExtention $e){
        exit($e->getMessage());
    }
}

try{
    $pdo = new PDO($dsn,$user,$password);

    $sql_select = 'SELECT vendor_code FROM vendors';

    $stmt_select = $pdo->query($sql_select);

    $ventor_codes = $stmt_select->fetchAll(PDO::FETCH_COLUMN);

}catch(PDOExtention $e){
    exit($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scal=1.0">
        <title>商品登録</title>
        <link rel="stylesheet" href="css/style.css">

     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    
    </head>

    <body>
        <header>
            <nav>
                <a href="index.php">商品管理アプリ</a>
            </nav>
        </header>
        <main>
            <article class="registration">
                <h1>商品登録</h1>
                <div class="back">
                    <a href="read.php" class="btn">&lt;戻る</a>
                </div>
                <form action="create.php" method="post" class="registration-form">
                    <div>
                        <label for="product_code">商品コード</label>
                        <input type="number" name="product_code"  min="0" max="100000000" required>

                        <label for="product_name">商品名</label>
                        <input type="text" name="product_nme" maxlength="50" required>

                        <label for="price">単価</label>
                        <input type="nunber" name="price" min="0" max="100000000" required>

                        <label for="stock_quantity">在庫数</label>
                        <input type="number" name="stock_quantity" min="0" max="10000000" required>

                        <label for="vendor_code">仕入コード</label>
                        <select name="vendor_code" required>
                            <option disabled selected value>選択して下さい</option>
                            <?php
                            foreach( $ventor_codes as $vendor_code){
                                echo "<option value='{$vendor_code}'>{$vendor_code}</option>";
                            }
                            ?>
                        </select>

                    </div>
                    <button type="submit" class="submit-btn" name="submit" value="create">登録</button>
                </form>
            </article>
        </main>
        <footer>
            <p class="copyright">&copy;商品管理アプリ All rights reserved.</p>
        </footer>

    </body>
</html>