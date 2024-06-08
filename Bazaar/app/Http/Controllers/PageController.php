<?php

namespace App\Http\Controllers;

use App\Models\Component;
use App\Models\Advert;
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
                'arguments' => $component->type === 'advertisement' ? $this->getAdvertisementArguments($component->arguments) : json_decode($component->arguments),
            ];

            array_push($components, $parsedComponent);
        }

        $public = true;

        return view('business-page.page', ['page' => $page, 'components' => $components, 'public' => $public]);
    }

    public function getAdvertisementArguments($arguments) {
        $decodedArguments = json_decode($arguments);
        $adverts = Advert::getByIds($decodedArguments->adverts);
        $rowLength = $decodedArguments->rowlength;

        return ["adverts" => $adverts, "rowlength" => $rowLength];
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
        $adverts = $page->user->adverts;

        return view('business-page.page-edit', ['page' => $page, 'components' => $components, 'public' => $public, 'adverts' => $adverts]);
    }

    public function update($slug, Request $request) : RedirectResponse
    {
        if(isset($request->action)) {
            $splitAction = explode('-', $request->action);

            if($splitAction[0] === 'delete') {
                self::deleteComponent($splitAction[1]);
            }

            self::addComponent($slug, $request->action);

            return to_route('page.showEdit', ['slug' => $slug]);
        }

        $landing_page = LandingPage::where('url', $slug)
                ->first();

        $landing_page->primary_light = $request->input('primary-light');
        $landing_page->primary_dark = $request->input('primary-dark');
        $landing_page->save();

        self::updateComponents($request, $landing_page);

        return to_route('page.showEdit', ['slug' => $slug]);
    }

    private function deleteComponent($id) {
        $component = Component::where('id', $id)
            ->first();

        $component->delete();
    }

    private function updateComponents(Request $request, LandingPage $landing_page) {
        self::emptyAdvertisements($landing_page);

        foreach (array_keys($request->all()) as $key) {
            $splitValue = explode('_', $key);

            switch ($splitValue[0]) {
                case 'text':
                    self::updateValue($splitValue[2], $splitValue[1], $request->get($key));
                    break;
                case 'image':
                    self::updateImage($splitValue[2], $splitValue[1], $request, $key);
                    break;
                case 'advertisement':
                    self::updateAdvertisement($splitValue[2], $splitValue[1], $request, $key);
                    break;
            }
        }
    }

    private function emptyAdvertisements(LandingPage $landing_page) {
        $components = $landing_page->components;

        foreach ($components as $component) {
            if($component->type === 'advertisement') {
                $component->arguments = '{"adverts":[]}';
                $component->save();
            }
        }
    }

    private function updateValue($id, $type, $value) {
        $component = Component::where('id', $id)
            ->first();

        $decodedArgs = json_decode($component->arguments);

        $decodedArgs->$type = $value;

        $encodedArgs = json_encode($decodedArgs);
        $component->arguments = $encodedArgs;

        $component->save();
    }

    private function updateImage($id, $type, $request, $key) {
        if($type != 'url') {
            self::updateValue($id, $type, $request->get($key));
            return;
        }

        $request->validate([
            $key => 'image|mimes:jpeg,jpg,png,gif|max:10000',
        ]);

        $component = Component::where('id', $id)->first();
        $landing_page = $component->landing_page;
        $file = $request->file($key);

        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $newFileName = $originalFileName.'.'.$file->getClientOriginalExtension();
        $storePath = 'public/pages/'.$landing_page->id.'/img';

        $file->storeAs($storePath, $newFileName, 'local');

        self::updateValue($id, $type, 'storage/pages/'.$landing_page->id.'/img/'.$file->getClientOriginalName());
    }

    private function updateAdvertisement($id, $type, $request, $key) {
        if($type != 'adverts') {
            self::updateValue($id, $type, $request->get($key));
            return;
        }

        $value = $request->get($key);
        $component = Component::where('id', $id)->first();
        $decodedArgs = json_decode($component->arguments);

        array_push($decodedArgs->$type, $value);

        $encodedArgs = json_encode($decodedArgs);
        $component->arguments = $encodedArgs;

        $component->save();
    }

    public function addComponent($slug, $action)
    {
        $landing_page = LandingPage::where('url', $slug)
            ->first();

        $orderNumber = count(Component::where('landing_page_id', $landing_page->id)->get())+1;

        switch ($action) {
            case 'text':
                $baseArguments = '{"header":"","body":""}';
                 self::createComponent($landing_page, $orderNumber, $action, $baseArguments);
                 break;
            case 'image':
                $baseArguments = '{"url":"","alt":""}';
                self::createComponent($landing_page, $orderNumber, $action, $baseArguments);
                break;
            case 'advertisement':
                $baseArguments = '{"rowlength":"3","adverts":[]}';
                self::createComponent($landing_page, $orderNumber, $action, $baseArguments);
                break;
        }
    }

    private function createComponent($landing_page, $orderNumber, $action, $arguments) {
        $component = Component::create([
            'landing_page_id' => $landing_page->id,
            'type' => $action,
            'arguments' => $arguments,
            'order' => $orderNumber,
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
