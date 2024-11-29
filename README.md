# IMDB小型版本電影導演查詢系統

這是一個基於 PHP 和 MySQL 的電影查詢系統，用戶可以通過輸入特定的時間範圍來查詢 IMDB 資料庫中的電影及其導演資料，並且可以將查詢結果导出為 CSV 文件下載。

## 功能介紹

1. **電影查詢**
   - 用戶可以通過輸入電影上映的最小年份和最大年份來查詢特定時間段內的電影信息。
   - 查詢結果包括電影名稱、年份、排名、導演 ID、導演的名字和姓氏。

2. **導出 CSV**
   - 用戶可以選擇將查詢到的電影和導演信息以 CSV 文件的格式导出下載，方便進一步的資料分析。

## 文件組成

- **`form.html`**: 用戶查詢表單的 HTML 文件。包含用戶輸入的年份、資料庫帳號及密碼，用於查詢電影資料。
- **`process.php`**: 接收表單資料，連接資料庫，查詢電影和導演信息，並顯示查詢結果。如果有查詢結果，將顯示下載 CSV 的按鈕。
- **`style.css`**: 頁面的 CSS 文件，責任定義頁面中的表格、按鈕等元素的樣式。
- **`download.php`**: 處理 CSV 文件下載的 PHP 文件。通過用戶輸入的年份範圍進行查詢，並將查詢結果以 CSV 格式輸出。
- **`imdb_small.sql`**: 用於在 MySQL 資料庫中建立 `imdb_small` 資料庫的 SQL 文件，包含電影和導演的相關數據。

## 使用方式

1. 將所有文件上傳至你的 Web 服務器。
2. 打開瀏覽器並訪問 `form.html`，用戶可以輸入年份範圍來查詢電影。
3. 點擊“Submit”按鈕後，結果將顯示在頁面上。
4. 如果需要下載結果，可以點擊“Download as CSV”按鈕，4下載查詢結果。

## 代碼說明

### `form.html`

這個文件包含查詢表單，用戶需要輸入以下內容：
- **年份範圍**: 最小和最大年份。
- **資料庫帳號與密碼**: 用於連接 IMDB 資料庫的帳號和密碼。

### `process.php`

這個文件責任：
- 從用戶提交的表單中獲取資料。
- 連接到資料庫，根據用戶輸入的年份範圍進行查詢。
- 將查詢結果顯示在網頁上，並提供下載 CSV 的按鈕。

### `download.php`

這個文件用於生成和下載 CSV 文件。當用戶在查詢結果頁面上點擊“Download as CSV”按鈕時，資料會被查詢並生成 CSV 格式供用戶下載。

### `style.css`

這個文件提供基本的樣式支援，包括：
- 表格邊框和間距的設置。
- 鼠標懸停時改變按鈕顏色，以提升用戶交互體驗。

## 注意事項

- **安全性**: 目前代碼使用用戶輸入的帳號和密碼連接資料庫，這種方式不太安全。
- **資料庫**: 該應用程式依賴於一個名為 `imdb_small` 的 MySQL 資料庫。請確保你的 MySQL 資料庫中有適合的數據。

## 需求

- **Web 服務器**: Apache、Nginx 或其他支援 PHP 的 Web 服務器。
- **PHP**: PHP 7.0 或以上版本。
- **MySQL**: 用於存儲電影和導演數據。

## 安裝

1. 將所有文件放入你的 Web 服務器目錄中。
2. 確保 Web 服務器已安裝並配置好 PHP。
3. 使用提供的 SQL 文件（`imdb_small.sql`）在你的 MySQL 資料庫中建立 `imdb_small` 資料庫。
4. 修改 `process.php` 和 `download.php` 中的資料庫連接信息以匹配你的服務器設置。

## 授權

該項目使用 MIT 授權。

