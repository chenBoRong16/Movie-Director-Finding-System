<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Movie Director Query</title>
</head>
<body>
    <?php
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // 接收使用者輸入結果
                $input_min_year = $_POST['min_year'];
                $input_max_year = $_POST['max_year'];
                $input_account = $_POST['account'];
                $input_password = $_POST['password'];

                // 檢驗用戶資料是否正確
                if (empty($input_account) || empty($input_password)) {
                    throw new Exception('<h1>Error: User information is required.</h1>');
                }

                // 嘗試連接資料庫
                try {
                    $db = new PDO('mysql:dbname=imdb_small;host=localhost', $input_account, $input_password);
                } catch (PDOException $e) {
                    throw new Exception('Database connection failed: ' . $e->getMessage());
                }
                
                // 準備搜尋條件內容
                $sqlToUse = 'SELECT 
                    movies.name AS movies_name, 
                    movies.year AS movies_year, 
                    movies.rank AS movies_rank, 
                    movies_directors.director_id AS movies_director_id, 
                    directors.first_name AS directors_first_name, 
                    directors.last_name AS directors_last_name
                    FROM movies 
                    JOIN movies_directors ON movies.id = movies_directors.movie_id 
                    JOIN directors ON movies_directors.director_id = directors.id
                ';

                $conditions = [];
                $parameters = [];
                if (!empty($input_min_year)) {
                    $conditions[] = 'movies.year >= ?';
                    $parameters[] = $input_min_year;
                }
                if (!empty($input_max_year)) {
                    $conditions[] = 'movies.year <= ?';
                    $parameters[] = $input_max_year;
                }
                if (!empty($conditions)) {
                    $sqlToUse .= ' WHERE ' . implode(' AND ', $conditions);
                }

                // 嘗試執行查詢
                $sqlToUse .= ' ORDER BY movies.rank DESC';
                $query = $db->prepare($sqlToUse);
                if (!$query->execute($parameters)){
                    throw new Exception('Query execution failed.');
                }

                $result = $query->fetchAll(PDO::FETCH_ASSOC);

                // 判斷是否有結果和輸出查詢結果
                if ($result) { // $result為空時，if ... 會回傳F，反之為T，不須empty()
                    echo '<table>';
                    echo '<tr>
                        <th>Movie Name</th>
                        <th>Year</th>
                        <th>Rank</th>
                        <th>Director ID</th>
                        <th>Director First Name</th>
                        <th>Director Last Name</th>
                    </tr>';
                    foreach ($result as $row) {
                    // movies_name movies_year movies_rank movies_director_id directors_first_name directors_last_name
                        echo '<tr>' .
                            '<td>' . htmlspecialchars($row['movies_name']) . '</td>' .
                            '<td>' . htmlspecialchars($row['movies_year']) . '</td>' .
                            '<td>' . htmlspecialchars($row['movies_rank']) . '</td>' .
                            '<td>' . htmlspecialchars($row['movies_director_id']) . '</td>' .
                            '<td>' . htmlspecialchars($row['directors_first_name']) . '</td>' .
                            '<td>' . htmlspecialchars($row['directors_last_name']) . '</td>' .
                        '</tr>';
                    }
                    echo '</table>';

                    // 提供“下载 CSV”按钮
                    echo "<form method='post' action='download.php' target='_blank' id='download-button'>";
                    echo "<input type='hidden' name='min_year' value='" . htmlspecialchars($input_min_year) . "'>";
                    echo "<input type='hidden' name='max_year' value='" . htmlspecialchars($input_max_year) . "'>";
                    echo "<input type='hidden' name='account' value='" . htmlspecialchars($input_account) . "'>";
                    echo "<input type='hidden' name='password' value='" . htmlspecialchars($input_password) . "'>";
                    echo "<button type='submit' id='download-button'>Download as CSV</button>";
                    echo "</form>";

                } else {
                    throw new Exception('No directors satisfy your input years.');
                }
                

            } else {
                throw new Exception('No form data received.');
            }

        } catch (Exception $e) {
            echo '<h1>' . htmlspecialchars($e->getMessage()) . '</h1>';
        }
    ?>
    <h1><a href='form.html'>Go back to the form</a></h1>
</body>
</html>
