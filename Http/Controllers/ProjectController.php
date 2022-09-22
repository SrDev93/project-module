<?php

namespace Modules\Project\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Modules\Base\Entities\Photo;
use Modules\Project\Entities\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $items = Project::all();

        return view('project::index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('project::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $project = Project::create([
                'title' => $request->title,
                'slug' => $request->slug,
                'date' => $request->date,
                'manager' => $request->manager,
                'construct_status' => $request->construct_status,
                'description' => $request->description,
                'image' => (isset($request->image)?file_store($request->image, 'assets/uploads/sliders/images/','photo_'):null)
            ]);

            if (isset($request->photo)){
                foreach ($request->photo as $key => $photo){
                    $p = new Photo();
                    $p->path = file_store($photo, 'assets/uploads/sliders/galleries/','photo_');
                    $p->alt = $request->alt[$key];
                    $project->photo()->save($p);
                }
            }

            return redirect()->route('project.index')->with('flash_message', 'با موفقیت ثبت شد');
        }catch (\Exception $e){
            return redirect()->back()->withInput()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('project::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Project $project)
    {
        return view('project::edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Project $project)
    {
        try {
            $project->title = $request->title;
            $project->slug = $request->slug;
            $project->date = $request->date;
            $project->manager = $request->manager;
            $project->construct_status = $request->construct_status;
            $project->description = $request->description;
            if (isset($request->image)) {
                $project->image = file_store($request->image, 'assets/uploads/sliders/images/', 'photo_');
            }
            $project->save();

            if (isset($request->alt)){
                foreach ($request->alt as $key => $alt){
                    if (isset($request->photo[$key])){
                        if (isset($project->photo[$key])){

                            $project->photo[$key]->path = file_store($request->photo[$key], 'assets/uploads/sliders/galleries/','photo_');
                            $project->photo[$key]->alt = $request->alt[$key];
                            $project->photo[$key]->save();

                        }else{

                            $p = new Photo();
                            $p->path = file_store($request->photo[$key], 'assets/uploads/sliders/galleries/','photo_');
                            $p->alt = $request->alt[$key];
                            $project->photo()->save($p);

                        }
                    }else{
                        if (isset($project->photo[$key])){
                            $project->photo[$key]->alt = $request->alt[$key];
                            $project->photo[$key]->save();
                        }
                    }
                }
            }

            return redirect()->route('project.index')->with('flash_message', 'با موفقیت بروزرسانی شد');
        }catch (\Exception $e){
            return redirect()->back()->withInput()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    public function confirm(Project $project)
    {
        try {
            $project->status = 1;
            $project->save();

            return redirect()->back()->with('flash_message', 'با موفقیت تایید شد');

        }catch (\Exception $e){
            return redirect()->back()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }

    public function photo_delete(Photo $photo)
    {
        try {
            File::delete($photo->path);
            $photo->delete();

            return redirect()->back()->with('flash_message', 'تصویر با موفقیت حذف شد');

        }catch (\Exception $e){
            return redirect()->back()->with('err_message', 'خطایی رخ داده است، لطفا مجددا تلاش نمایید');
        }
    }
}
