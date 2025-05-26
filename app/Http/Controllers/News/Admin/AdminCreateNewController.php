<?php

namespace App\Http\Controllers\News\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\KoronaNewsRequest;
use App\Http\Resources\KoronaNewResource;
use App\Http\Resources\KoronaNewResourceCollection;
use App\Http\Resources\KoronaNewResourceLatest;
use App\Models\KoronaNew;
use App\Services\cache\NewsService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class AdminCreateNewController extends Controller
{

    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function __invoke(KoronaNewsRequest $request)
    {
        Gate::authorize('create', KoronaNew::class);

        $imagePath = 'https://storage.yandexcloud.net/your-korona-bucket/cover/news/news.png'; // дефолт


        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $filename = uniqid('news_') . '.' . $file->getClientOriginalExtension();
            $path = Storage::disk('yandex')->putFileAs('cover/news', $file, $filename);

            if (!$path) {
                throw new \Exception('Не удалось загрузить файл на диск');
            }

            $imagePath = Storage::disk('yandex')->url($path);
        } else {
            $imagePath = 'https://storage.yandexcloud.net/your-korona-bucket/cover/news/news.png';
        }


        KoronaNew::create([
            'img' => $imagePath,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        $this->newsService->clearCache();

        return response()->json(['message' => 'Новость успешно создана']);
    }

}
