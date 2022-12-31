# LaravelBitOperation  

## 概要  
文字列型に格納されたビット配列の指定位置に対して、ON/OFFの切り替えを行うサンプル
＋テストコードの実装を行う
  
## setup  
```
composer install
```
.env.example -> .env
```
php artisan key:generate
```
  
## test    
```
// Mac
php artisan test Test/Unit/BitOperationTest.php
// win
php artisan test Tests\Unit\BitOperationTest.php
```
  
## 参照  
[ビット演算子](https://www.php.net/manual/ja/language.operators.bitwise.php)  
[bindec](https://www.php.net/manual/ja/function.bindec.php)  
[decbin](https://www.php.net/manual/ja/function.decbin.php)  
[preg_match](https://www.php.net/manual/ja/function.preg-match.php)  
[preg_grep](https://www.php.net/manual/ja/function.preg-grep.php)  