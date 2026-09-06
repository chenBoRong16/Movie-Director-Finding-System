# 電影導演查詢系統

以 PHP 和 MySQL 依上映年份查詢電影與導演，並可把結果下載成 CSV。

本專案**不附帶、不授權**任何 IMDb 或其他商業電影資料庫。示範資料是原創虛構內容。

## 授權

- **程式**（HTML／CSS／PHP）與 **`sample_data.sql` 虛構樣本**： [0BSD](LICENSE) — 可商用、可分享、修改、再發布；**不必具名、不必保留授權聲明**。
- **第三方電影資料**：**不在** 0BSD 範圍。細節見 [NOTICE.md](NOTICE.md)。不要把禁止再發布或禁止商用的資料庫 dump 放進本專案。

## 功能

1. **電影查詢**  
   輸入最小／最大上映年份，列出電影名稱、年份、排名、導演 ID、導演姓名。
2. **匯出 CSV**  
   可將查詢結果下載為 CSV。

## 文件

- `search_directors/form.html`：查詢表單（年份、資料庫帳號與密碼）。
- `search_directors/process.php`：連線資料庫、查詢並顯示結果。
- `search_directors/download.php`：將查詢結果輸出為 CSV。
- `search_directors/style.css`：表格與按鈕樣式。
- `search_directors/sample_data.sql`：原創虛構樣本，建立 `movie_directors` 資料庫。
- `NOTICE.md`：第三方資料與商標的限縮說明。

## 使用方式

1. 將 `search_directors/` 放到支援 PHP 的網站目錄。
2. 用 `sample_data.sql` 在 MySQL 建立 `movie_directors` 資料庫。
3. 瀏覽器開啟 `form.html`，輸入年份範圍與資料庫帳號密碼後送出。
4. 有結果時可按 “Download as CSV”。

## 需求

- 支援 PHP 的 Web 伺服器（Apache、Nginx 等）
- PHP 7.0 以上
- MySQL／MariaDB

## 安裝

1. 把檔案放到網站目錄。
2. 匯入樣本：

   ```bash
   mysql -u 你的帳號 -p < search_directors/sample_data.sql
   ```

3. 程式已連到資料庫名稱 `movie_directors`。若要改庫名，請同時改 `process.php`、`download.php` 的 PDO 連線字串。

4. 若改用**自己的**資料，表結構需包含：

   - `movies`：`id`, `name`, `year`, `rank`
   - `directors`：`id`, `first_name`, `last_name`
   - `movies_directors`：`director_id`, `movie_id`

   自行匯入第三方資料時，須遵守該來源條款；本專案不提供、也不授權 IMDb 等片單。

## 注意

表單會把資料庫帳號密碼送到伺服器做連線，只適合作業或本機示範，不要用在公開環境。
