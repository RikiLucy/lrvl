<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Page;
use App\People;
use App\Portfolio;
use App\Service;

class IndexController extends Controller
{
    //
    public function execute(Request $request){

        if($request->isMethod('post')){

            $msg = [
                'required' => 'Поле обязательно к заполнению',
                'email' => 'Нужен емаил адрес'

            ];
            $this->validate($request, [
                'name' => 'required|max:255',
                'email' => 'required|email',
                'text' => 'required'

            ], $msg);

            dump($request);
        }

        $pages = Page::all();
        $portfolios = Portfolio::get(['name', 'filter', 'images']); //условия ничего не дают
        $peoples = People::take(3)->get();
        $services = Service::where('id', '<', '20')->get();

        $menu = [];
        foreach ($pages as $page) {
            $item = ['title' => $page->name, 'alias' => $page->alias];
            //array_push($menu, $item);
            $menu[] = $item;
        }
        $menu[] = ['title' => 'Services', 'alias' => 'service'];
        $menu[] = ['title' => 'Portfolio', 'alias' => 'Portfolio'];
        $menu[] = ['title' => 'Team', 'alias' => 'team'];
        $menu[] = ['title' => 'Contact', 'alias' => 'contact'];

        //dd($menu);


        return view('site.index', compact('menu', 'pages', 'services', 'portfolios', 'peoples'));
    }
}
