<?php

    namespace App\Http\Controllers;

    use App\Models\Comment;
    use App\Models\User;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;

    class CommentController extends Controller
    {
        private array $response = [
            'records' => [],
            'info' => [
                'user' => [
                    'id' => 0,
                    'login' => '',
                ],
                'db' => [
                    'count' => 0,
                    'offset' => 0,
                ],
            ],
        ];

        /**
         * <p>Распределяет запросы с фронта в зависимости от параметра</p>
         *
         * @param Request $request <p>Запрос</p>
         * @param $target <p>Параметр</p>
         * @return JsonResponse <p>Ответ</p>
         */
        public function main(Request $request, string $target): JsonResponse {
            match ($target) {
                'add' => $this->addComment($request),
                'more' => $this->moreComments(),
            };
            return Response()->json($this->response);
        }


        /**
         * <p>Добавляет запись с комментарием в базу</p>
         *
         * @param Request $request <p>Запрос с фронта</p>
         */
        private function addComment(Request $request) {
            // Получаем с фронта новый комментарий (AJAX)
            $content = $request->textComment;

            // Создаём экземпляр Модели
            $comments = new Comment();

            // Сохраняем запись
            $comments->content = $content;
            $comments->user_id = auth()->user()->id; // (На будущее)
            $comments->save();

            // Увеличиваем указатель смещения
            $offset = session('offset') + 1;
            session(['offset' => $offset]);

            $records = $comments->orderBy('id', 'desc')->limit(1)->get();
            $this->prepareResponse($records);
        }

        private function moreComments() {
            $cnt = Comment::query()->count(); // Кол-во записей в базе
            $offset = session('offset');  // Указатель на текущее смещение
            $limit = session('limit');    // Лимит для порции вывода (по условию 3)

            // Выбираем следующую порцию данных $limit (по условию 3 строки) либо выбираем всё до $offset
            if (session('reload')) {
                session(['reload' => false]);
                $records = Comment::query()->orderBy('id', 'desc')->limit($offset)->get();
            } else {
                $records = Comment::query()->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();

                // Вычисляем позицию указателя смещения
                if ($cnt - $offset <= $limit) {
                    $offset += $cnt - $offset;
                } else {
                    $offset += $limit;
                }

                // Записываем в сессию новое значение указателя смещения
                session(['offset' => $offset]);
            }
            $this->prepareResponse($records);
        }

        /**
         * <p>Готовит массив для ответа</p>
         *
         * @param $records <p>Результат актуального запроса<p>
         */
        private function prepareResponse($records) {
            // Кол-во записей в базе
            $cnt = Comment::count();

            // Если выбрана последняя запись
            if (session('offset') >= $cnt) {
                session(['offset' => $cnt]);
            }

            // Заполняем массив актуальными записями
            $flds = []; // Временный массив для полей
            $recs = []; // Временный массив для записей
            foreach ($records as $record) {
                $recId = $record->id;
                $userId = $record->user_id;

                $flds['id'] = $recId;
                $flds['user'] = Comment::find($recId)->user->login; 
                $flds['time'] = date('d.m.Y H:i', strtotime($record->updated_at));
                $flds['content'] = $record->content;
                $recs[] = $flds;
            }
            $this->response['records'] = $recs;

            if (auth()->check()) {
                $this->response['info']['user']['id'] = auth()->user()->id;
                $this->response['info']['user']['login'] = auth()->user()->login;
            }
            $this->response['info']['db']['count'] = $cnt;
            $this->response['info']['db']['offset'] = session('offset');
        }
    }
