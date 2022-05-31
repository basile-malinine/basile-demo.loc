<?php

    namespace App\Http\Controllers;

    use App\Models\Comment;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;

    class UserController extends Controller
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

        private bool $reset = false;

        public function main(Request $request, $target) {
            match ($target) {
                'register' => $this->register($request),
                'login' => $this->login($request),
                'logout' => $this->logout(),
            };

            if ($this->reset) {
                session(['reload' => false]);
                session(['offset' => 0]);
                session(['limit' => 3]);
            }

            return Response()->json($this->response);
        }

        private function register(Request $request) {

            $request->validate([
                'login' => 'required|unique:users',
                'password' => 'required|confirmed',
            ]);

            // Добавляем пользователя в базу
            $user = new User();
            $user->login = $request->login;
            $user->password = Hash::make($request->password);
            $user->save();

            // Авторизация
            auth()->login($user);
            if (auth()->check()) {
                $this->reset = true;
                return;
            }

            $this->prepareResponse();
        }

        private function login(Request $request) {
            $request->validate([
                'login' => 'required',
                'password' => 'required',
            ]);

            auth()->attempt([
                'login' => $request->login,
                'password' => $request->password,
            ]);
            if (auth()->check()) {
                $this->reset = true;
            }

            $this->prepareResponse();
        }

        private function logout() {
            auth()->logout();
            if (!auth()->check()) {
                $this->reset = true;
            }

            $this->prepareResponse();
        }


        private function prepareResponse() {
            if (auth()->check()) {
                $this->response['info']['user']['id'] = auth()->user()->id;
                $this->response['info']['user']['login'] = auth()->user()->login;
            }
            $this->response['info']['db']['count'] = Comment::count();
            $this->response['info']['db']['offset'] = session('offset');
        }
    }
