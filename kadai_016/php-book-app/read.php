<?php
$dsn = 'mysql:dbname=php_book_app;host=localhost;charset=utf8mb4';
$user = 'root';
$password = 'root';


try {
    $pdo = new PDO($dsn, $user, $password);

    // booksテーブルから全てのカラムのデータを取得するためのSQL文を変数＄sqlに代入する
    $sql_select = 'SELECT * FROM books';

    // SQL文を実行する
    $stmt_select = $pdo->query($sql_select);

    // SQL文の実行結果を配列で取得する
    $products = $stmt_select->fetchALL(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    exit($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset= "UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>書籍一覧</title>
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
            <article class="books">
                <h1>書籍一覧</h1>
                <div class="books-ui">
                    <div>
                        <!-- ここに並び替えボタンと検索ボックスを作成 -->
                    </div>
                    <a href="#" class="btn">書籍登録</a>
                </div>
                <table class="books-table">
                    <tr>
                        <th>書籍コード</th>
                        <th>書籍名</th>
                        <th>単価</th>
                        <th>在庫数</th>
                        <th>ジャンルコード</th>
                    </tr>
                    <?php
                    // 配列の中身を順番に取り出し、表形式で出力
                    foreach($books as $book){
                        $table_row = "
                        <tr>
                        <td>{$book['book_code']}</td>
                        <td>{$book['book_name']}</td>
                        <td>{$book['price']}</td>
                        <td>{$book['stock-quantity']}</td>
                        <td>{$book['genre_code']}</td>
                        </tr>
                        ";
                        echo $table_row;
                    }
                    ?>
                </table>
            </article>
        </main>
        <footer>
            <a class="copyright">&copy; 書籍管理アプリ ALL rights reserved.</a>
        </footer>
    </body>
</html>