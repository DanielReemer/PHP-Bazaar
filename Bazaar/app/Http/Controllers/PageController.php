<?php

namespace App\Http\Controllers;

use App\Models\Component;
use App\Models\LandingPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = LandingPage::where('url', $slug)
            ->first();

        $componentsJSON = $page->components;
        $components = [];

        foreach ($componentsJSON as $component) {
            $parsedComponent = [
                'id' => $component->id,
                'type' => $component->type,
                'arguments' => json_decode($component->arguments),
            ];

            array_push($components, $parsedComponent);
        }

        $public = true;

        return view('business-page.page', ['page' => $page, 'components' => $components, 'public' => $public]);
    }

    public function showEdit($slug)
    {
        $page = LandingPage::where('url', $slug)
            ->first();

        $componentsJSON = $page->components;
        $components = [];

        foreach ($componentsJSON as $component) {
            $parsedComponent = [
                'id' => $component->id,
                'type' => $component->type,
                'arguments' => json_decode($component->arguments),
            ];

            array_push($components, $parsedComponent);
        }

        $public = false;

        return view('business-page.page-edit', ['page' => $page, 'components' => $components, 'public' => $public]);
    }

    public function update($slug, Request $request) : RedirectResponse
    {
        if(isset($request->action)) {
            return self::addComponent($slug, $request->action);
        }

        $landing_page = LandingPage::where('url', $slug)
                ->first();

        $landing_page->primary_light = $request->input('primary-light');
        $landing_page->primary_dark = $request->input('primary-dark');
        $landing_page->save();

        self::updateComponents($request, $landing_page);

        return to_route('page.showEdit', ['slug' => $slug]);
    }

    private function updateComponents(Request $request, LandingPage $landing_page) {
        foreach (array_keys($request->all()) as $key) {
            $splitValue = explode('_', $key);

            switch ($splitValue[0]) {
                case 'text':
                        self::updateText($splitValue[2], $splitValue[1], $request->get($key));
                    break;
            }
        }
    }

    private function updateText($id, $type, $value) {
        $component = Component::where('id', $id)
            ->first();

        $decodedArgs = json_decode($component->arguments);

        $decodedArgs->$type = $value;

        $encodedArgs = json_encode($decodedArgs);
        $component->arguments = $encodedArgs;

        $component->save();
    }

    public function addComponent($slug, $action) : RedirectResponse
    {
        switch ($action) {
            case 'text':
                 self::addTextComponent($slug);
                 break;
        }

        return to_route('page.showEdit', ['slug' => $slug]);
    }

    public function addTextComponent($slug)
    {
        $landing_page = LandingPage::where('url', $slug)
            ->first();

        $component = Component::create([
            'landing_page_id' => $landing_page->id,
            'type' => 'text',
            'arguments' => '{"header":"","body":""}',
        ]);
        $component->save();
    }

    public function updateURL(Request $request) : RedirectResponse
    {
        $request->validateWithBag('updateUrl', [
            'url' => 'nullable|unique:landing_pages|max:100|lowercase|alpha_dash:ascii',
        ]);

        $landingpage = LandingPage::where('id', Auth::user()->landing_page_id)
            ->first();
        $landingpage->url = $request->url;
        $landingpage->update();

        return to_route('profile.edit');
    }
}
