<?php

namespace App\Http\Controllers\Utils;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Media;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = \File::Files('uploads/images');
		foreach($files as $file) {
			$name[]=$file->getPath()."/".$file->getFilename();
		}
		return response()->json(["data"=>$name]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'file' => 'required|file|max:5000|mimes:' . $this->getAllowedFileTypes()
        // ]);
    
        if ( $fileUid = $request->file->store('/upload', 'public') ) {
            return Media::create([
                'type'=>'image',
                'base_url'=>url('/'),
                'in_json'=>json_encode([
                    'images'=>[
                        'small'=>Storage::url($fileUid),
                        'medium'=>Storage::url($fileUid),
                        'big'=>Storage::url($fileUid),
                    ]
                ]),
            ]);

        }
    
        return response(['msg' => 'Unable to upload your file.'], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Media $media)
    {
        return (string) $media->delete();
    }
}