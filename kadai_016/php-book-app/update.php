<?php
$dsn = 'mysql=php_book_app;host=localhost;charset=utf8mb4';
$user = 'root';
$password = 'root';

// idパラメータの値が存在すれば処理実行
if(isset($_GET['id'])){
    try {
        $pdo = new PDO($dsn, $user, $password);

        // idカラムの値をプレースホルダ(:id)に置き換えたSQL文をあらかじめ用意
        $sql_select_book = 'SELECT * FROM books WHERE id = :id';
        $stmt_select_book = $pdo->prepare($sql_select_book);

        // bindValue()メソッドを使って実際の値をプレースホルダにバインド(割り当て)
        $stmt_select_book->bindValue(':id', $_GET['id'], PDO::PARAM_INT);

        // SQL実行
        $stmt_select_book->execute();

        // SQL文の実行結果を配列で取得
        $book = $stmt_select_book->fetch(PDO::FETCH_ASSOC);

        // idパラメータの値と同じidが存在しない場合はエラーメッセージを表示して処理終了
        if($book === FALSE){
            exit('idパラメータの値が不正です。');        
        }

        // genreテーブルからgenre_codeを所得するためのSQL文を変数$sql_select_genre_codesに代入
        $sql_select_genre_codes = 'SELECT genre_code FROM genres';

        // SQL実行
        $stmt_select_genre_codes = $pdo->query($sql_select_genre_codes);

        // SQL文の実行結果を配列で取得
        $genre_codes = $stmt_select_genre_codes->fetchALL(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
} else {
    // idパラメータの値が存在しない場合はエラーメッセージを表示して処理停止
    exit('idパラメータの値が存在しません。');
}
?>

<!DOCTYPE html>
<html lang="ja">
 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>書籍編集</title>
        <link rel="stylesheet" href="css/style.css">

        <!-- Google Fontsの読み込み -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    </head>
 
    <body>
        <header>
            <nav>
                <a href="index.php">書籍管理アプリ</a>
            </nav>
        </header>
        <main>
            <article class="registration">
                <h1>書籍編集</h1>
                <div class="back">
                    <a href="read.php" class="btn">&lt; 戻る</a>
                </div>
                <form action="update.php?id=<?= $_GET['id'] ?>" method="post" class="registration-form">
                    <div>
                        <label for="book_code">書籍コード</label>
                        <input type="number" name="book_code" value="<?= $book['book_code'] ?>" min="0" max="100000000" repuired>
                        
                        <label for="book_name">書籍名</label>
                        <input type="text" name="book_name" value="<?= $book['book_name'] ?>" maxlength="50" repuired>

                        <label for="price">単価</label>
                        <input type="number" name="price" value="<?= $book['price'] ?>" min="0" max="100000000" repuired>

                        <label for="stock-puantity">在庫数</label>
                        <input type="number" name="stock_quantity" value="<?= $book['stock_quantity'] ?>" min="0" max="100000000" repuired>

                        <label for="genre_code">ジャンルコード</label>
                        <select name="genre_code" repuired>
                            <option disabled selected value>選択してください</option>
                            <?php
                            // 配列の中身を順番に取り出し、セレクトボックスの選択肢として出力
                            foreach ($genre_codes as $genre_code) {
                                // もし$genre_codeが書籍のジャンルコードの値と一致していれば、select属性をつけて初期化
                                if($genre_code === $book['genre_code']){
                                    echo "<option value='{genre_code}' selected>{$genre_code}</option>";
                                } else {
                                    echo "<option value='{$genre_code}' selected>{$genre_code}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="submit-btn" name="submit" value="update">更新</button>
                </form>
            </article>
        </main>
        <footer>
            <p class="copyright">&copy; 書籍管理アプリ All rights reserved.</p>
        </footer>
    </body>

</html>