<?php

namespace App\Http\Controllers\API\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog\BlogCategory;
use App\Models\Blog\BlogPost;
use App\Models\Blog\BlogTag;
use Illuminate\Http\Request;

class BlogPostController extends Controller
{
    public function posts()
    {
        $posts = BlogPost::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->simplePaginate(request('limit', 9));
        return response()->json([
            'posts' => $posts
        ]);
    }

    public function allBlogPosts()
    {
        $posts = BlogPost::where('status', 'active')
            ->orderBy('id', 'DESC');
        return response()->json([
            'posts' => $posts,
            'count' => $posts->count()
        ]);
    }

    public function postCategories()
    {
        $categories = BlogCategory::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->get();
        return response()->json([
            'postCategories' => $categories
        ]);
    }
    public function blog()
    {
        $post = BlogPost::query();

        if (!empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);

            $cat_ids = BlogCategory::select('id')
                ->whereIn('slug', $slug)->pluck('id')->toArray();
            $post = $post->whereIn('post_cat_id', $cat_ids);
        }
        if (!empty($_GET['tag'])) {
            $slug = explode(',', $_GET['tag']);
            $tag_ids = BlogTag::select('id')->whereIn('slug', $slug)
                ->pluck('id')
                ->toArray();
            $post->where('post_tag_id', $tag_ids);
        }

        if (!empty($_GET['show'])) {
            $post = $post->where('status', 'active')
                ->orderBy('id', 'DESC')->paginate($_GET['show']);
        } else {
            $post = $post->where('status', 'active')
                ->orderBy('id', 'DESC')->paginate(9);
        }
        $rcnt_post = BlogPost::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)->get();
        return view('frontend.pages.blog')->with('posts', $post)
            ->with('recent_posts', $rcnt_post);
    }


    public function postDetail(Request $request)
    {
        $post = BlogPost::getPostBySlug($request->slug);
        $recent_posts = BlogPost::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)->get();
        return response()->json([
            'post' => $post,
            'recent_posts' => $recent_posts

        ]);
    }

    public function postSearch(Request $request)
    {

        $rcnt_post = BlogPost::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(4)
            ->get();
        $posts = BlogPost::orwhere('title', 'like', '%' . $request->search . '%')
            ->orwhere('quote', 'like', '%' . $request->search . '%')
            ->orwhere('summary', 'like', '%' . $request->search . '%')
            ->orwhere('description', 'like', '%' . $request->search . '%')
            ->orwhere('slug', 'like', '%' . $request->search . '%')
            ->orderBy('id', 'DESC')
            ->paginate(8);
        return response()->json([
            'posts' => $posts,
            'comments' => $rcnt_post
        ]);
    }

    public function postFilter(Request $request)
    {
        $data = $request->all();
        // return $data;
        $catURL = "";
        if (!empty($data['category'])) {
            foreach ($data['category'] as $category) {
                if (empty($catURL)) {
                    $catURL .= '&category=' . $category;
                } else {
                    $catURL .= ',' . $category;
                }
            }
        }

        $tagURL = "";
        if (!empty($data['tag'])) {
            foreach ($data['tag'] as $tag) {
                if (empty($tagURL)) {
                    $tagURL .= '&tag=' . $tag;
                } else {
                    $tagURL .= ',' . $tag;
                }
            }
        }
        return redirect()->route('blog', $catURL . $tagURL);
    }

    public function postsByCategory(Request $request)
    {
        $results = BlogCategory::getBlogByCategory($request->category_slug);
        $recent_posts = BlogPost::where('status', 'active')
            ->orderBy('id', 'DESC')->limit(3)->get();
        return response()->json([
            'results' => $results,
            'recent_posts' => $recent_posts
        ]);
    }

    public function postsByTag(Request $request)
    {
        $posts = BlogPost::getBlogByTag($request->tag_slug);
        $recent_comments = BlogPost::where('status', 'active')
            ->orderBy('id', 'DESC')->limit(3)->get();

        return response()->json([
            'posts' => $posts,
            'recent_comments' => $recent_comments
        ]);
    }
}
