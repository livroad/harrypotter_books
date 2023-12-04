<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class BookController extends Controller
{
    public function index($type, Request $request)
    {
        $cacheKey = 'json_data_' . $type;
        $jsonDataPath = public_path($type . '.json');

        try {
            // キャッシュが存在するかチェック
            $datas = Cache::remember($cacheKey, 60, function () use ($jsonDataPath) {
                // キャッシュがない場合はJSONファイルからデータを取得
                $jsonData = File::get($jsonDataPath);
                return json_decode($jsonData, true);
            });
        } catch (\Exception $e) {
            // エラーハンドリング: ファイルの読み込みやJSONのデコードでエラーが発生した場合の処理
            return response()->json(['error' => 'Failed to load data.'], 500);
        }

        $keyElements = $this->getKeyElements($type);

        // フィルタリング
        $filteredDatas = $this->filterData($datas, $request->input('category'));

        $imagePath = 'images/noimage.png';

        // 取得したデータを対応するビューに渡して表示
        return view('books.index', compact('filteredDatas', 'imagePath', 'type', 'keyElements'));
    }

    private function filterData($datas, $category)
    {
        if (!$category) {
            return $datas; // フィルターが指定されていない場合は全データを返す
        }

        // フィルターに一致するデータを抽出
        $filteredDatas = array_filter($datas, function ($data) use ($category) {
            // ここで適切なフィルターロジックを実装
            return $data['attributes']['category'] === $category;
        });

        return array_values($filteredDatas); // インデックスを振り直して返す
    }

    private function getKeyElements($type)
    {
        switch ($type) {
            case 'characters':
                return ['image', 'name'];
            case 'movies':
                return ['poster', 'title'];
            case 'spells':
                return ['image', 'name'];
            default:
                return ['defaultImageKey', 'defaultNameKey'];
        }
    }
}
