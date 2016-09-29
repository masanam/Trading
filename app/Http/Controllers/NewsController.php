<?php

namespace App\Http\Controllers;

use App\Model\News;

use Illuminate\Http\Request;

use App\Http\Requests;

class NewsController extends Controller
{
	public function news()
	{
		$news = News::orderBy('created_at', 'desc')->first();

		if($news == null || $news->date < date('Y-m-d')){
			$url = 'https://webhose.io/search?token=d6807069-7960-4a91-a10a-945be751c588&format=json&q=business%20finance%20company%20trade%20thread.title%3A(coal)%20language%3A(english)%20(site_type%3Anews)&ts=1464710371001';
			$json = json_decode(file_get_contents($url), true);

			$news = new News;
			$news->date = date('Y-m-d');
			$news->news = json_encode($json['posts']);
			$news->save();
		}

		return response()->json(['success'=>TRUE , json_decode($news->news)], 200);
	}

	public function refreshNews()
	{
		$news = News::orderBy('created_at', 'desc')->first();

		if($news == null || $news->date < date('Y-m-d')) $news = new News;

		$url = 'https://webhose.io/search?token=d6807069-7960-4a91-a10a-945be751c588&format=json&q=business%20finance%20company%20trade%20thread.title%3A(coal)%20language%3A(english)%20(site_type%3Anews)&ts=1464710371001';
		$json = json_decode(file_get_contents($url), true);

		$news->date = date('Y-m-d');
		$news->news = json_encode($json['posts']);
		$news->save();

		return response()->json(['success'=>TRUE , json_decode($news->news)], 200);
	}
}
