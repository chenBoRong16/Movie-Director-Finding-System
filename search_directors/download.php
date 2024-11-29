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
            if ($result) { // $result為空時，if ... 會回傳F，反之為T，不需使用empty()
                header('Content-Type: text/csv');
                /*通過 Content-Disposition和Content-Type告訴瀏覽器，目標是一個文件而不是普通的HTML內容:
                而瀏覽器下載文件後，不會停留在 download.php*/
                $filename = 'movies_(' . 
                    htmlspecialchars($input_min_year) . '-' . 
                    htmlspecialchars($input_max_year) .   
                ').csv';
                header('Content-Disposition: attachment; filename="' . $filename . '"');

                // 打開 PHP 输出流，确保直接輸出到瀏覽器
                $output = fopen('php://output', 'w');
                if ($output === false) {
                    throw new Exception('Unable to open output stream.');
                }

                //寫入CSV文件的標題行
                $headers = [
                    'Movie Name',
                    'Year',
                    'Rank',
                    'Director ID',
                    'Director First Name',
                    'Director Last Name',
                ];
                fputcsv($output, $headers);

                //寫入數據行
                foreach ($result as $row) {
                    $data = [
                        htmlspecialchars($row['movies_name']),
                        htmlspecialchars($row['movies_year']),
                        htmlspecialchars($row['movies_rank']),
                        htmlspecialchars($row['movies_director_id']),
                        htmlspecialchars($row['directors_first_name']),
                        htmlspecialchars($row['directors_last_name']),
                    ];
                    fputcsv($output, $data);
                }
                fclose($output);

            } else {
                throw new Exception('No directors satisfy your input years.');
            }
            

        } else {
            throw new Exception('Called download.php without "POST" method!'); //無須\"轉義
        }

    } catch (Exception $e) {
        echo '<h1>' . htmlspecialchars($e->getMessage()) . '</h1>';
    }
?>