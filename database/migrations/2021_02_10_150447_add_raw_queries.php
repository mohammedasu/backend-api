<?php

use App\Models\Article;
use App\Models\Newsletter;
use App\Models\Video;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRawQueries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            $articles = Article::withTrashed()->get();
            $videos = Video::withTrashed()->get();
            $news = Newsletter::withTrashed()->get();

            $articles->each(function($article){
                $article->article_show = true;
                $article->article_schedule = true;
                $article->save();
            });
            $videos->each(function($video){
                $video->video_show = true;
                $video->video_schedule = true;
                $video->save();
            });
            $news->each(function($news_data){
                $news_data->newsletter_show = true;
                $news_data->newsletter_schedule = true;
                $news_data->save();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
