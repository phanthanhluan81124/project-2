<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\ImagePostModel;
use App\Models\PostCommentModel;
use App\Models\PostModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        $date = Date('Y-m-d');
        $allPost = PostModel::all();
        $allUser = User::where('role', '2')->get();
        $allCategory = CategoryModel::all();
        $posts = PostModel::whereDate('created_at', $date)->get();
        $topView = PostModel::where('view', '>', 10)->limit(10)->get();
        return View::make('Admin.dashboard', compact('allPost', 'allUser', 'allCategory', 'posts', 'topView'));
    }
    //CATEGORY ==========================================================================================================================================================================
    public function listCategory()
    {
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $count = CategoryModel::where('category_name', 'LIKE', "%" . $_GET['search'] . "%")->get();
        } else {
            $count = CategoryModel::all();
        }
        $limit = 5;
        $start = 0;
        $number = ceil(count($count) / $limit);
        if (isset($_GET['page']) && !empty($_GET['page'])) {
            $start = ($_GET['page'] - 1) * $limit;
            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $cate_name_son = CategoryModel::where('category_name', 'LIKE', "%" . $_GET['search'] . "%")->get();
                $categories = CategoryModel::where('category_name', 'LIKE', "%" . $_GET['search'] . "%")->orWhere('category_parent', '=', $cate_name_son[0]->id)->skip($start)->take($limit)->get();
            } else {
                $categories = CategoryModel::skip($start)->take($limit)->get();
            }
        } else {
            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $cate_name_son = CategoryModel::where('category_name', 'LIKE', "%" . $_GET['search'] . "%")->get();
                $categories = CategoryModel::where('category_name', 'LIKE', "%" . $_GET['search'] . "%")->orWhere('category_parent', '=', $cate_name_son[0]->id)->skip($start)->take($limit)->get();
            } else {
                $categories = CategoryModel::skip($start)->take($limit)->get();
            }
        }
        return View::make('Admin.categories.listCategory', compact('categories', 'number'));
    }
    public function addNewCategory()
    {
        $categories = CategoryModel::all();
        return View::make('Admin.categories.addNewCategory', compact('categories'));
    }
    public function postCategory(Request $request)
    {
        $request->validate([
            'category_name' => 'required|max:255|string'
        ]);
        CategoryModel::create([
            'category_name' => $request->category_name,
            'category_parent' => $request->category_parent
        ]);
        return redirect()->route('addnewcategory')->with('status', 'Created Category Successfully');

    }
    public function editCategory(int $id)
    {
        $infoCategory = CategoryModel::findOrFail($id);
        $categories = CategoryModel::all();
        return View::make('Admin.categories.editCategory', compact('infoCategory', 'categories'));
    }
    public function putEditCategory(Request $request, int $id)
    {
        $request->validate([
            'category_name' => 'required|max:255|string'
        ]);
        CategoryModel::findOrFail($id)->update([
            'category_name' => $request->category_name,
            'category_parent' => $request->category_parent
        ]);
        return redirect()->back()->with('status', 'Update Category Successfully');

    }
    public function deleteCategory(int $id)
    {
        $category = CategoryModel::findOrFail($id);
        $category->delete();
        return redirect()->back();

    }
    //POST ==========================================================================================================================================================================
    public function addNewPost()
    {
        $categories = CategoryModel::all();
        return View::make('Admin.post.addNewPost', compact('categories'));
    }
    public function Post(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|max:255|string',
                'avatar' => 'required|image|mimes:jpeg,png,gif|max:2048|dimensions:min_width:100,min_height:100',
                'image' => 'image|mimes:jpeg,png,gif|max:2048|dimensions:min_width:100,min_height:100',
                'short_description' => 'required|max:255|string',
                'content' => 'string',
                'cate_parent_id' =>'required|integer',
                'cate_son_id' =>'required|integer',
            ]
        );
        if ($request->has('avatar')) {
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalName();
            $filename = time() . $extension;
            $path = 'uploads/';
            $file->move($path, $filename);
        }
        $slug = Str::slug($request->title);
        $newPost = PostModel::create([
            'title' => $request->title,
            'slug' => $slug,
            'image' => $filename,
            'short_description' => $request->short_description,
            'content' => $request->content,
            'cate_parent_id' => $request->category_parent,
            'cate_son_id' => $request->category_son
        ]);
        $newPost->save();
        if ($request->has('image')) {
            $file = $request->file('image');
            foreach ($file as $key) {
                $extension = $key->getClientOriginalName();
                $filename = time() . $extension;
                $path = 'uploads/';
                $key->move($path, $filename);
                ImagePostModel::create([
                    'image_name' => $filename,
                    'post_id' => $newPost->id
                ]);
            }
        }
        return redirect()->route('addnewPost')->with('status', 'Created Post Successfully');

    }
    public function listPost()
    {
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            if (isset($_GET['category']) && !empty($_GET['category'])) {
                $count = PostModel::where('title', 'LIKE', "%" . $_GET['search'] . "%")->where('cate_parent_id', '=', $_GET['category'])->where('cate_son_id', '=', $_GET['category'])->get();
            } else {
                $count = PostModel::where('title', 'LIKE', "%" . $_GET['search'] . "%")->get();
            }
        } else {
            if (isset($_GET['category']) && !empty($_GET['category'])) {
                $count = PostModel::where('cate_parent_id', '=', $_GET['category'])->orWhere('cate_son_id', '=', $_GET['category'])->get();
            } else {
                $count = PostModel::all();
            }

        }
        $limit = 10;
        $start = 0;
        $number = ceil(count($count) / $limit);
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            if (isset($_GET['category']) && !empty($_GET['category'])) {
                if (isset($_GET['page']) && !empty($_GET['page'])) {
                    $start = ($_GET['page'] - 1) * $limit;
                    $cate = PostModel::where('title', 'LIKE', "%" . $_GET['search'] . "%")->get();
                    $posts = PostModel::where('title', 'LIKE', "%" . $_GET['search'] . "%")->where('cate_parent_id', '=', $_GET['category'])->where('cate_son_id', '=', $_GET['category'])->skip($start)->take($limit)->get();
                } else {
                    $posts = PostModel::where('title', 'LIKE', "%" . $_GET['search'] . "%")->where('cate_parent_id', '=', $_GET['category'])->where('cate_son_id', '=', $_GET['category'])->skip($start)->take($limit)->get();
                }
            } else {
                $posts = PostModel::where('title', 'LIKE', "%" . $_GET['search'] . "%")->skip($start)->take($limit)->get();
            }
        } else {
            if (isset($_GET['category']) && !empty($_GET['category'])) {
                if (isset($_GET['page']) && !empty($_GET['page'])) {
                    $start = ($_GET['page'] - 1) * $limit;
                    $posts = PostModel::where('cate_parent_id', '=', $_GET['category'])->orWhere('cate_son_id', '=', $_GET['category'])->skip($start)->take($limit)->get();
                } else {
                    $posts = PostModel::where('cate_parent_id', '=', $_GET['category'])->orWhere('cate_son_id', '=', $_GET['category'])->skip($start)->take($limit)->get();
                }
            } else {
                if (isset($_GET['page']) && !empty($_GET['page'])) {
                    $start = ($_GET['page'] - 1) * $limit;
                    $posts = PostModel::skip($start)->take($limit)->get();
                } else {
                    $posts = PostModel::skip($start)->take($limit)->get();
                }
            }
        }
        $categories = CategoryModel::all();
        return View::make('Admin.post.listPost', compact('posts', 'categories', 'number'));
    }
    public function editPost($slug, int $id)
    {
        $post = PostModel::findOrFail($id);
        $image_post = ImagePostModel::where('post_id', '=', $id)->get();
        $categories = CategoryModel::all();
        return View::make('Admin.post.editPost', compact('post', 'categories', 'image_post'));
    }
    public function putEditPost(Request $request, $slug, int $id)
    {
        $post = PostModel::findOrFail($id);
        $image_post = ImagePostModel::where('post_id', '=', $id)->get();
        $filename = $post->image;
        $request->validate(
            [
                'title' => 'required|max:255|string',
                'avatar' => 'required|image|mimes:jpeg,png,gif|max:2048|dimensions:min_width:100,min_height:100',
                'image' => 'image|mimes:jpeg,png,gif|max:2048|dimensions:min_width:100,min_height:100',
                'short_description' => 'required|max:255|string',
                'content' => 'string',
                'cate_parent_id' =>'required|integer',
                'cate_son_id' =>'required|integer',
            ]
        );
        if ($request->has('avatar')) {
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalName();
            $filename = time() . $extension;
            $path = 'uploads/';
            $file->move($path, $filename);
        }
        $slug = Str::slug($request->title);
        PostModel::findOrFail($id)->update([
            'title' => $request->title,
            'slug' => $slug,
            'image' => $filename,
            'short_description' => $request->short_description,
            'content' => $request->content,
            'cate_parent_id' => $request->category_parent,
            'cate_son_id' => $request->category_son
        ]);
        if ($request->has('image')) {
            $image_id_old = ImagePostModel::where('post_id', '=', $id)->get();
            foreach ($image_id_old as $item) {
                ImagePostModel::findOrFail($item->id)->delete();
            }
            $file = $request->file('image');
            foreach ($file as $key) {
                $extension = $key->getClientOriginalName();
                $filename = time() . $extension;
                $path = 'uploads/';
                $key->move($path, $filename);
                ImagePostModel::create([
                    'image_name' => $filename,
                    'post_id' => $id
                ]);
            }
        }
        return redirect()->back()->with('status', 'Update Post Successfully');
    }
    public function deletePost($slug, int $id)
    {
        $image_id_old = ImagePostModel::where('post_id', '=', $id)->get();
        foreach ($image_id_old as $item) {
            ImagePostModel::findOrFail($item->id)->delete();
        }
        PostModel::findOrFail($id)->delete();
        return redirect()->back()->with('status', 'Delete Post Successfully');
    }
    // User =============================================================================================================================================================================
    public function listUser()
    {
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $count = User::where('email', 'LIKE', "%" . $_GET['search'] . "%")->get();
        } else {
            $count = User::all();
        }
        $limit = 10;
        $start = 0;
        $number = ceil(count($count) / $limit);
        if (isset($_GET['page']) && !empty($_GET['page'])) {
            $start = ($_GET['page'] - 1) * $limit;
            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $users = User::where('email', 'LIKE', "%" . $_GET['search'] . "%")->skip($start)->take($limit)->get();
            } else {
                $users = User::skip($start)->take($limit)->get();
            }
        } else {
            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $users = User::where('email', 'LIKE', "%" . $_GET['search'] . "%")->skip($start)->take($limit)->get();
            } else {
                $users = User::skip($start)->take($limit)->get();
            }
        }
        $users = User::all();
        return View::make('Admin.users.listUser', compact('users', 'number'));
    }
    public function addNewUser()
    {
        return View::make('Admin.users.addNewUser');
    }
    public function User(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100|min:6|string',
            'email' => "required|max:255|email|unique:users,email",
            'password' => 'required|max:100|min:6|string'
        ]);
        $password = Hash::make($request->password);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
            'role' => $request->role
        ]);
        return redirect()->route('addnewUser')->with('status', 'Created User Successfully');
    }
    public function editUser(int $id)
    {
        $user = User::findOrFail($id);
        return View::make('Admin.users.editUser', compact('user'));
    }
    public function putEditUser(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required|max:100|min:6|string',
            'email' => "required|max:255|email",
        ]);
        User::findOrFail($id)->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        return redirect()->back()->with('status', 'Update User Successfully');

    }
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back();
    }
    public function listComment()
    {
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $count = PostCommentModel::join('posts', 'posts.id', '=', 'post_id')->select('posts_comment.*', 'title')->where('email', 'LIKE', "%" . $_GET['search'] . "%")->orWhere('title', 'LIKE', "%" . $_GET['search'] . "%")->get();
        } else {
            $count = PostCommentModel::get();
        }
        $limit = 10;
        $start = 0;
        $number = ceil(count($count) / $limit);
        if (isset($_GET['page']) && !empty($_GET['page'])) {
            $start = ($_GET['page'] - 1) * $limit;
            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $comments = PostCommentModel::join('posts', 'posts.id', '=', 'post_id')->select('posts_comment.*', 'title')->where('email', 'LIKE', "%" . $_GET['search'] . "%")->orWhere('title', 'LIKE', "%" . $_GET['search'] . "%")->skip($start)->take($limit)->get();
            } else {
                $comments = PostCommentModel::join('posts', 'posts.id', '=', 'post_id')->select('posts_comment.*', 'title')->skip($start)->take($limit)->get();
            }
        } else {
            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $comments = PostCommentModel::join('posts', 'posts.id', '=', 'post_id')->select('posts_comment.*', 'title')->where('email', 'LIKE', "%" . $_GET['search'] . "%")->orWhere('title', 'LIKE', "%" . $_GET['search'] . "%")->skip($start)->take($limit)->get();
            } else {
                $comments = PostCommentModel::join('posts', 'posts.id', '=', 'post_id')->select('posts_comment.*', 'title')->skip($start)->take($limit)->get();
            }
        }
        return View::make('Admin.comment.listCommnet', compact('comments', 'number'));
    }
    public function deleteComment(int $id)
    {
        PostCommentModel::findOrFail($id)->delete();
        return redirect()->back();
    }

}
