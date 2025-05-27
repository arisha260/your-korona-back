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

class AdminUpdateNewController extends Controller
{

    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function __invoke(KoronaNewsRequest $request, $id)
    {

        $new = KoronaNew::findOrFail($id);

        Gate::authorize('update', $new);

        $storedPath = $new->img;

        if ($request->hasFile('img')) {
            // Удалить старую картинку, если она есть и не дефолтная
            if ($new->img &&
                $new->img !== KoronaNew::DEFAULT_IMG &&
                Storage::disk('yandex')->exists($new->img)) {
                Storage::disk('yandex')->delete($new->img);
            }

            $file = $request->file('img');
            $filename = uniqid('news_') . '.' . $file->getClientOriginalExtension();
            $storedPath = Storage::disk('yandex')->putFileAs('cover/news', $file, $filename);

            if (!$storedPath) {
                throw new \Exception('Не удалось загрузить файл на диск');
            }
        }


        $new->update([
            'img' => $storedPath,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        $this->newsService->clearCache();

        return response()->json(['message' => 'Новость успешно создана']);
    }

}
