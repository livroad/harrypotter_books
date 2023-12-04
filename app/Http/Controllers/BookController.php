<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class BookController extends Controller
{
    public function index($type)
    {
        $cacheKey = 'json_data_' . $type;
        $jsonDataPath = public_path($type . '.json');

        // キャッシュが存在するかチェック
        if (Cache::has($cacheKey)) {
            // キャッシュがある場合はそれを使用
            $datas = Cache::get($cacheKey);
        } else {
            // キャッシュがない場合はJSONファイルからデータを取得
            $jsonData = File::get($jsonDataPath);
            $datas = json_decode($jsonData, true);

            // データをキャッシュに保存し、期限を設定（例: 60分）
            Cache::put($cacheKey, $datas, 60);
        }

        $imagePath = 'images/noimage.png';
        $one_data = array_keys($datas[0]["attributes"]);

        // 取得したデータを対応するビューに渡して表示
        return view('books.' . $type, compact('datas', 'imagePath'));
    }
}
