<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\ImagePostModel;
use App\Models\PostCommentModel;
use App\Models\PostModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Faker\Factory as Faker;
use Hash;


class ClientController extends Controller
{
    public function index()
    {
        $categories = CategoryModel::get();
        $about = PostModel::where('cate_parent_id', '=', null)->where('cate_son_id', '=', null)->orderBy('id', 'ASC')->limit(1)->get();
        $posts = PostModel::join('categories', 'cate_parent_id', '=', 'categories.id')->orderBy('posts.id', 'DESC')->where('cate_parent_id', '!=', 'null')->get();
        $banner = PostModel::where('cate_parent_id', '!=', 'null')->orderBy('id', 'DESC')->limit(3)->get();
        $posts1 = PostModel::join('categories', 'cate_parent_id', '=', 'categories.id')->where('cate_parent_id', '!=', 'null')->skip(3)->limit(3)->get();
        $posts2 = PostModel::join('categories', 'cate_parent_id', '=', 'categories.id')->where('cate_parent_id', '!=', 'null')->skip(6)->limit(3)->get();
        $trending = PostModel::orderBy('view', 'DESC')->where('cate_parent_id', '!=', 'null')->limit(5)->get();
        return View::make('Client.home', compact('categories', 'posts', 'banner', 'trending', 'posts1', 'posts2', 'about'));
    }
    public function postCategory($id)
    {
        $categories = CategoryModel::get();
        $about = PostModel::where('cate_parent_id', '=', null)->where('cate_son_id', '=', null)->orderBy('id', 'ASC')->limit(1)->get();
        $trending = PostModel::orderBy('view', 'DESC')->where('cate_parent_id', '!=', 'null')->limit(5)->get();
        $posts = PostModel::join('categories', 'cate_parent_id', '=', 'categories.id')->orderBy('posts.id', 'DESC')->where('cate_parent_id', '!=', 'null')->get();
        $count = PostModel::join('categories', 'cate_parent_id', '=', 'categories.id')->select('posts.*', 'category_name')->where('cate_parent_id', '=', $id)->orWhere('cate_son_id', '=', $id)->get();
        $limit = 10;
        $start = 0;
        $number = ceil(count($count) / $limit);
        if (isset($_GET['page']) && !empty($_GET['page'])) {
            $start = ($_GET['page'] - 1) * $limit;
            $postCategory = PostModel::join('categories', 'cate_parent_id', '=', 'categories.id')->select('posts.*', 'category_name')->where('cate_parent_id', '=', $id)->orWhere('cate_son_id', '=', $id)->skip($start)->take($limit)->get();
        } else {
            $postCategory = PostModel::join('categories', 'cate_parent_id', '=', 'categories.id')->select('posts.*', 'category_name')->where('cate_parent_id', '=', $id)->orWhere('cate_son_id', '=', $id)->skip($start)->take($limit)->get();

        }

        return View::make('Client.categoryPost', compact('categories', 'posts', 'postCategory', 'id', 'about', 'trending', 'number'));
    }
    public function detailPost($slug)
    {
        $categories = CategoryModel::get();
        $about = PostModel::where('cate_parent_id', '=', null)->where('cate_son_id', '=', null)->orderBy('id', 'ASC')->limit(1)->get();
        $posts = PostModel::join('categories', 'cate_parent_id', '=', 'categories.id')->orderBy('posts.id', 'DESC')->where('cate_parent_id', '!=', 'null')->get();
        $inforPost = PostModel::join('categories', 'cate_parent_id', '=', 'categories.id')->select('posts.*', 'category_name')->where('slug', '=', $slug)->get();
        $postsLq = PostModel::join('categories', 'cate_parent_id', '=', 'categories.id')->select('posts.*', 'category_name')->where('cate_parent_id', '=', $inforPost[0]->cate_parent_id)->where('posts.id', '!=', $inforPost[0]->id)->limit(8)->get();
        $imagePost = ImagePostModel::where('post_id', '=', $inforPost[0]->id)->get();
        $postComments = PostCommentModel::where('post_id', '=', $inforPost[0]->id)->get();
        $trending = PostModel::join('categories', 'cate_parent_id', '=', 'categories.id')->select('posts.*', 'category_name')->orderBy('view', 'DESC')->where('cate_parent_id', '!=', 'null')->limit(5)->get();
        $view = (int) $inforPost[0]->view + 1;
        PostModel::where('slug', "=", $slug)->update(
            [
                'view' => $view
            ]
        );
        return View::make('Client.detailPost', compact('categories', 'posts', 'inforPost', 'postsLq', 'imagePost', 'postComments', 'trending', 'about'));
    }
    public function comment(Request $request, $slug)
    {
        $inforPost = PostModel::where('slug', '=', $slug)->get();
        $request->validate(
            [
                'content' => 'required|max:255|string',
                'name' => 'required|max:255|string',
                'email' => 'required|max:255|string',
            ]
        );
        PostCommentModel::insert(
            [
                'content' => $request->content,
                'email' => $request->email,
                'name' => $request->name,
                'post_id' => $inforPost[0]->id
            ]
        );
        return redirect()->back()->with('status', 'Thanks for commenting ');

    }
    public function About()
    {
        $categories = CategoryModel::get();
        $about = PostModel::where('cate_parent_id', '=', null)->where('cate_son_id', '=', null)->orderBy('id', 'ASC')->limit(1)->get();
        $posts = PostModel::join('categories', 'cate_parent_id', '=', 'categories.id')->orderBy('posts.id', 'DESC')->where('cate_parent_id', '!=', 'null')->get();
        $about = PostModel::where('cate_parent_id', '=', null)->where('cate_son_id', '=', null)->get();
        $image = ImagePostModel::where('post_id', '=', $about[0]->id)->get();
        return View::make('Client.about', compact('categories', 'posts', 'about', 'image', 'about'));
    }
    public function contact()
    {
        $categories = CategoryModel::get();
        $about = PostModel::where('cate_parent_id', '=', null)->where('cate_son_id', '=', null)->orderBy('id', 'ASC')->limit(1)->get();
        $posts = PostModel::join('categories', 'cate_parent_id', '=', 'categories.id')->orderBy('posts.id', 'DESC')->where('cate_parent_id', '!=', 'null')->get();
        return View::make('Client.contact', compact('categories', 'posts', 'about'));
    }
    public function addContact(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required',
                'subject' => 'required',
                'message' => 'required',
            ]
        );
        $mail_data = [
            // 'recipient' => $request->email,
            'formEmail' => $request->email,
            'formName' => 'ZenBlog',
            'subject' => 'ZenBlog - Thông báo',
            'body' => 'Xin chào  Chúng tôi nhận được thông tin của bạn phản ánh hoặc góp ý xây dựng website ZenBlog - Trang tin tức nhanh chóng trên mọi lĩnh vực 
            Nếu như bạn có ý kiến gì xin vui lòng trả lời Mail này.
            Trân thành cảm ơn sự góp ý của bạn.'
        ];
        Mail::send('Client.email-template', $mail_data, function ($message) use ($mail_data) {
            $message->to($mail_data['formEmail'])->from($mail_data['formEmail'], $mail_data['formName'])->subject($mail_data['subject']);
        });
        return redirect()->back()->with('success', 'Your message has been sent. Thank you!');
    }
    public function searchPost()
    {
        $posts = PostModel::join('categories', 'cate_parent_id', '=', 'categories.id')->orderBy('posts.id', 'DESC')->where('cate_parent_id', '!=', 'null')->get();
        $about = PostModel::where('cate_parent_id', '=', null)->where('cate_son_id', '=', null)->orderBy('id', 'ASC')->limit(1)->get();
        $trending = PostModel::orderBy('view', 'DESC')->where('cate_parent_id', '!=', 'null')->limit(5)->get();
        $categories = CategoryModel::get();
        $count = PostModel::join('categories', 'cate_parent_id', '=', 'categories.id')->orderBy('posts.id', 'DESC')->where('cate_parent_id', '!=', 'null')->where('title', 'LIKE', "%" . $_GET['search'] . "%")->orWhere('category_name', 'LIKE', "%" . $_GET['search'] . "%")->get();
        $limit = 10;
        $start = 0;
        $number = ceil(count($count) / 1);
        if (isset($_GET['page']) && !empty($_GET['page'])) {
            $start = ($_GET['page'] - 1) * $limit;
            $searchPost = PostModel::join('categories', 'cate_parent_id', '=', 'categories.id')->select('posts.*', 'categories.category_name')->orderBy('posts.id', 'DESC')->where('cate_parent_id', '!=', 'null')->where('title', 'LIKE', "%" . $_GET['search'] . "%")->orWhere('category_name', 'LIKE', "%" . $_GET['search'] . "%")->skip($start)->take($limit)->get();
        } else {
            $searchPost = PostModel::join('categories', 'cate_parent_id', '=', 'categories.id')->select('posts.*', 'categories.category_name')->orderBy('posts.id', 'DESC')->where('cate_parent_id', '!=', 'null')->where('title', 'LIKE', "%" . $_GET['search'] . "%")->orWhere('category_name', 'LIKE', "%" . $_GET['search'] . "%")->skip($start)->take($limit)->get();
        }
        return View::make('Client.search-post', compact('posts', 'trending', 'categories', 'searchPost', 'number', 'about'));
    }
    public function login()
    {
        $categories = CategoryModel::get();
        $about = PostModel::where('cate_parent_id', '=', null)->where('cate_son_id', '=', null)->orderBy('id', 'ASC')->limit(1)->get();
        session()->forget('key');
        session()->forget('newpass');
        session()->forget('email');
        $posts = PostModel::join('categories', 'cate_parent_id', '=', 'categories.id')->orderBy('posts.id', 'DESC')->where('cate_parent_id', '!=', 'null')->get();
        return View::make('Client.login', compact('categories', 'posts', 'about'));
    }
    public function checkLogin(Request $request)
    {
        // dd($request);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            if (isset($request->remeber) && !empty($request->remeber)) {
                setcookie('email', $request->email, time() + 3600);
                setcookie('password', $request->password, time() + 3600);
            } else {
                setcookie('email', "");
                setcookie('password', "");
            }
            return redirect()->route('home');
        } else {
            return redirect()->back()->with('error', 'Login Fail');
        }
    }
    public function register()
    {
        $categories = CategoryModel::get();
        $posts = PostModel::join('categories', 'cate_parent_id', '=', 'categories.id')->orderBy('posts.id', 'DESC')->where('cate_parent_id', '!=', 'null')->get();
        return View::make('Client.register', compact('categories', 'posts'));
    }
    public function createRegister(Request $request)
    {
        $request->validate([
            'email' => 'required|max:255|unique:users,email',
            'name' => 'required|max:100|string',
            'password' => 'required|max:20|min:6|string'
        ]);
        $request->merge(['password' => Hash::make($request->password)]);
        User::create($request->all());
        return redirect()->route('login');
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
    public function Forgotpassword()
    {
        $categories = CategoryModel::get();
        $about = PostModel::where('cate_parent_id', '=', null)->where('cate_son_id', '=', null)->orderBy('id', 'ASC')->limit(1)->get();
        $about = PostModel::where('cate_parent_id', '=', null)->where('cate_son_id', '=', null)->orderBy('id', 'ASC')->limit(1)->get();
        $posts = PostModel::join('categories', 'cate_parent_id', '=', 'categories.id')->orderBy('posts.id', 'DESC')->where('cate_parent_id', '!=', 'null')->get();
        return View::make('Client.forgot-password', compact('categories', 'posts', 'about'));
    }
    public function ForgotpasswordSenMail(Request $request)
    {
        $categories = CategoryModel::get();
        $posts = PostModel::join('categories', 'cate_parent_id', '=', 'categories.id')->orderBy('posts.id', 'DESC')->where('cate_parent_id', '!=', 'null')->get();
        if ($request->has('email')) {
            $request->validate(['email' => 'required|email']);
            $faker = Faker::create();
            $rand = $faker->text(20);
            session(['email' => $request->email]);
            session(['key' => $rand]);
            $mail_data = [
                'formEmail' => $request->email,
                'formName' => 'ZenBlog',
                'subject' => 'ZenBlog - Thông báo',
                'body' => 'Mã xác nhận của bạn là :' . $rand
            ];
            Mail::send('Client.email-template', $mail_data, function ($message) use ($mail_data) {
                $message->to($mail_data['formEmail'])->from($mail_data['formEmail'], $mail_data['formName'])->subject($mail_data['subject']);
            });
            return View::make('Client.forgot-password', compact('categories', 'posts'));
        } else if ($request->has('verification')) {
            $request->validate(['verification' => 'required']);
            if ($request->verification == session('key')) {
                session(['newpass' => 'newpass']);
                session()->forget('key');
                return View::make('Client.forgot-password', compact('categories', 'posts'));
            }
        } else if ($request->has('password')) {
            $request->validate(['password' => 'required|min:6|max:20|string']);
            $request->merge(['password' => Hash::make($request->password)]);
            User::where('email', '=', session('email'))->update(['password' => $request->password]);
            session()->forget('newpass');
            session()->forget('email');
            return redirect()->route('login');
        }
        return View::make('Client.forgot-password', compact('categories', 'posts'));
    }
    public function infor()
    {
        $infor = User::where('email', '=', Auth::user()->email)->get();
        $about = PostModel::where('cate_parent_id', '=', null)->where('cate_son_id', '=', null)->orderBy('id', 'ASC')->limit(1)->get();
        $about = PostModel::where('cate_parent_id', '=', null)->where('cate_son_id', '=', null)->orderBy('id', 'ASC')->limit(1)->get();
        $categories = CategoryModel::get();
        $posts = PostModel::join('categories', 'cate_parent_id', '=', 'categories.id')->orderBy('posts.id', 'DESC')->where('cate_parent_id', '!=', 'null')->get();
        return View::make('Client.infor-account', compact('infor', 'categories', 'posts', 'about'));
    }
    public function updateInfor(Request $request)
    {
        if ($request->oldPassword != null) {
            $request->validate(
                [
                    'name' => 'required|max:50|string',
                    'oldPassword' => [
                        'required',
                        function ($arr, $value, $fail) {
                            if (!Hash::check($value, Auth::user()->password)) {
                                $fail('your password is not match');
                            }
                        }
                    ],
                    'password' => 'required|min:6|max:50|string',
                    'confirmPassword' => 'required|same:password',
                ]
            );
            $request->merge(['password' => Hash::make($request->password)]);
            User::where('email', '=', Auth::user()->email)->update(['password' => $request->password, 'name' => $request->name]);
        } else {
            $request->validate(['name' => 'required|max:50|string',]);
            User::where('email', '=', Auth::user()->email)->update(['name' => $request->name]);
        }
        return redirect()->back()->with('status', 'Update Your Infor Successfully');
    }
}
