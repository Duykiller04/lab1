<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Image;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index()
    {
        // Lấy tất cả các bình luận của một bài viết cụ thể theo kiểu chỏ sang relation:  $article->comments  
        $allComment = Article::query()->find(1)->comments;

        // Lấy tất cả các đánh giá của một video cụ thể  theo kiểu chỏ sang relation:  $video->ratings
        $allRating = Video::query()->find(1)->ratings;

        // Lấy tất cả các bình luận của một người dùng cụ thể (có thể dùng join or sử dụng relation)
        $allComment = User::query()->find(5)->comments;

        // Lấy trung bình đánh giá của một bài viết cụ thể. Gợi ý: 
        // $article->ratings()->avg('rating')
        $avgRating = Article::query()->find(1)->ratings()->avg('rating');

        // Lấy tất cả các bài viết, video, và hình ảnh được bình luận bởi một người dùng cụ thể .
        // Gợi ý: lấy tất cả comment theo user id, sau đó sử dụng filter của collection để lấy dữ liệu theo từng loại bài viết.
        $commentsByUser = User::query()->find(5)->comments;

        $commentsCollection = collect($commentsByUser);

        // Tất cả bài viết theo user có id = 5
        $articles = $commentsCollection->filter(function ($comment) {
            return $comment->commentable_type == 'App\Models\Article';
        });

        // Tất cả image theo user có id = 5
        $images = $commentsCollection->filter(function ($comment) {
            return $comment->commentable_type == 'App\Models\Image';
        });

        // Tất cả video theo user có id = 5
        $videos = $commentsCollection->filter(function ($comment) {
            return $comment->commentable_type == 'App\Models\Video';
        });


        // Lấy danh sách các bài viết, video, và hình ảnh có đánh giá trung bình cao nhất.
        // Gợi ý:  $topRatedArticles = Article::with(['ratings' => function($query) { 
        //     $query->select(DB::raw('rateable_id, AVG(rating) as average_rating')) 
        //                 ->groupBy('rateable_id') 
        //                 ->orderBy('average_rating', 'desc') 
        //                 ->take(5); 
        //   }])
        //  ->get();


        // Bài viết có đánh giá trung bình cao nhất
        $topRatedArticles = Article::with(['ratings' => function ($query) {
            $query->select(DB::raw('rateable_id, AVG(rating) as average_rating'))
                ->groupBy('rateable_id')
                ->orderBy('average_rating', 'desc');
        }])
            ->first();

        // Video có đánh giá trung bình cao nhất
        $topRatedVideos = Video::with(['ratings' => function ($query) {
            $query->select(DB::raw('rateable_id, AVG(rating) as average_rating'))
                ->groupBy('rateable_id')
                ->orderBy('average_rating', 'desc');
        }])
            ->first();

        // Image có đánh giá trung bình cao nhất
        $topRatedImages = Image::with(['ratings' => function ($query) {
            $query->select(DB::raw('rateable_id, AVG(rating) as average_rating'))
                ->groupBy('rateable_id')
                ->orderBy('average_rating', 'desc');
        }])
            ->first();

        // dd($topRatedImages->toArray());
        // die();
    }
}
