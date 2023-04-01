<?php

namespace App\Http\Controllers\Admin\FrontSettings;

use App\Http\Controllers\Controller;
use App\SmAboutPage;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class headerAboutSectionController extends Controller
{
    /**
     * @return Application|Factory|View
     *
     */
    public function index()
    {
        $abouts = SmAboutPage::where('school_id', app('school')->id)->get();
        return view('backEnd.frontSettings.aboutSection.about_section', compact('abouts'));
    }

    /**
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $path = 'public/uploads/about_page/';
            $imageName = imageUploadWithCustomSize($request->image, '1200', '800', $path);
            $about = new SmAboutPage();
            $about->title = $request->title;
            $about->description = $request->description;
            $about->image = $path . $imageName;
            $about->school_id = app('school')->id;
            $about->save();

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed ' . $e, 'Failed');
            return redirect()->back();
        }
    }

    /**
     * @param $id
     * @return Application|Factory|View|RedirectResponse|null
     */
    public function details($id)
    {
        try {
            $abouts = SmAboutPage::where('school_id', app('school')->id)->get();
            $about_details = SmAboutPage::find($id);
            return view('backEnd.frontSettings.aboutSection.about_section', compact('about_details', 'abouts'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    /**
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function forDeleteAbout($id)
    {
        try{
            return view('backEnd.frontSettings.aboutSection.aboutDeleteModal', compact('id'));
        }catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    /**
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id): ?RedirectResponse
    {
        try {
            SmAboutPage::find($id)->delete();
            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    /**
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function edit($id)
    {
        try {
            $abouts = SmAboutPage::where('school_id', app('school')->id)->get();
            $edit_abouts = SmAboutPage::find($id);
            return view('backEnd.frontSettings.aboutSection.about_section', compact('edit_abouts', 'abouts'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    function update(Request $request)
    {
        try {
            $path = 'public/uploads/about_page/';
            $about = SmAboutPage::find($request->id);
            $about->title = $request->title;
            $about->description = $request->description;
            if ($request->image) {
                $about->image = fileUpdate($about->image, $request->image, $path);
            }
            $about->update();
            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
}
