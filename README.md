# despace
南創園區公司形象官網 

## 資料夾結構
/dev_env Docker 設定檔

/web Laravel 主框架

## 資料流
User -> Borwser -> HTTP Request -> main.go -> 分配到相應之控制器 -> 初步檢查 HTTP Request 參數都有帶齊 -> 傳給服務器 -> 執行商業邏輯 -> 調用運行商業邏輯所需之函式庫 -> 回傳結果 -> 控制器 -> 輸出 HTTP Response -> Borwser -> User

## 使用說明
1. 將 /web/.env.swp 置換成 .env
2. 將 /web/storage 權限設成 777
3. 透過以下方式進入 Docker 虛擬機運行相關設定
```
# 進入 Docker 虛擬機
docker exec -it startup_php sh

# 進入web資料夾
cd web

# 運行 Composer
php ~/composer.phar install

# 運行 Storage Link
php artisan storage:link
```
4.預設管理員帳號為 admin@admin.com ，密碼為 password