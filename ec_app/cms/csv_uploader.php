<?php

/* HTML特殊文字をエスケープする関数 */
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// パラメータを正しい構造で受け取った時のみ実行
if (isset($_FILES['upfile']['error']) && is_int($_FILES['upfile']['error'])) {

    try {

        /* ファイルアップロードエラーチェック */
        switch ($_FILES['upfile']['error']) {
            case UPLOAD_ERR_OK:
                // エラー無し
                break;
            case UPLOAD_ERR_NO_FILE:
                // ファイル未選択
                throw new RuntimeException('File is not selected');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                // 許可サイズを超過
                throw new RuntimeException('File is too large');
            default:
                throw new RuntimeException('Unknown error');
        }

        $tmp_name = $_FILES['upfile']['tmp_name'];
        $detect_order = 'ASCII,JIS,UTF-8,CP51932,SJIS-win';
        setlocale(LC_ALL, 'ja_JP.UTF-8');

        /* 文字コードを変換してファイルを置換 */
        $buffer = file_get_contents($tmp_name);
        if (!$encoding = mb_detect_encoding($buffer, $detect_order, true)) {
            // 文字コードの自動判定に失敗
            unset($buffer);
            throw new RuntimeException('Character set detection failed');
        }
        file_put_contents($tmp_name, mb_convert_encoding($buffer, 'UTF-8', $encoding));
        unset($buffer);

        /* データベースに接続 */
        $pdo = new PDO(
            'mysql:dbname=semart_db;host=localhost;charset=utf8',
            'root',
            '',
            array(
                // カラム型に合わない値がINSERTされようとしたときSQLエラーとする
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET SESSION sql_mode='TRADITIONAL'",
                // SQLエラー発生時にPDOExceptionをスローさせる
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                // プリペアドステートメントのエミュレーションを無効化する
                PDO::ATTR_EMULATE_PREPARES => false,
            )
        );
        $stmt = $pdo->prepare('INSERT INTO test_table VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

        /* トランザクション処理 */
        $pdo->beginTransaction();
        try {
            $fp = fopen($tmp_name, 'rb');
            while ($row = fgetcsv($fp)) {
                if ($row === array(null)) {
                    // 空行はスキップ
                    continue;
                }
                if (count($row) !== 16) {
                    // カラム数が異なる無効なフォーマット
                    throw new RuntimeException('Invalid column detected');
                }
                $executed = $stmt->execute($row);
            }
            if (!feof($fp)) {
                // ファイルポインタが終端に達していなければエラー
                throw new RuntimeException('CSV parsing error');
            }
            fclose($fp);
            $pdo->commit();
        } catch (Exception $e) {
            fclose($fp);
            $pdo->rollBack();
            throw $e;
        }

        /* 結果メッセージをセット */
        if (isset($executed)) {
            // 1回以上実行された
            $msg = array('green', 'Import successful');
        } else {
            // 1回も実行されなかった
            $msg = array('black', 'There were nothing to import');
        }

    } catch (Exception $e) {

        /* エラーメッセージをセット */
        $msg = array('red', $e->getMessage());

    }

}

// XHTMLとしてブラウザに認識させる
// (IE8以下はサポート対象外ｗ)
header('Content-Type: application/xhtml+xml; charset=utf-8');

?>
