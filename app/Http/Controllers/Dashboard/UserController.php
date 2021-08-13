<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\BikeExport;
use App\Exports\UserExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\ImagesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = $request->sort;
        $search = $request->get('search', null);

        $users = User::when($search, function ($query) use ($search) {
            $query->where('email', 'LIKE', "%{$search}%")
                ->orWhere('first_name', 'LIKE', "%{$search}%")
                ->orWhere('last_name', 'LIKE', "%{$search}%")
                ->orWhere('phone', 'LIKE', "%{$search}%");
        })->when(!$sort, function ($q) {
            $q->orderBy('id', 'DESC');
        })->where('status', 1)->sortable()->paginate(10);

        return view('dashboard.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.users.create');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('dashboard.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);
        $data = $request->all();
        $data['status'] = $request->get('status', 0);

        $user->update($data);
        if ($request->file('image_path')) {
            $image = $request->file('image_path');
            $publicDisk = Storage::disk('public');
            $publicDisk->delete('/user_image/' . $id . '/' . $user->image_path);
            $imageFileName = rand(1000000, 99999999999) . Str::slug($image->getClientOriginalName(), '.');
            $filePath = '/user_image/' . $id . '/' . $imageFileName;
            $publicDisk->put($filePath, file_get_contents($image), 'public');
            $user->update(['image_path' => $imageFileName]);
        }
        flash()->success(__('dashboard_success.user_updated'));
        return redirect()->route('users.index', [
            'sort' => $request->sort,
            'direction' => $request->direction,
            'page' => $request->page,
            'search' => $request->search
        ]);
    }


    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id, Request $request)
    {
        $user = User::findOrFail($id);
        $user->status = 0;
        $user->save();

        flash()->success(__('dashboard_success.user_deleted'));
        return redirect()->route('users.index', [
            'sort' => $request->sort,
            'direction' => $request->direction,
            'page' => $request->page,
            'search' => $request->search
        ]);
    }

    /**
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        return (new UserExport())->download('users.xlsx');
    }

}
