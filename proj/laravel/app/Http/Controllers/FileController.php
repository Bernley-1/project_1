<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use App\Models\Folder;

class FileController extends Controller
{
    public function index()
    {
        $files = File::where('user_id', auth()->id())->get();
        return view('files.index', compact('files'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,png,pdf|max:5120',
            'folder_id' => 'nullable|exists:folders,id',
        ]);

        $path = $request->file('file')->store('uploads', 'public');
        $file = new File();
        $file->user_id = auth()->id();
        $file->folder_id = $request->folder_id;
        $file->name = $request->file('file')->getClientOriginalName();
        $file->path = $path;
        $file->type = $request->file('file')->getMimeType();
        $file->save();

        return redirect()->back()->with('success', 'File uploaded successfully.');
    }

    public function destroy($id)
    {
        $file = File::findOrFail($id);
        $file->delete();

        return redirect()->back()->with('success', 'File deleted successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $files = File::where('user_id', auth()->id())
                     ->where('name', 'LIKE', "%$query%")
                     ->get();
        return view('files.index', compact('files'));
    }

    public function tag(Request $request, $id)
    {
        $file = File::findOrFail($id);
        $tag = new Tag();
        $tag->file_id = $file->id;
        $tag->name = $request->tag;
        $tag->save();

        return redirect()->back()->with('success', 'Tag added successfully.');
    }
}




